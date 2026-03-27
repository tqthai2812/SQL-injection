<?php

namespace App\Models;

use PDO;

class SmartPhone
{
  private PDO $db;

  public int $id = -1;
  public string $name;
  public int $brand_id;
  public float $price;
  public int $discount_percent;
  public ?string $image = null;
  public string $origin;
  public string $release_date;
  public string $warranty;
  public string $processor;
  public string $storage;
  public string $color;
  public float $screen_size;
  public string $screen_technology;
  public string $resolution;
  public string $created_at;
  public string $updated_at;

  public function __construct(PDO $pdo)
  {
    $this->db = $pdo;
  }

  public function all(): array
  {
    $phones = [];

    $statement = $this->db->query('SELECT * FROM phones');
    while ($row = $statement->fetch()) {
      $phone = new SmartPhone($this->db);
      $phone->fillFromDbRow($row);
      $phones[] = $phone;
    }

    return $phones;
  }

  public function alllist(): array
  {
    $phones = [];

    $sql = "SELECT * 
            FROM (
                SELECT *, 
                    ROW_NUMBER() OVER (
                        PARTITION BY name 
                        ORDER BY release_date DESC, id DESC
                    ) AS rn
                FROM phones
            ) AS ranked
            WHERE rn = 1
            ORDER BY release_date DESC, id DESC";

    $statement = $this->db->query($sql);
    while ($row = $statement->fetch()) {
      $phone = new SmartPhone($this->db);
      $phone->fillFromDbRow($row);
      $phones[] = $phone;
    }

    return $phones;
  }

  public function save(): bool
  {
    if ($this->id >= 0) {
      $statement = $this->db->prepare(
        'UPDATE phones 
         SET name = :name, brand_id = :brand_id, price = :price, discount_percent = :discount_percent, 
             image = :image, origin = :origin, release_date = :release_date, warranty = :warranty, 
             processor = :processor, storage = :storage, color = :color, screen_size = :screen_size, 
             screen_technology = :screen_technology, resolution = :resolution, updated_at = NOW() 
         WHERE id = :id'
      );

      return $statement->execute([
        'name' => $this->name,
        'brand_id' => $this->brand_id,
        'price' => $this->price,
        'discount_percent' => $this->discount_percent,
        'image' => $this->image,
        'origin' => $this->origin,
        'release_date' => $this->release_date,
        'warranty' => $this->warranty,
        'processor' => $this->processor,
        'storage' => $this->storage,
        'color' => $this->color,
        'screen_size' => $this->screen_size,
        'screen_technology' => $this->screen_technology,
        'resolution' => $this->resolution,
        'id' => $this->id
      ]);
    } else {
      $statement = $this->db->prepare(
        'INSERT INTO phones 
         (name, brand_id, price, discount_percent, image, origin, release_date, warranty, processor, 
          storage, color, screen_size, screen_technology, resolution, created_at, updated_at) 
         VALUES (:name, :brand_id, :price, :discount_percent, :image, :origin, :release_date, :warranty, 
                 :processor, :storage, :color, :screen_size, :screen_technology, :resolution, NOW(), NOW())'
      );

      $result = $statement->execute([
        'name' => $this->name,
        'brand_id' => $this->brand_id,
        'price' => $this->price,
        'discount_percent' => $this->discount_percent,
        'image' => $this->image,
        'origin' => $this->origin,
        'release_date' => $this->release_date,
        'warranty' => $this->warranty,
        'processor' => $this->processor,
        'storage' => $this->storage,
        'color' => $this->color,
        'screen_size' => $this->screen_size,
        'screen_technology' => $this->screen_technology,
        'resolution' => $this->resolution,
      ]);

      if ($result) {
        $this->id = $this->db->lastInsertId();
      }

      return $result;
    }
  }

  public function delete(): bool
  {
    $statement = $this->db->prepare(
      'DELETE FROM phones WHERE id = :id'
    );
    return $statement->execute(['id' => $this->id]);
  }

  public function fill(array $data): SmartPhone
  {
    $this->name = $data['name'] ?? '';
    $this->brand_id = intval($data['brand_id'] ?? 0);
    $this->price = floatval($data['price'] ?? 0);
    $this->discount_percent = intval($data['discount_percent'] ?? 0);
    $this->image = $data['image'] ?? null;
    $this->origin = $data['origin'] ?? '';
    $this->release_date = $data['release_date'] ?? '';
    $this->warranty = $data['warranty'] ?? '';
    $this->processor = $data['processor'] ?? '';
    $this->storage = $data['storage'] ?? '';
    $this->color = $data['color'] ?? '';
    $this->screen_size = floatval($data['screen_size'] ?? 0);
    $this->screen_technology = $data['screen_technology'] ?? '';
    $this->resolution = $data['resolution'] ?? '';
    return $this;
  }

