# Changelog - Pembaruan Brand Nanas Home Studio

Dokumen ini mencatat detail seluruh perubahan (changelog) yang dilakukan dalam pembaruan nama brand agensi pada proyek NanasCMS dari **Nanas Digital Studio** menjadi **Nanas Home Studio**.

## Ringkasan Perubahan

| Berkas | Jenis Perubahan | Detail Perubahan | Link Berkas |
| :--- | :--- | :--- | :--- |
| `app/Views/layout/footer.php` | Modifikasi | Mengubah nama brand default di bagian copyright footer. | [footer.php](file:///var/www/html/nanascms/app/Views/layout/footer.php#L120) |
| `app/Controllers/HomeController.php` | Modifikasi | Mengubah nama brand di dalam kutipan data testimoni. | [HomeController.php](file:///var/www/html/nanascms/app/Controllers/HomeController.php#L83) |
| `app/Views/dashboard/index.php` | Modifikasi | Mengubah pesan sambutan pengguna di panel dashboard. | [index.php](file:///var/www/html/nanascms/app/Views/dashboard/index.php#L14) |
| `app/Controllers/UserController.php` | Modifikasi | Mengubah nilai `companyName` bawaan pada form tambah dan edit user. | [UserController.php](file:///var/www/html/nanascms/app/Controllers/UserController.php#L45) |
| `app/Controllers/CategoryController.php` | Modifikasi | Mengubah nilai `companyName` bawaan pada form tambah dan edit kategori. | [CategoryController.php](file:///var/www/html/nanascms/app/Controllers/CategoryController.php#L36) |
| `app/Controllers/AuthController.php` | Modifikasi | Mengubah nama perusahaan default di form registrasi. | [AuthController.php](file:///var/www/html/nanascms/app/Controllers/AuthController.php#L58) |
| `implementation_plan.md` | Modifikasi | Memperbarui penyebutan nama di dokumen rancangan beranda lokal. | [implementation_plan.md](file:///var/www/html/nanascms/implementation_plan.md#L3) |

---

## Detail Perubahan Kode (Diff)

### 1. Kaki Halaman (Footer View)
```diff
-            <p>&copy; <?= date('Y') ?> <?= $companyName ?? 'Nanas Digital Studio' ?>. Hak cipta dilindungi.</p>
+            <p>&copy; <?= date('Y') ?> <?= $companyName ?? 'Nanas Home Studio' ?>. Hak cipta dilindungi.</p>
```

### 2. HomeController (Testimonial Data)
```diff
-                    'quote' => 'Nanas Digital Studio melampaui seluruh ekspektasi kami. Desain barunya sangat modern dan meningkatkan konversi penjualan kami hingga 45%!',
+                    'quote' => 'Nanas Home Studio melampaui seluruh ekspektasi kami. Desain barunya sangat modern dan meningkatkan konversi penjualan kami hingga 45%!',
```

### 3. Dashboard View (Greeting Message)
```diff
-                    Anda masuk sebagai <strong class="text-white"><?= htmlspecialchars($user['role_name']) ?></strong>. Selamat mengelola portal kreatif Nanas Digital Studio.
+                    Anda masuk sebagai <strong class="text-white"><?= htmlspecialchars($user['role_name']) ?></strong>. Selamat mengelola portal kreatif Nanas Home Studio.
```

### 4. UserController (Default Company Name)
```diff
@@ -42,7 +42,7 @@
         }
 
         $this->view('users/create', [
-            'companyName' => 'Nanas Digital Studio',
+            'companyName' => 'Nanas Home Studio',
             'tagline' => 'Tambah User Baru',
             'roles' => $roles
         ]);
@@ -127,7 +127,7 @@
         }
 
         $this->view('users/edit', [
-            'companyName' => 'Nanas Digital Studio',
+            'companyName' => 'Nanas Home Studio',
             'tagline' => 'Edit Pengguna',
             'user' => $user,
             'roles' => $roles
```

### 5. CategoryController (Default Company Name)
```diff
@@ -33,7 +33,7 @@
     public function create(): void
     {
         $this->view('categories/create', [
-            'companyName' => 'Nanas Digital Studio',
+            'companyName' => 'Nanas Home Studio',
             'tagline' => 'Tambah Kategori Baru'
         ]);
     }
@@ -88,7 +88,7 @@
         }
 
         $this->view('categories/edit', [
-            'companyName' => 'Nanas Digital Studio',
+            'companyName' => 'Nanas Home Studio',
             'tagline' => 'Edit Kategori',
             'category' => $category
         ]);
```

### 6. AuthController (Default Company Name)
```diff
@@ -55,7 +55,7 @@
         $roles = Database::query("SELECT id, name FROM roles ORDER BY id ASC")->fetchAll();
 
         $this->view('auth/register', [
-            'companyName' => 'Nanas Digital Studio',
+            'companyName' => 'Nanas Home Studio',
             'tagline' => 'Buat Akun Baru',
             'roles' => $roles
         ]);
```
