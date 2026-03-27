<?php

namespace App\Models;

use PDO;

class Brand
{
  private PDO $db;

  public int $id = -1;
  public string $name;
  public ?string $image = null;

  public function __construct(PDO $pdo)
  {
    $this->db = $pdo;
  }

  public function all(): array
  {
    $statement = $this->db->query("SELECT * FROM brands");
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  public function save(): bool
  {
    if ($this->id >= 0) {
      $statement = $this->db->prepare(
        'UPDATE brands SET name = :name, image = :image WHERE id = :id'
      );
      return $statement->execute([
        'name' => $this->name,
        'image' => $this->image,
        'id' => $this->id
      ]);
    } else {
      $statement = $this->db->prepare(
        'INSERT INTO brands (name, image) VALUES (:name, :image)'
      );
      $result = $statement->execute([
        'name' => $this->name,
        'image' => $this->image
      ]);
      if ($result) {
        $this->id = $this->db->lastInsertId();
      }
      return $result;
    }
  }

  public function delete(): bool
  {
    $statement = $this->db->prepare('DELETE FROM brands WHERE id = :id');
    return $statement->execute(['id' => $this->id]);
  }

  public function find(int $id): ?Brand
  {
    $statement = $this->db->prepare('SELECT * FROM brands WHERE id = :id');
    $statement->execute(['id' => $id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    if ($row) {
      $brand = new Brand($this->db);
      $brand->id = $row['id'];
      $brand->name = $row['name'];
      $brand->image = $row['image'];
      return $brand;
    }
    return null;
  }

  public function validate(array $data): array
  {
    $errors = [];
    if (empty(trim($data['name'] ?? ''))) {
      $errors['name'] = 'Tên thương hiệu không được để trống.';
    }
    return $errors;
  }
}
