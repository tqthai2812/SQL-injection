<?php

namespace App\Models;

use PDO;

class User
{
  private PDO $db;

  public int $id = -1;
  public string $email;
  public string $name;
  public string $password;
  public string $role = 'user';
  public string $created_at;

  public function __construct(PDO $pdo)
  {
    $this->db = $pdo;
  }

  public function where(string $column, string $value): ?User
  {
    $allowedColumns = ['id', 'email', 'name'];
    if (!in_array($column, $allowedColumns)) {
      throw new \InvalidArgumentException("Cột không hợp lệ: " . htmlspecialchars($column));
    }

    $statement = $this->db->prepare("SELECT * FROM users WHERE $column = :value LIMIT 1");
    $statement->execute(['value' => $value]);
    $row = $statement->fetch();

    if (!$row) {
      return null;
    }

    $user = new User($this->db);
    $user->fillFromDbRow($row);

    return $user;
  }



  public function save(): bool
  {
    $result = false;

    if ($this->id >= 0) {
      $statement = $this->db->prepare(
        'UPDATE users SET email = :email, name = :name, password = :password, role = :role,
         updated_at = NOW() WHERE id = :id'
      );
      $result = $statement->execute([
        'id' => $this->id,
        'email' => $this->email,
        'name' => $this->name,
        'password' => $this->password,
        'role' => $this->role
      ]);
    } else {
      $statement = $this->db->prepare(
        'INSERT INTO users (email, name, password, role, created_at, updated_at)
         VALUES (:email, :name, :password, :role, NOW(), NOW())'
      );
      $result = $statement->execute([
        'email' => $this->email,
        'name' => $this->name,
        'password' => $this->password,
        'role' => $this->role
      ]);

      if ($result) {
        $this->id = $this->db->lastInsertId();
      }
    }

    return $result;
  }

  public function fill(array $data): User
  {
    $this->email = $data['email'];
    $this->name = $data['name'];
    $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
    $this->role = $data['role'] ?? 'user';
    return $this;
  }

  private function fillFromDbRow(array $row)
  {
    $this->id = $row['id'];
    $this->email = $row['email'];
    $this->name = $row['name'];
    $this->password = $row['password'];
    $this->role = $row['role'] ?? 'user';
    $this->created_at = $row['created_at'];
  }

  private function isEmailInUse(string $email): bool
  {
    $statement = $this->db->prepare('select count(*) from users where email = :email');
    $statement->execute(['email' => $email]);
    return $statement->fetchColumn() > 0;
  }

  public function validate(array $data): array
  {
    $errors = [];

    if (!$data['email']) {
      $errors['email'] = 'Invalid email.';
    } elseif ($this->isEmailInUse($data['email'])) {
      $errors['email'] = 'Email already in use.';
    }

    if (strlen($data['password']) < 6) {
      $errors['password'] = 'Password must be at least 6 characters.';
    } elseif ($data['password'] != $data['password_confirmation']) {
      $errors['password'] = 'Password confirmation does not match.';
    }

    return $errors;
  }
  public function isAdmin(): bool
  {
    return $this->role === 'admin';
  }

  public function all(): array
  {
    $users = [];

    $statement = $this->db->query('SELECT * FROM users');
    while ($row = $statement->fetch()) {
      $user = new User($this->db);
      $user->fillFromDbRow($row);
      $users[] = $user;
    }

    return $users;
  }
}