  public function validate(array $data): array
  {
    $errors = [];

    if (empty(trim($data['name'] ?? ''))) {
      $errors['name'] = 'Tên điện thoại không hợp lệ.';
    }

    if (empty(trim($data['brand_id'] ?? ''))) {
      $errors['brand_id'] = 'Nhãn hiệu không hợp lệ.';
    }

    if (!is_numeric($data['price']) || $data['price'] <= 0) {
      $errors['price'] = 'Giá không hợp lệ.';
    }

    if ($data['discount_percent'] < 0 || $data['discount_percent'] > 100) {
      $errors['discount_percent'] = 'Phần trăm giảm giá phải từ 0 đến 100.';
    }

    if (strlen(trim($data['warranty'] ?? '')) > 50) {
      $errors['warranty'] = 'Thông tin bảo hành không hợp lệ.';
    }

    if (strlen(trim($data['processor'] ?? '')) > 100) {
      $errors['processor'] = 'Thông tin chip xử lý quá dài.';
    }

    if (strlen(trim($data['storage'] ?? '')) > 50) {
      $errors['storage'] = 'Dung lượng không hợp lệ.';
    }

    if (!is_numeric($data['screen_size']) || $data['screen_size'] <= 0) {
      $errors['screen_size'] = 'Kích thước màn hình không hợp lệ.';
    }

    if (strlen(trim($data['screen_technology'] ?? '')) > 50) {
      $errors['screen_technology'] = 'Công nghệ màn hình không hợp lệ.';
    }

    if (strlen(trim($data['resolution'] ?? '')) > 20) {
      $errors['resolution'] = 'Độ phân giải không hợp lệ.';
    }

    return $errors;
  }

  private function fillFromDbRow(array $row): SmartPhone
  {
    $this->id = $row['id'] ?? -1;
    $this->name = $row['name'] ?? '';
    $this->brand_id = intval($row['brand_id'] ?? 0);
    $this->price = floatval($row['price'] ?? 0);
    $this->discount_percent = intval($row['discount_percent'] ?? 0);
    $this->image = $row['image'] ?? null;
    $this->origin = $row['origin'] ?? '';
    $this->release_date = $row['release_date'] ?? '';
    $this->warranty = $row['warranty'] ?? '';
    $this->processor = $row['processor'] ?? '';
    $this->storage = $row['storage'] ?? '';
    $this->color = $row['color'] ?? '';
    $this->screen_size = floatval($row['screen_size'] ?? 0);
    $this->screen_technology = $row['screen_technology'] ?? '';
    $this->resolution = $row['resolution'] ?? '';
    $this->created_at = $row['created_at'] ?? '';
    $this->updated_at = $row['updated_at'] ?? '';

    return $this;
  }

