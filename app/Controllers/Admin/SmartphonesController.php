<?php

namespace App\Controllers\Admin;

use App\Models\SmartPhone;

class SmartphonesController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $smartphoneModel = new SmartPhone(PDO());
    $smartphones = $smartphoneModel->all();

    $this->sendPage('content/index', [
      'smartphones' => $smartphones
    ]);
  }

  public function create()
  {
    $brands = $this->getBrands(); 

    $this->sendPage('content/create', [
      'errors' => session_get_once('errors'),
      'old' => $this->getSavedFormValues(),
      'brands' => $brands
    ]);
  }

  public function store()
  {
    session_start();
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($csrfToken)) {
        http_response_code(403);
        echo "CSRF token không hợp lệ.";
        exit;
    }
    $data = $this->filterSmartphoneData($_POST);
    $newSmartphone = new SmartPhone(PDO());
    $model_errors = $newSmartphone->validate($data);

    if (empty($model_errors)) {
      $newSmartphone->fill($data)->save();
      $_SESSION['success_Mess'] = 'Bạn đã thêm điện thoại thành công';
      redirect('/admin/products');
    }

    $this->saveFormValues($_POST);
    redirect('/admin/create', ['errors' => $model_errors]);
  }

  public function edit($phoneId)
  {
    $smartphoneModel = new SmartPhone(PDO());
    $smartphone = $smartphoneModel->find($phoneId);
    if (!$smartphone) {
      $this->sendNotFound();
    }

    $brands = $this->getBrands();
    $form_values = $this->getSavedFormValues();

    $data = [
      'errors' => session_get_once('errors'),
      'old' => $form_values,
      'data' => (!empty($form_values)) ?
        array_merge($form_values, ['id' => $smartphone->id]) :
        (array) $smartphone,
      'brands' => $brands
    ];

    $this->sendPage('content/edit', $data);
  }

  public function update($phoneId)
  {
    session_start();
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($csrfToken)) {
        http_response_code(403);
        echo "CSRF token không hợp lệ.";
        exit;
    }
    $smartphoneModel = new SmartPhone(PDO());
    $smartphone = $smartphoneModel->find($phoneId);
    if (!$smartphone) {
      $this->sendNotFound();
    }

    $data = $this->filterSmartphoneData($_POST);
    $model_errors = $smartphone->validate($data);

    if (empty($model_errors)) {
      $smartphone->fill($data)->save();
      $_SESSION['success_Mess'] = 'Bạn đã cập nhật điện thoại thành công';
      redirect('/admin/products');
    }

    $this->saveFormValues($_POST);
    redirect('/admin/edit/' . $phoneId, ['errors' => $model_errors]);
  }

  public function destroy($phoneId)
  {
    $smartphoneModel = new SmartPhone(PDO());
    $smartphone = $smartphoneModel->find($phoneId);

    if (!$smartphone) {
      $this->sendNotFound();
    }

    $imagePath = __DIR__ . '/../../../public/' . ltrim($smartphone->image, '/');
    if ($imagePath && file_exists($imagePath)) {
      unlink($imagePath);
    }

    $smartphone->delete();

    $_SESSION['success_Mess'] = 'Bạn đã xóa điện thoại thành công';
    redirect('/admin/products');
  }

  protected function filterSmartphoneData(array $data)
  {
    $imagePath = $data['existing_image'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = __DIR__ . '/../../../public/uploads/';

      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
      }

      $fileName = time() . '_' . basename($_FILES['image']['name']);
      $imagePath = '/uploads/' . $fileName;

      $destination = $uploadDir . $fileName;

      if (!move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
        $imagePath = '';
      }
    }

    return [
      'name' => $data['name'] ?? '',
      'brand_id' => $data['brand_id'] ?? '',
      'price' => $data['price'] ?? '',
      'discount_percent' => $data['discount_percent'] ?? 0,
      'image' => $imagePath ?: ($data['image'] ?? ''),
      'origin' => $data['origin'] ?? '',
      'release_date' => $data['release_date'] ?? '',
      'warranty' => $data['warranty'] ?? '',
      'processor' => $data['processor'] ?? '',
      'storage' => $data['storage'] ?? '',
      'color' => $data['color'] ?? '',
      'screen_size' => $data['screen_size'] ?? '',
      'screen_technology' => $data['screen_technology'] ?? '',
      'resolution' => $data['resolution'] ?? '',
    ];
  }

  private function getBrands()
  {
    $stmt = PDO()->query("SELECT id, name FROM brands");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
