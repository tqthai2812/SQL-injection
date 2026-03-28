<?php

namespace App\Controllers\User;

use App\Models\Brand;
use App\Models\Smartphone;
use App\Models\User;
use App\Models\Cart;

class UserController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $smartphoneModel = new Smartphone(PDO());
    $discountedPhones = $smartphoneModel->getDiscountedPhones();
    $newPhones = $smartphoneModel->getLatestReleasedPhones(10);

    $this->sendPage('content/index', [
      'discountedPhones' => $discountedPhones,
      'newPhones' => $newPhones
    ]);
  }

  public function info()
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }

    if (!isset($_SESSION['user_id'])) {
      http_response_code(403);
      echo "Bạn chưa đăng nhập.";
      return;
    }

    $userId = $_SESSION['user_id'];

    $userModel = new User(PDO());
    $user = $userModel->where('id', $userId);

    if ($user === null) {
      http_response_code(404);
      echo "Không tìm thấy thông tin người dùng.";
      return;
    }

    $this->sendPage('content/info', ['user' => $user]);
  }

  public function productlist()
  {
    $smartphoneModel = new Smartphone(PDO());
    $phones = $smartphoneModel->alllist();
    $discountedPhones = $smartphoneModel->getDiscountedPhones();

    $brandModel = new Brand(PDO());
    $brands = $brandModel->all();

    $this->sendPage('content/product-list', [
      'phones' => $phones,
      'discountedPhones' => $discountedPhones,
      'brands' => $brands
    ]);
  }

  public function productbrand($brandName)
  {
    $smartphoneModel = new Smartphone(PDO());
    $phones = $smartphoneModel->getPhonesByBrand($brandName);

    $this->sendPage('content/product-brand', [
      'phones' => $phones,
      'brandName' => $brandName
    ]);
  }

  public function search()
  {
    $search = $_GET['search'] ?? '';
    $search = trim($search);
    $price_range = $_GET['price_range'] ?? '';
    $storage = $_GET['storage'] ?? '';

    $stmt = PDO()->query("SELECT * FROM brands");
    $brands = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    if (empty($search) && empty($price_range) && empty($storage)) {
      $smartphoneModel = new Smartphone(PDO());
      $phones = $smartphoneModel->alllist();
      $this->sendPage('content/product-list', [
        'phones' => $phones,
        'search' => $search,
        'brands' => $brands,
        'error' => 'Vui lòng nhập từ khóa hoặc chọn bộ lọc.'
      ]);
      return;
    }

    $smartphoneModel = new Smartphone(PDO());
    $phones = $smartphoneModel->search($search, $price_range, $storage);

    if (empty($phones)) {
      $this->sendPage('content/product-list', [
        'phones' => [],
        'search' => $search,
        'brands' => $brands,
        'error' => 'Không tìm thấy sản phẩm nào phù hợp.'
      ]);
      return;
    }

    $this->sendPage('content/product-list', [
      'phones' => $phones,
      'search' => $search,
      'brands' => $brands,
      'error' => null
    ]);
  }

  public function product($id)
  {
    try {
      $phoneId = (int)$id;
      if ($phoneId <= 0) {
        throw new \InvalidArgumentException("ID sản phẩm không hợp lệ");
      }

      $smartphone = new SmartPhone(PDO());
      $phone = $smartphone->find($phoneId);

      if (!$phone || $phone->id === -1) {
        $this->sendNotFound();
        return;
      }

      $selectedStorage = $_GET['storage'] ?? $phone->storage;
      $selectedColor = $_GET['color'] ?? $phone->color;

      $selectedStoragetemp = $_GET['storage'] ?? 'daykhongphailadungluongdaykhongphailadungluong';
      $selectedColortemp = $_GET['color'] ?? 'daykhongphailamausatdaykhongphailamausat';

      $storages = $smartphone->getUniqueOptions('storage', $phone->name);

      if (!in_array($selectedStorage, $storages)) {
        $selectedStorage = $storages[0] ?? $phone->storage;
        redirect("/product/{$phone->id}?storage={$selectedStorage}&color={$selectedColor}");
        return;
      }

      $colors = $smartphone->getFilteredOptions(
        'color',
        $phone->name,
        ['storage' => $selectedStorage]
      );

      $idtemp = $smartphone->findPhoneId($phone->name, $selectedStorage, $selectedColor);
      if (in_array($selectedColortemp, $colors) && in_array($selectedStoragetemp, $storages)) {
        redirect("/product/{$idtemp}");
        return;
      }

      if (!in_array($selectedColor, $colors)) {
        $selectedColor = $colors[0] ?? $phone->color;
        $variant = $smartphone->findVariant(
          $phone->name,
          $selectedStorage,
          $selectedColor
        );
        if ($variant && $variant->id !== $phone->id) {
          redirect("/product/{$variant->id}?storage={$selectedStorage}&color={$selectedColor}");
          return;
        }
      }

      $discountedPrice = $phone->price * (1 - $phone->discount_percent / 100);
      $brandName = $phone->getBrandName();

      $this->sendPage('content/product', [
        'phone' => $phone,
        'storages' => $storages,
        'colors' => $colors,
        'selectedStorage' => $selectedStorage,
        'selectedColor' => $selectedColor,
        'discountedPrice' => $discountedPrice,
        'originalPrice' => $phone->price,
        'brandName' => $brandName
      ]);
    } catch (\PDOException $e) {
      error_log("Lỗi database: " . $e->getMessage());
      // $this->show500();
    } catch (\Exception $e) {
      error_log("Lỗi hệ thống: " . $e->getMessage());
      $this->sendNotFound();
    }
  }
  public function cart()
  {
    $userId = $_SESSION['user_id'] ?? null;

    $cartModel = new Cart(PDO());
    $cartItems = $cartModel->getCartItems($userId);
    $cart = $cartModel->getCart($userId);
    $this->sendPage('content/cart', [
      'cartItems' => $cartItems,
      'cart' => $cart
    ]);
  }
  public function addToCart()
  {
    session_start();
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($csrfToken)) {
      http_response_code(403);
      echo "CSRF token không hợp lệ.";
      exit;
    }
    $userId = $_SESSION['user_id'] ?? null;
    $productId = $_POST['product_id'] ?? null;
    $productPrice = $_POST['product_price'] ?? 0;
    $productColor = $_POST['product_color'] ?? '';
    $productStorage = $_POST['product_storage'] ?? '';
    $quantity = 1;

    if (!$userId) {
      http_response_code(403);
      $_SESSION['error_message'] = "Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.";
      header("Location: /product/{$productId}");
      exit;
    }

    if (!$productId || !$productPrice || !$productColor || !$productStorage) {
      http_response_code(400);
      $_SESSION['error_message'] = "Thông tin sản phẩm không hợp lệ.";
      header("Location: /product/{$productId}");
      exit;
    }

    $cartModel = new Cart(PDO());
    $cartModel->addItem($userId, $productId, $productPrice, $productColor, $productStorage, $quantity);

    $_SESSION['success_message'] = "Sản phẩm đã được thêm vào giỏ hàng thành công!";

    header("Location: /product/{$productId}");
    exit;
  }

  public function removeFromCart()
  {
    session_start();
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
      http_response_code(403);
      echo "Bạn cần đăng nhập để xóa sản phẩm khỏi giỏ hàng.";
      return;
    }

    $productId = $_POST['product_id'] ?? null;
    $productColor = $_POST['product_color'] ?? '';
    $productStorage = $_POST['product_storage'] ?? '';

    if (!$productId || !$productColor || !$productStorage) {
      http_response_code(400);
      echo "Thông tin sản phẩm không hợp lệ.";
      return;
    }

    $cartModel = new Cart(PDO());
    $cartModel->removeItem($userId, $productId, $productColor, $productStorage);

    header("Location: /cart");
    exit;
  }

  public function clearCart()
  {
    session_start();
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
      http_response_code(403);
      echo "Bạn cần đăng nhập để xóa giỏ hàng.";
      return;
    }

    $cartModel = new Cart(PDO());
    $cartModel->clearCart($userId);

    header("Location: /cart");
    exit;
  }

  public function updateCartQuantityByAction()
  {
    session_start();
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($csrfToken)) {
      http_response_code(403);
      echo "CSRF token không hợp lệ.";
      exit;
    }
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
      http_response_code(403);
      echo "Bạn cần đăng nhập để thay đổi số lượng sản phẩm.";
      return;
    }

    $cartItemId = $_POST['cart_item_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$cartItemId || !in_array($action, ['increase', 'decrease'])) {
      http_response_code(400);
      echo "Thông tin không hợp lệ.";
      return;
    }

    $cartModel = new Cart(PDO());
    $cartModel->updateItemQuantityByAction($userId, $cartItemId, $action);

    header("Location: /cart");
    exit;
  }

  public function labSqli()
  {
    // Lấy ID từ URL (mặc định là 1 nếu không có)
    $id = isset($_GET['id']) ? $_GET['id'] : 1;

    $product = null;
    $sql_error = null;

    try {
      // 1. TỰ TẠO KẾT NỐI PDO ĐỘC LẬP TẠI ĐÂY
      $host = '127.0.0.1';
      $username = 'root';
      $password = ''; // Thường XAMPP mặc định pass rỗng
      $dbname = 'phonex'; // ⚠️ NHỚ THAY BẰNG TÊN DATABASE CHỨA BẢNG PHONES CỦA BẠN

      // Khởi tạo PDO
      $pdo = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
      $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

      // 2. ĐOẠN CODE GÂY LỖI: Nối thẳng biến $id vào chuỗi SQL
      $sql = "SELECT id, name, brand_id, price, discount_percent, image, origin, release_date, warranty, processor, storage, color, screen_size, screen_technology, resolution, created_at, updated_at FROM phones WHERE id = " . $id;

      // 3. Thực thi truy vấn
      $stmt = $pdo->query($sql);
      if ($stmt) {
        $product = $stmt->fetch(\PDO::FETCH_ASSOC);
      }
    } catch (\PDOException $e) {
      // Bắt lỗi SQL để in ra View
      $sql_error = $e->getMessage();
    }

    // Render ra view vulnerable_lab.php
    echo $this->view->render('content/vulnerable_lab', [
      'product' => $product,
      'sql_error' => $sql_error
    ]);
  }
}