  public function getDiscountedPhones()
  {
    $sql = "WITH RankedPhones AS (
                SELECT *, 
                       ROW_NUMBER() OVER (
                           PARTITION BY name 
                           ORDER BY discount_percent DESC, id DESC
                       ) AS rn
                FROM phones
            )
            SELECT * FROM RankedPhones 
            WHERE rn = 1 
            ORDER BY discount_percent DESC, id DESC
            LIMIT 10";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getPhonesUnderPrice($maxPrice)
  {
    $sql = "SELECT *
              FROM (
                  SELECT *, 
                      ROW_NUMBER() OVER (
                          PARTITION BY name 
                          ORDER BY (price * (1 - discount_percent / 100)) DESC, 
                          id DESC
                      ) AS rn
                  FROM phones
                  WHERE price < ?
              ) AS ranked
              WHERE rn = 1";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$maxPrice]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  public function findVariant(string $name, string $storage, string $color): ?SmartPhone
  {
    $stmt = $this->db->prepare("
          SELECT * 
          FROM phones 
          WHERE name = :name 
          AND storage = :storage 
          AND color = :color 
          LIMIT 1
      ");

    $stmt->execute([
      ':name' => $name,
      ':storage' => $storage,
      ':color' => $color
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      $variant = new SmartPhone($this->db);
      $variant->fillFromDbRow($row);
      return $variant;
    }

    return null;
  }

  public function getUniqueOptions(string $column, string $productName): array
  {
    $allowedColumns = ['storage', 'color'];
    if (!in_array($column, $allowedColumns)) {
      return [];
    }

    $stmt = $this->db->prepare("
          SELECT DISTINCT {$column}
          FROM phones
          WHERE name = ?
      ");

    $stmt->execute([$productName]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }
  public function find(int $id): ?SmartPhone
  {
    $statement = $this->db->prepare("SELECT * FROM phones WHERE id = :id");
    $statement->execute(['id' => $id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      $phone = new SmartPhone($this->db);
      $phone->fillFromDbRow($row);
      return $phone;
    }
    return null;
  }

  public function search(string $search = '', string $price_range = '', string $storage = ''): array
  {
    $search = trim($search);
    $query = "SELECT phones.* FROM phones 
              LEFT JOIN brands ON phones.brand_id = brands.id 
              WHERE (SOUNDEX(phones.name) = SOUNDEX(:search) 
                     OR SOUNDEX(brands.name) = SOUNDEX(:search) 
                     OR phones.name LIKE :likeSearch 
                     OR brands.name LIKE :likeSearch)";

    $params = [
      ':search' => $search,
      ':likeSearch' => '%' . preg_replace('/\s+/', '%', $search) . '%'
    ];

    $priceRanges = [
      'under-5m' => ['max' => 5000000],
      '5m-10m' => ['min' => 5000000, 'max' => 10000000],
      '10m-15m' => ['min' => 10000000, 'max' => 15000000],
      'above-15m' => ['min' => 15000000]
    ];

    if (!empty($price_range) && isset($priceRanges[$price_range])) {
      if (isset($priceRanges[$price_range]['min'])) {
        $query .= " AND phones.price >= :priceMin";
        $params[':priceMin'] = $priceRanges[$price_range]['min'];
      }
      if (isset($priceRanges[$price_range]['max'])) {
        $query .= " AND phones.price <= :priceMax";
        $params[':priceMax'] = $priceRanges[$price_range]['max'];
      }
    }

    if (!empty($storage)) {
      $query .= " AND phones.storage = :storage";
      $params[':storage'] = $storage;
    }

    $query .= " ORDER BY phones.price ASC";

    $stmt = $this->db->prepare($query);
    $stmt->execute($params);

    $results = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $phone = new SmartPhone($this->db);
      $phone->fillFromDbRow($row);
      $results[] = $phone;
    }

    return $results;
  }

  public function getBrandName(): string
  {
    $stmt = $this->db->prepare("SELECT name FROM brands WHERE id = :brand_id");
    $stmt->execute(['brand_id' => $this->brand_id]);
    return $stmt->fetchColumn() ?: 'Unknown Brand';
  }
  public function getPhonesByBrand($brandName)
  {
    $stmt = $this->db->prepare("
        WITH RankedPhones AS (
            SELECT phones.*, 
                   ROW_NUMBER() OVER (PARTITION BY phones.name ORDER BY phones.id) AS rn
            FROM phones
            INNER JOIN brands ON phones.brand_id = brands.id
            WHERE brands.name = :brandName
        )
        SELECT * FROM RankedPhones WHERE rn = 1
    ");

    $stmt->execute(['brandName' => $brandName]);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function getLatestReleasedPhones($limit)
  {
    if (!is_int($limit) || $limit < 1) {
      throw new \InvalidArgumentException("Giá trị limit phải là số nguyên dương.");
    }

    $countSql = "SELECT COUNT(DISTINCT name) AS total FROM phones";
    $countStmt = $this->db->prepare($countSql);
    $countStmt->execute();
    $totalNames = $countStmt->fetchColumn();

    $finalLimit = ($totalNames < $limit) ? $totalNames : $limit;

    $sql = "SELECT * 
            FROM (
                SELECT *, 
                    ROW_NUMBER() OVER (
                        PARTITION BY name 
                        ORDER BY release_date DESC, id DESC
                    ) AS rn
                FROM phones
            ) AS ranked
            WHERE rn = 1
            ORDER BY release_date DESC, id DESC
            LIMIT :limit";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':limit', $finalLimit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findPhoneId(
    string $productName,
    string $storage,
    string $color
  ): ?int {
    try {
      // Chuẩn bị truy vấn SQL tối ưu chỉ lấy ID
      $stmt = $this->db->prepare(
        "SELECT id 
             FROM phones 
             WHERE name = :name 
             AND storage = :storage 
             AND color = :color 
             LIMIT 1"
      );

      // Bind các tham số và thực thi
      $stmt->execute([
        ':name'    => $productName,
        ':storage' => $storage,
        ':color'   => $color
      ]);

      // Trả về ID hoặc null nếu không tìm thấy
      return $stmt->fetchColumn() ?: null;
    } catch (\PDOException $e) {
      error_log("Lỗi database khi tìm ID: " . $e->getMessage());
      return null;
    }
  }

  public function getFilteredOptions($field, $productName, $filters = [])
  {
    $sql = "SELECT DISTINCT $field FROM phones WHERE name = :name";
    $params = [':name' => $productName];

    foreach ($filters as $key => $value) {
      if (!empty($value)) {
        $sql .= " AND $key = :$key";
        $params[":$key"] = $value;
      }
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }
}
