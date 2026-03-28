-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3307
-- Thời gian đã tạo: Th3 26, 2026 lúc 02:22 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `booking`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL DEFAULT 'Du lịch',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`id`, `category_name`, `title`, `slug`, `image`, `description`, `content`, `is_active`, `created_at`, `updated_at`, `views`) VALUES
(1, 'Tour gia đình', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 1', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-1', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 1, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', 'Nội dung chi tiết của bài viết sẽ nằm ở đây...', 1, '2026-03-21 16:48:42', '2026-03-21 21:10:18', 8),
(2, 'Tour gia đình', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 2', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-2', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 2, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', 'Nội dung chi tiết của bài viết sẽ nằm ở đây...', 1, '2026-03-21 16:48:42', '2026-03-21 16:48:42', 0),
(3, 'Tour gia đình', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 3', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-3', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 3, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', 'Nội dung chi tiết của bài viết sẽ nằm ở đây...', 1, '2026-03-21 16:48:42', '2026-03-21 17:52:00', 1),
(4, 'Du lịch biển', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 4', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-4', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 4, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', 'Nội dung chi tiết của bài viết sẽ nằm ở đây...', 1, '2026-03-21 16:48:42', '2026-03-21 18:03:30', 10),
(5, 'Tour gia đình', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 5', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-5', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 5, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', 'Nội dung chi tiết của bài viết sẽ nằm ở đây...', 1, '2026-03-21 16:48:42', '2026-03-21 16:48:42', 0),
(6, 'Du lịch biển', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 6', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-6', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 6, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', 'Nội dung chi tiết của bài viết sẽ nằm ở đây...', 1, '2026-03-21 16:48:42', '2026-03-21 16:48:42', 0),
(7, 'Khám phá mạo hiểm', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 7', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-7', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 7, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', 'Nội dung chi tiết của bài viết sẽ nằm ở đây...', 1, '2026-03-21 16:48:42', '2026-03-21 17:39:06', 2),
(8, 'Du lịch biển', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 8', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-8', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 8, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', 'Nội dung chi tiết của bài viết sẽ nằm ở đây...', 1, '2026-03-21 16:48:42', '2026-03-21 16:48:42', 0),
(9, 'Khám phá mạo hiểm', 'Cẩm nang du lịch cho kỳ nghỉ mơ ước của bạn - Phần 9', 'cam-nang-du-lich-cho-ky-nghi-mo-uoc-cua-ban-phan-9', 'clients/assets/images/blog/blog-list1.jpg', 'Đây là đoạn mô tả ngắn gọn cho bài viết số 9, giúp khách hàng có cái nhìn tổng quan trước khi bấm vào xem chi tiết...', '<p>Nội dung chi tiết của bài viết sẽ nằm ở đây...</p>', 1, '2026-03-21 16:48:42', '2026-03-21 19:47:35', 0),
(11, 'Du lịch', 'Test thêm bài viết', 'test-them-bai-viet', 'clients/assets/images/blog/1774117954_z4690175301759_c8033521c6721d90e2065fa69bc4b948.jpg', 'hay hahhud uahudhuad', '<p>kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao kdsbdsc &nbsp; còn hay khôn sao&nbsp;</p>', 1, '2026-03-21 18:32:34', '2026-03-21 20:45:14', 4),
(12, 'Ẩm thực', 'test thêm ảnh', 'test-them-anh-', 'clients/assets/images/blog/1774118928_thumb_69bee810d5c64.png', 'Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])->name(\'blogs.upload\');', '<p>hay gêh ùbdbfbf h &nbsp; &nbsp;eề fiv &nbsp;ve ưvuwebu &nbsp;ừuuwuv &nbsp;ubewbue &nbsp;ebu h&nbsp;</p><figure class=\"image\"><img src=\"http://127.0.0.1:8000/clients/assets/images/blog_content/1774118698_content_69bee72ac1cda.jpg\"></figure><p>sdhifhviv vewiveiv nưiefe ènienivi &nbsp;Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\'); g uvyuvuvuyvuvuyvyuvyvyv &nbsp;vvv &nbsp;vyuvyu vyv yv yyyctcrctc &nbsp; &nbsp;</p><p><strong>Route::post(\'blogs/upload-image\', [BlogController::class, \'uploadImage\'])-&gt;name(\'blogs.upload\');</strong></p><p><strong>v</strong></p>', 0, '2026-03-21 18:48:48', '2026-03-21 19:45:35', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-tours_destinations_sidebar', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:13:{i:0;O:8:\"stdClass\":2:{s:11:\"destination\";s:7:\"Cà mau\";s:5:\"count\";i:1;}i:1;O:8:\"stdClass\":2:{s:11:\"destination\";s:10:\"Chi Tiết\";s:5:\"count\";i:3;}i:2;O:8:\"stdClass\":2:{s:11:\"destination\";s:4:\"dddd\";s:5:\"count\";i:1;}i:3;O:8:\"stdClass\":2:{s:11:\"destination\";s:7:\"gia lai\";s:5:\"count\";i:1;}i:4;O:8:\"stdClass\":2:{s:11:\"destination\";s:9:\"Hạ Long\";s:5:\"count\";i:2;}i:5;O:8:\"stdClass\":2:{s:11:\"destination\";s:21:\"Hà Nội - Hạ Long\";s:5:\"count\";i:2;}i:6;O:8:\"stdClass\":2:{s:11:\"destination\";s:6:\"HCM 11\";s:5:\"count\";i:1;}i:7;O:8:\"stdClass\":2:{s:11:\"destination\";s:8:\"Hội An\";s:5:\"count\";i:1;}i:8;O:8:\"stdClass\":2:{s:11:\"destination\";s:9:\"Nha Trang\";s:5:\"count\";i:1;}i:9;O:8:\"stdClass\":2:{s:11:\"destination\";s:11:\"Phú Quốc\";s:5:\"count\";i:1;}i:10;O:8:\"stdClass\":2:{s:11:\"destination\";s:2:\"QN\";s:5:\"count\";i:3;}i:11;O:8:\"stdClass\":2:{s:11:\"destination\";s:4:\"QNam\";s:5:\"count\";i:1;}i:12;O:8:\"stdClass\":2:{s:11:\"destination\";s:4:\"Sapa\";s:5:\"count\";i:1;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1774533453);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_21_234501_create_blogs_table', 2),
(5, '2026_03_22_002022_add_views_to_blogs', 3),
(6, '2026_03_22_145702_create_tbl_tour_schedules_table', 4),
(7, '2026_03_25_165521_create_settings_table', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5QQlCvBNkCczNiHozMefEQqFi4rU0gmkHpZkPm7q', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTERMUklYT0traFQ3ZkZaaENLa3hkZzNMWjNhV0pWbFA4dHVuTkxHNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90b3Vycy9jcmVhdGUiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLnRvdXJzLmNyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1773145543),
('8PLrgEmznIUUj2TOYB1fYd1J6rv6cEBlMfs7Oo8l', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVlZxY0NVOVNKUkZweFY0ZXFjNU9yUjVNRHRFeGM5ajltYWJzNHI2UiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1773154209),
('NuuFoQTuChK3NHtTDWEJRLFmNfFEyxruOXQOp1V3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiVzE5emN2ZjN6NUFGem1Bc3RRbzdQVDFsM3hYaGdvYVlBZ2Q2RURoVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kZWJ1Zy1tZSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1OiJzdGF0ZSI7czo0MDoicEFZenJzSlBMWjJJRHVnbklmaEhCVFIwdXJQMFpxY1VucHNKUWtNYiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3VzZXItcHJvZmlsZSI7fXM6NDoidXNlciI7Tzo4OiJzdGRDbGFzcyI6MTQ6e3M6NjoidXNlcmlkIjtpOjM7czo4OiJ1c2VybmFtZSI7czoyMjoibXVwMzEwMjAwN0Bob3RtYWlsLmNvbSI7czo4OiJwYXNzd29yZCI7czo2MDoiJDJ5JDEyJEU4RE12clVJajQzWFhjcjBVU0VUck96MGNJNVFIa2ROTmdFZmN3ZHZ1N2YvTG4xMkh6RXZXIjtzOjU6ImVtYWlsIjtzOjIyOiJtdXAzMTAyMDA3QGhvdG1haWwuY29tIjtzOjExOiJwaG9uZU51bWJlciI7czoxMDoiMDM1Mjc4OTU1NiI7czo3OiJhZGRyZXNzIjtzOjM6IkhjbSI7czo4OiJJcEFkcmVzcyI7czo5OiIxMjcuMC4wLjEiO3M6ODoiaXNBY3RpdmUiO2k6MTtzOjY6InN0YXR1cyI7aToxO3M6NjoiYXZhdGFyIjtzOjE0OiIxNzczMTQ3NTIxLnBuZyI7czoxMToicmVzZXRfdG9rZW4iO3M6NTE6IldkaEppMU9KMmloNmt2VDdTbnRqVzhTTzdWbXpycUQxSk52Nk5qUDlfMTc3MzA1NTY4NCI7czo4OiJwcm92aWRlciI7TjtzOjExOiJwcm92aWRlcl9pZCI7TjtzOjQ6InJvbGUiO2k6MTt9fQ==', 1773152449),
('XC1deHzXQ6AXhxSOWS3rVI0f2ORaB5ypTYpNrLOL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiT0JKZkVraVVTenNWS2Z1NG0xZHhabG9zNVM4Y2tvdGtDcWpLNzh1cSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kZWJ1Zy1tZSI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1OiJzdGF0ZSI7czo0MDoiVk5lYXpkUnJhZDlxNDlxZDVjOVllTGlNUEhjSXhkcGYyRW1JVVNUViI7czo0OiJ1c2VyIjtPOjg6InN0ZENsYXNzIjoxNDp7czo2OiJ1c2VyaWQiO2k6MztzOjg6InVzZXJuYW1lIjtzOjIyOiJtdXAzMTAyMDA3QGhvdG1haWwuY29tIjtzOjg6InBhc3N3b3JkIjtzOjYwOiIkMnkkMTIkRThETXZyVUlqNDNYWGNyMFVTRVRyT3owY0k1UUhrZE5OZ0VmY3dkdnU3Zi9MbjEySHpFdlciO3M6NToiZW1haWwiO3M6MjI6Im11cDMxMDIwMDdAaG90bWFpbC5jb20iO3M6MTE6InBob25lTnVtYmVyIjtzOjEwOiIwMzUyNzg5NTU2IjtzOjc6ImFkZHJlc3MiO3M6MzoiSGNtIjtzOjg6IklwQWRyZXNzIjtzOjk6IjEyNy4wLjAuMSI7czo4OiJpc0FjdGl2ZSI7aToxO3M6Njoic3RhdHVzIjtpOjE7czo2OiJhdmF0YXIiO3M6MTQ6IjE3NzMxNDc1MjEucG5nIjtzOjExOiJyZXNldF90b2tlbiI7czo1MToiV2RoSmkxT0oyaWg2a3ZUN1NudGpXOFNPN1ZtenJxRDFKTnY2TmpQOV8xNzczMDU1Njg0IjtzOjg6InByb3ZpZGVyIjtOO3M6MTE6InByb3ZpZGVyX2lkIjtOO3M6NDoicm9sZSI7aToxO31zOjM6InVybCI7YToxOntzOjg6ImludGVuZGVkIjtzOjMzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYWRtaW4vdG91cnMiO319', 1773152302);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'GoViet Travel', '2026-03-25 10:22:11', '2026-03-25 10:22:11'),
(2, 'hotline', '0352780288', '2026-03-25 10:22:11', '2026-03-26 12:51:30'),
(3, 'contact_email', 'mup3102007@hotmail.com', '2026-03-25 10:22:11', '2026-03-25 10:42:38'),
(4, 'company_address', NULL, '2026-03-25 10:22:11', '2026-03-25 10:22:11'),
(5, 'hero_banner', 'clients/assets/images/banner/hero_1774444986.png', '2026-03-25 10:22:11', '2026-03-25 13:23:06'),
(6, 'momo_partner_code', 'MOMO3PZW20250404', '2026-03-25 10:42:38', '2026-03-25 10:42:38'),
(7, 'momo_access_key', 'xgxKBfHrl3zjLjUi', '2026-03-25 10:42:38', '2026-03-25 13:24:12'),
(8, 'momo_secret_key', 'nV3IXBghMwc9gjk1pqCGOs9aOo2x9mlh', '2026-03-25 10:42:38', '2026-03-25 10:42:38'),
(9, 'momo_environment', 'https://payment.momo.vn/v2/gateway/api/create', '2026-03-25 10:42:38', '2026-03-25 10:42:38'),
(10, 'social_facebook', NULL, '2026-03-25 11:02:59', '2026-03-25 11:02:59'),
(11, 'social_youtube', NULL, '2026-03-25 11:02:59', '2026-03-25 11:02:59'),
(12, 'social_zalo', NULL, '2026-03-25 11:02:59', '2026-03-25 11:02:59'),
(13, 'header_scripts', NULL, '2026-03-25 11:02:59', '2026-03-25 11:02:59'),
(14, 'footer_scripts', NULL, '2026-03-25 11:02:59', '2026-03-25 11:02:59'),
(15, 'site_logo', 'clients/assets/images/logos/logo_1774444986.png', '2026-03-25 11:02:59', '2026-03-25 13:23:06'),
(22, 'mail_driver', 'smtp', '2026-03-25 12:37:24', '2026-03-25 12:37:24'),
(23, 'mail_host', 'smtp.gmail.com', '2026-03-25 12:37:24', '2026-03-25 12:37:24'),
(24, 'mail_port', '587', '2026-03-25 12:37:24', '2026-03-25 12:37:24'),
(25, 'mail_username', 'vuongvanbui20@gmail.com', '2026-03-25 12:37:24', '2026-03-25 12:37:24'),
(26, 'mail_password', 'htgkoqsyhoussope', '2026-03-25 12:37:24', '2026-03-25 12:37:24'),
(27, 'mail_encryption', 'tls', '2026-03-25 12:37:24', '2026-03-25 12:37:24'),
(28, 'maintenance_mode', '0', '2026-03-25 13:07:08', '2026-03-25 13:18:22'),
(29, 'gemini_api_key', 'AIzaSyBY3OyKkhqG8aYXRBkBlshVWEx5wlgHg0c', '2026-03-26 12:30:21', '2026-03-26 12:30:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `adminid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createDay` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_bookings`
--

CREATE TABLE `tbl_bookings` (
  `bookingid` int(11) NOT NULL,
  `tourid` int(11) NOT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `bookingdate` date NOT NULL DEFAULT current_timestamp(),
  `numadults` int(11) DEFAULT 1,
  `numchildren` int(11) DEFAULT 0,
  `totalprice` double NOT NULL,
  `bookingstatus` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `specialrequest` text DEFAULT NULL,
  `paymentmethod` varchar(50) DEFAULT NULL COMMENT 'Trạng thái đơn',
  `deposit_amount` decimal(10,2) DEFAULT 0.00 COMMENT 'Trạng thái ',
  `paid_amount` decimal(10,2) DEFAULT 0.00 COMMENT 'Tiền Cọc',
  `refund_amount` decimal(15,2) DEFAULT 0.00,
  `cancel_reason` text DEFAULT NULL,
  `paymentstatus` varchar(50) DEFAULT 'unpaid',
  `pickup_id` int(11) DEFAULT NULL,
  `pickup_fee_total` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_bookings`
--

INSERT INTO `tbl_bookings` (`bookingid`, `tourid`, `schedule_id`, `userid`, `bookingdate`, `numadults`, `numchildren`, `totalprice`, `bookingstatus`, `specialrequest`, `paymentmethod`, `deposit_amount`, `paid_amount`, `refund_amount`, `cancel_reason`, `paymentstatus`, `pickup_id`, `pickup_fee_total`) VALUES
(45, 19, NULL, 18, '2026-03-18', 1, 0, 2324324, 'cancelled', 'Tên: Ba Hồn | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ:  | REFUND INFO: êr', 'cash', 697297.00, 697297.00, 0.00, 'grgrg', 'refund_pending', NULL, 0.00),
(46, 25, NULL, 13, '2026-03-18', 1, 0, 2000000, 'confirmed', 'Tên: PhạmPhạm anh trí | Email: fksldvd@gmail.com | SĐT: 55656 | Địa chỉ: ', 'cash', 600000.00, 600000.00, 0.00, NULL, 'deposit_paid', NULL, 0.00),
(47, 21, NULL, 3, '2026-03-18', 1, 0, 900000, 'cancelled', 'Tên: mup3102007@hotmail.com | Email: ddd@jj | SĐT: dd | Địa chỉ:  | REFUND INFO: haha  uuhwd', 'momo', 270000.00, 270000.00, 0.00, 'không hợp quá', 'refund_pending', NULL, 0.00),
(48, 25, NULL, 3, '2026-03-18', 1, 0, 2000000, 'confirmed', 'Tên: mup3102007@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: ', 'cash', 600000.00, 2000000.00, 0.00, NULL, 'refunded', NULL, 0.00),
(49, 25, NULL, 3, '2026-03-18', 3, 0, 6000000, 'cancelled', 'Tên: mup3102007@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ:  | REFUND INFO: nhigh', 'Cash', 1800000.00, 6000000.00, 0.00, '5f gg', 'refund_pending', NULL, 0.00),
(50, 25, NULL, 8, '2026-03-18', 1, 2, 2020000, 'cancelled', 'Tên: vuongvanbui20@gmail.com | Email: buivanvuong015@gmail.com | SĐT: 0398846587 | Địa chỉ:  | REFUND INFO: ádyugy abuidbuasu | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO:  | REFUND INFO: ', 'momo', 606000.00, 606000.00, 0.00, NULL, 'refund_pending', NULL, 0.00),
(51, 25, NULL, 8, '2026-03-18', 1, 3, 2030000, 'cancelled', 'Tên: vuongvanbui20@gmail.com | Email: buivanvuong015@gmail.com | SĐT: 0398846587 | Địa chỉ:  | REFUND INFO: ', 'momo', 609000.00, 0.00, 0.00, 'dcdc', 'unpaid', NULL, 0.00),
(52, 25, NULL, 8, '2026-03-18', 2, 0, 4000000, 'cancelled', 'Tên: vuongvanbui20@gmail.com | Email: buivanvuong015@gmail.com | SĐT: 0398846587 | Địa chỉ:  | REFUND: r5667', 'momo', 1200000.00, 4000000.00, 0.00, 'dr', 'refund_pending', NULL, 0.00),
(53, 1, NULL, 8, '2026-03-18', 2, 3, 600000, 'cancelled', 'Tên: vuongvanbui20@gmail.com | Email: mup3102007@hotmail.com | SĐT: ddd | Địa chỉ: ', 'cash', 180000.00, 180000.00, 0.00, NULL, 'refund_pending', NULL, 0.00),
(54, 25, NULL, 8, '2026-03-18', 2, 4, 4040000, 'cancelled', 'Tên: vuongvanbui20@gmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ:  | REFUND INFO: uhduieuid', 'momo', 1212000.00, 1212000.00, 0.00, 'uduhuh', 'refund_pending', NULL, 0.00),
(55, 25, NULL, 18, '2026-03-18', 3, 6, 6060000, 'cancelled', 'Tên: Ba Hồn | Email: buivanvuong015@gmail.com | SĐT: ddd | Địa chỉ:  | REFUND: 888', 'momo', 1818000.00, 1818000.00, 0.00, 'hjjbjb', 'refund_pending', NULL, 0.00),
(56, 25, NULL, 18, '2026-03-18', 1, 0, 2000000, 'cancelled', 'Tên: Ba Hồn | Email: buivanvuong015@gmail.com | SĐT: ddd | Địa chỉ:  | REFUND INFO: dêr', 'momo', 600000.00, 600000.00, 0.00, 'êretrt', 'refund_pending', NULL, 0.00),
(57, 23, NULL, 21, '2026-03-21', 1, 4, 17237160, 'pending', 'Tên: mup31020071@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'cash', 5171148.00, 0.00, 0.00, NULL, 'unpaid', NULL, 0.00),
(58, 321, NULL, 3, '2026-03-22', 1, 1, 2160000, 'cancelled', 'Tên: mup3102007@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm | REFUND INFO: 56657', 'cash', 648000.00, 648000.00, 0.00, '57676', 'refund_pending', NULL, 0.00),
(59, 321, 16, 3, '2026-03-22', 1, 1, 2400000, 'cancelled', 'Tên: mup3102007@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'cash', 720000.00, 2400000.00, 0.00, NULL, 'deposit_paid', NULL, 0.00),
(60, 322, 22, 3, '2026-03-22', 1, 0, 1000011, 'confirmed', 'Tên: mup3102007@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'cash', 300003.00, 1000011.00, 0.00, NULL, 'paid', NULL, 0.00),
(61, 324, 24, 3, '2026-03-23', 1, 0, 11111, 'cancelled', 'Tên: mup3102007@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm | REFUND INFO: ', 'cash', 3333.00, 0.00, 0.00, '..', 'unpaid', NULL, 0.00),
(62, 324, 24, 3, '2026-03-23', 1, 4, 11555, 'cancelled', 'Tên: mup3102007@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm | REFUND INFO: dgdg vhvcvy vvcvy', 'momo', 3467.00, 11555.00, 0.00, 'tôi chhuaw đi', 'paid', NULL, 0.00),
(63, 322, 22, 3, '2026-03-23', 1, 4, 1004455, 'cancelled', 'Tên: mup3102007@hotmail.com | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm | REFUND INFO: ', 'cash', 301337.00, 0.00, 0.00, 'jjj', 'unpaid', NULL, 0.00),
(64, 321, 19, 3, '2026-03-23', 1, 2, 2400000, 'pending', 'Tên: mup3102007@hotmail.com | Email: buivanvuong015@gmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'cash', 720000.00, 0.00, 0.00, NULL, 'unpaid', NULL, 0.00),
(65, 321, 19, 3, '2026-03-23', 1, 4, 3600000, 'cancelled', 'Tên: mup3102007@hotmail.com | Email: 4tt5t@rrr | SĐT: rrr | Địa chỉ: rrrr', 'paypal', 1080000.00, 3600000.00, 0.00, NULL, 'refunded', NULL, 0.00),
(66, 324, 23, 25, '2026-03-24', 2, 1, 333333, 'pending', 'Tên: Vuong Van | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'cash', 100000.00, 0.00, 0.00, NULL, 'unpaid', NULL, 0.00),
(67, 322, 22, 3, '2026-03-25', 3, 0, 3000033, 'confirmed', 'Tên: mup3102007@hotmail.com | Email: buivanvuong015@gmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'cash', 900010.00, 3000033.00, 0.00, NULL, 'paid', 3, NULL),
(68, 322, 22, 3, '2026-03-25', 1, 0, 1000011, 'confirmed', 'Tên: mup3102007@hotmail.com | Email: buivanvuong015@gmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'cash', 300003.00, 1000011.00, 0.00, NULL, 'paid', 4, NULL),
(69, 322, 22, 3, '2026-03-25', 1, 0, 1000011, 'confirmed', 'Tên: mup3102007@hotmail.com | Email: buivanvuong015@gmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'momo', 300003.00, 1000011.00, 0.00, NULL, 'paid', 4, NULL),
(70, 322, 22, 3, '2026-03-25', 1, 2, 1002233, 'confirmed', 'Tên: mup3102007@hotmail.com | Email: buivanvuong015@gmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'momo', 300670.00, 1002233.00, 0.00, NULL, 'paid', 4, NULL),
(71, 322, 22, 3, '2026-03-25', 1, 4, 1004455, 'pending', 'Khách hàng: mup3102007@hotmail.com | SĐT: 0398846587 | Email: mup3102007@hotmail.com | Đ/C: hcm', 'cash', 301337.00, 0.00, 0.00, NULL, 'unpaid', 4, 0.00),
(72, 322, 22, 25, '2026-03-25', 1, 2, 1002233, 'confirmed', 'Tên: Vuong Van | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'Cash', 300670.00, 1002233.00, 0.00, NULL, 'paid', 4, 150000.00),
(73, 321, 19, 25, '2026-03-25', 1, 0, 1080000, 'pending', 'Tên: Vuong Van | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm', 'cash', 324000.00, 0.00, 0.00, NULL, 'unpaid', NULL, 0.00),
(74, 324, 24, 25, '2026-03-25', 1, 1, 1122.2, 'cancelled', 'Tên: Vuong Van | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: hcm | REFUND INFO: ', 'momo', 337.00, 0.00, 0.00, 'hông', 'unpaid', 5, 100000.00),
(75, 327, 28, 25, '2026-03-25', 1, 1, 10080.9, 'confirmed', 'Tên: Vuong Van | Email: mup3102007@hotmail.com | SĐT: 0398846587 | Địa chỉ: rrrr đ d d dưedwef', 'MoMo', 3024.00, 10080.90, 0.00, NULL, 'paid', 7, 0.00),
(76, 326, 27, 27, '2026-03-25', 1, 1, 11880, 'cancelled', 'Tên: Nhat Quang | Email: nhatquan12497@hotmail.com | SĐT: 0398846587 | Địa chỉ: nhatquan12497@hotmail.com | REFUND INFO: huhu | REFUND INFO: hhha', 'Cash', 3564.00, 11880.00, 5940.00, 'hahaha', 'refund_pending', 6, 2000.00),
(77, 326, 27, 27, '2026-03-25', 1, 1, 11880, 'confirmed', 'Tên: Nhat Quang | Email: nhatquan12497@hotmail.com | SĐT: 0398846587 | Địa chỉ: nhatquan12497@hotmail.com', 'MoMo', 3564.00, 11880.00, 0.00, NULL, 'paid', 6, 2000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_chat`
--

CREATE TABLE `tbl_chat` (
  `chatid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `message` text NOT NULL,
  `isread` enum('Y','N') DEFAULT 'Y',
  `ipaddress` varchar(50) DEFAULT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `adminid` int(11) NOT NULL,
  `last_activity` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_chat`
--

INSERT INTO `tbl_chat` (`chatid`, `userid`, `message`, `isread`, `ipaddress`, `createdat`, `adminid`, `last_activity`) VALUES
(316, 8, 'Chào bạn! ✨ Tôi là trợ lý chat của GoViet Travel,Tôi có thể giúp gì cho chuyến đi sắp tới của bạn không?', 'N', '127.0.0.1', '2026-03-24 12:37:50', 999, NULL),
(317, 8, 'hi bạn', 'N', '127.0.0.1', '2026-03-24 12:37:57', 0, NULL),
(318, 8, 'Chào bạn! GoViet Travel có thể giúp gì cho bạn hôm nay ạ? 😊', 'N', 'NULL', '2026-03-24 12:37:59', 999, NULL),
(319, 8, 'bạn giúp tôi tìm tour mới', 'N', '127.0.0.1', '2026-03-24 12:38:13', 0, NULL),
(320, 8, 'Chào bạn! Hiện tại, GoViet Travel chưa có tour nào đang mở bán trong hệ thống ạ. Bạn có muốn tìm hiểu về mã giảm giá không? 😊', 'N', 'NULL', '2026-03-24 12:38:16', 999, NULL),
(321, 8, 'mã giảm giá', 'N', '127.0.0.1', '2026-03-24 12:41:47', 0, NULL),
(322, 8, 'Chào bạn! GoViet Travel hiện có mã giảm giá sau:\n\n   GoViet10: Giảm 10% tổng giá trị tour. Mã có hiệu lực đến ngày 27-03-2026.\n\nBạn hãy nhanh tay sử dụng nhé! ✨', 'N', 'NULL', '2026-03-24 12:41:50', 999, NULL),
(323, 8, 'tour cho 10 người', 'N', '127.0.0.1', '2026-03-24 12:42:14', 0, NULL),
(324, 8, 'Chào bạn! Hiện tại, GoViet Travel chưa có tour nào đang mở bán với lịch khởi hành và giá cụ', 'N', 'NULL', '2026-03-24 12:42:18', 999, NULL),
(325, 8, 'tour gần nhất', 'N', '127.0.0.1', '2026-03-24 12:44:07', 0, NULL),
(326, 8, 'Chào bạn! Hiện tại, GoViet Travel chưa có tour nào đang mở bán với lịch khởi hành và giá cụ thể trong hệ thống ạ.\n\nBạn có muốn tìm hiểu về các điểm đến như Hà Nội - Hạ Long, Nha Trang, Phú Quốc, hay Sapa không? Hoặc bạn có quan tâm đến mã giảm giá hiện có không? 😊', 'N', 'NULL', '2026-03-24 12:44:10', 999, NULL),
(327, 8, 'hà nội', 'N', '127.0.0.1', '2026-03-24 12:44:29', 0, NULL),
(328, 8, 'Chào bạn! GoViet Travel có tour Hà Nội - Hạ Long kéo dài 3 ngày 2 đêm', 'N', 'NULL', '2026-03-24 12:44:34', 999, NULL),
(329, 8, 'giá tiền', 'N', '127.0.0.1', '2026-03-24 12:44:46', 0, NULL),
(330, 8, 'Chào bạn! Rất tiếc, hiện tại hệ thống của GoViet Travel chưa có thông tin về giá và lịch khởi hành cụ thể cho Tour Hà Nội - Hạ Long ạ.\n\nBạn có muốn tìm hiểu về các tour khác hoặc có ngày khởi hành mong muốn không? 😊', 'N', 'NULL', '2026-03-24 12:44:51', 999, NULL),
(331, 8, 'có tour nào ngày 25 không', 'N', '127.0.0.1', '2026-03-24 12:47:44', 0, NULL),
(332, 8, 'Chào bạn! Rất tiếc, hiện tại hệ thống của GoViet Travel chưa có thông tin lịch khởi hành cụ thể cho bất kỳ tour nào vào ngày 25 ạ.\n\nBạn có muốn tìm hiểu về các điểm đến như Hà Nội - Hạ Long, Nha Trang, Phú Quốc, hay Sapa không? Hoặc bạn có quan tâm đến mã giảm giá hiện có không? 😊', 'N', 'NULL', '2026-03-24 12:47:47', 999, NULL),
(333, 8, 'tìm tour tháng 4', 'N', '127.0.0.1', '2026-03-24 12:50:51', 0, NULL),
(334, 8, 'Chào bạn! Rất tiếc, hiện tại hệ thống của GoViet Travel chưa có thông tin lịch khởi hành cụ thể cho bất kỳ tour nào trong tháng 4 ạ.\n\nGoViet Travel hiện có các tour sau:\n   Tour Hà Nội - Hạ Long (3 ngày 2 đêm)\n   Nha Trang 3N2Đ (3 ngày 3 đêm)\n   Tour Hạ Long 2N1Đ (2 ngày 1 đêm)\n   Tour Phú Quốc 4N3Đ (4 ngày 3 đêm)\n   Tour Sapa 3N2Đ (3 ngày 2 đêm)\n\nBạn có muốn tìm hiểu thêm về một trong các tour này không? 😊', 'N', 'NULL', '2026-03-24 12:50:53', 999, NULL),
(335, 8, 'các tour đó bắt đầu tháng mấy', 'N', '127.0.0.1', '2026-03-24 12:51:25', 0, NULL),
(336, 8, 'Chào bạn! Rất tiếc, hiện tại hệ thống của GoViet Travel chưa có thông tin lịch khởi hành cụ thể (bao gồm cả tháng bắt đầu) cho bất kỳ tour nào trong danh sách ạ.\n\nBạn có muốn tìm hiểu về lịch trình hoặc các điểm đến của những tour này không? 😊', 'N', 'NULL', '2026-03-24 12:51:28', 999, NULL),
(337, 8, 'thông tin tour Nha Trang 3N2Đ (3 ngày 3 đêm)', 'N', '127.0.0.1', '2026-03-24 12:51:49', 0, NULL),
(338, 8, 'Chào bạn! Dưới đây là thông tin về tour Nha Trang 3N2Đ:\n\n   Tên tour: Nha Trang 3N2Đ\n   Thời gian: 3 ngày 3 đêm\n   Điểm đến: Nha Trang\n   Tóm tắt lịch trình: Ngày 1 | Ngày 2 | Ngày 3\n\nHiện tại, GoViet Travel chưa có thông tin cụ thể về lịch khởi hành và giá của tour này.\n\nBạn có muốn tìm hiểu thêm về lịch trình chi tiết của từng ngày không? 😊', 'N', 'NULL', '2026-03-24 12:51:53', 999, NULL),
(339, 8, 'giá tiền', 'N', '127.0.0.1', '2026-03-24 12:52:19', 0, NULL),
(340, 8, 'Chào bạn! Rất tiếc, hiện tại GoViet Travel chưa có thông tin về giá tiền cụ thể cho tour Nha Trang 3N2Đ ạ. 😔\n\nBạn có muốn tìm hiểu thêm về lịch trình hoặc các tour khác không?', 'N', 'NULL', '2026-03-24 12:52:22', 999, NULL),
(341, 3, 'Chào bạn! ✨ Tôi là trợ lý chat của GoViet Travel,Tôi có thể giúp gì cho chuyến đi sắp tới của bạn không?', 'N', '127.0.0.1', '2026-03-24 12:57:50', 999, NULL),
(342, 3, 'TÌM TOUR CHO 20 NGƯỜI', 'Y', '127.0.0.1', '2026-03-24 12:58:10', 0, NULL),
(343, 3, 'Chào bạn! 👋\n\nHiện tại, GoViet Travel có Tour hòa Minh khởi hành ngày 04/04/2026 còn đủ 20 chỗ trống cho đoàn của bạn đó ạ!\n\nThông tin chi tiết tour:\n   Tên tour: hòa Minh\n   Thời gian: 3 ngày 2 đêm\n   Điểm đến: Chi Tiết\n   Ngày khởi hành: 04/04/2026\n   Giá người lớn: 11.11', 'N', 'NULL', '2026-03-24 12:58:15', 999, NULL),
(344, 3, 'TÔI ĐI 15 NGƯỜI LỚN 5 TRẺ EM THÌ GIÁ BAO NHIÊU', 'Y', '127.0.0.1', '2026-03-24 12:59:51', 0, NULL),
(345, 3, 'Chào bạn! Với 15 người lớn và 5 trẻ em cho Tour hòa Minh khởi hành ngày 04/04/2026, tổng chi phí sẽ là:\n\n   Giá người lớn: 15 x 11.111 VNĐ = 166.665 VNĐ\n   Giá trẻ em: 5 x 111 VNĐ = 555 VNĐ\n   Tổng cộng: 167.220 VNĐ\n\nBạn có muốn đặt tour này không ạ? 😊', 'N', 'NULL', '2026-03-24 12:59:56', 999, NULL),
(346, 26, 'Chào bạn! ✨ Tôi là trợ lý chat của GoViet Travel,Tôi có thể giúp gì cho chuyến đi sắp tới của bạn không?', 'N', '127.0.0.1', '2026-03-24 13:02:34', 999, NULL),
(347, 26, 'giúp tôi tìm tour trong tháng 5 cho 15 người', 'N', '127.0.0.1', '2026-03-24 13:17:43', 0, NULL),
(348, 26, 'Chào bạn, GoViet Travel có tour \"Hà Nội - Hạ Long\" khởi hành vào tháng 5 phù', 'N', '127.0.0.1', '2026-03-24 13:17:48', 999, NULL),
(349, 26, 'giá tiền', 'N', '127.0.0.1', '2026-03-24 13:18:35', 0, NULL),
(350, 26, 'Chào bạn, tour \"Hà Nội - Hạ Long\" có các mức giá sau cho tháng 5:\n\n   Ngày 01/05/2026:\n       Giá người lớn: 1.670.000 VNĐ\n       Giá trẻ em: 980.000 VNĐ\n   Ngày 01/05/2026:\n       Giá người lớn: 1.200.000 VNĐ\n       Giá trẻ em: 600.000 VNĐ', 'N', '127.0.0.1', '2026-03-24 13:18:38', 999, NULL),
(351, 26, 'tất cả tour có trang hệ thống', 'N', '127.0.0.1', '2026-03-24 13:23:16', 0, NULL),
(352, 26, 'Chào bạn, hiện tại GoViet Travel có các tour sau trên hệ thống:\n\n   Tour 1\n   Tour Hà Nội - Hạ Long', 'N', '127.0.0.1', '2026-03-24 13:23:18', 999, NULL),
(353, 26, 'thêm', 'N', '127.0.0.1', '2026-03-24 13:23:28', 0, NULL),
(354, 26, 'Chào bạn, đây là thông tin chi tiết về các tour hiện có:\n\n1. Tour 1\n   Thời gian: 3 ngày 3 đêm\n   Lịch trình: Ăn Uống 1\n   Ngày đi: 24/03/2026\n       Giá người lớn: 1.231.212 VNĐ\n       Giá trẻ em: 101.010 VNĐ\n       Chỗ trống: 10\n\n2. Tour Hà Nội - Hạ Long\n   Thời gian: 3 ngày 2 đêm\n   Lịch trình: (Hiện chưa có thông tin chi tiết về lịch trình cho tour này)\n   Ngày đi:\n       01/05/2026:\n           Giá người lớn: 1.670.000 VNĐ\n           Giá trẻ em: 980.000 VNĐ\n           Chỗ trống: 15\n       01/04/2026:\n           Giá người lớn: 1.500.000 VNĐ\n           Giá trẻ em: 900.000 VNĐ\n           Chỗ trống: 1\n       01/05/2026:\n           Giá người lớn: 1.200.000 VNĐ\n           Giá trẻ em: 600.000 VNĐ\n           Chỗ trống: 7\n\nBạn quan tâm đến tour nào cụ thể không?', 'N', '127.0.0.1', '2026-03-24 13:23:32', 999, NULL),
(355, 26, 'tháng 5 có tour không', 'N', '127.0.0.1', '2026-03-24 13:29:29', 0, NULL),
(356, 26, 'Chào bạn, có tour đi vào tháng 5 nhé:\n\nTour Hà Nội - Hạ Long\n   Thời gian: 3 ngày 2 đêm\n   Lịch trình: (Hiện chưa có thông tin chi tiết về lịch trình cho tour này)\n   Ngày đi:\n       01/05/2026:\n           Giá người lớn: 1.670.000 VNĐ\n           Giá trẻ em: 980.000 VNĐ\n           Chỗ trống: 15\n       01/05/2026:\n           Giá người lớn: 1.200.000 VNĐ\n           Giá trẻ em: 600.000 VNĐ\n           Chỗ trống: 7\n\nBạn có muốn xem lịch trình chi tiết của tour này không?', 'N', '127.0.0.1', '2026-03-24 13:29:33', 999, NULL),
(357, 26, 'tôi muốn đi 10 người thì làm sao', 'N', '127.0.0.1', '2026-03-24 13:30:55', 0, NULL),
(358, 26, 'Chào bạn, với 10 người, bạn có thể tham khảo tour Hà Nội - Hạ Long khởi hành vào ngày 01/05/2026 với 15 chỗ trống nhé.\n\nChi tiết tour này như sau:\n   Tour Hà Nội - Hạ Long\n       Thời gian: 3 ngày 2 đêm\n       Ngày đi: 01/05/2026\n           Giá người lớn: 1.670.000 VNĐ\n           Giá trẻ em: 980.000 VNĐ\n           Chỗ trống: 15\n\nĐể tính tổng tiền chính xác, bạn vui lòng cho mình biết trong 10 người có bao nhiêu người lớn và bao nhiêu trẻ em nhé!', 'N', '127.0.0.1', '2026-03-24 13:30:58', 999, NULL),
(359, 3, 'Chào bạn! ✨ Tôi là trợ lý AI của GoViet Travel. Tôi có thể giúp bạn tìm tour, báo giá hoặc kiểm tra lịch trình. Bạn muốn đi đâu nào?', 'N', '127.0.0.1', '2026-03-25 08:50:48', 999, NULL),
(360, 3, 'chòa bạn kím tour', 'Y', '127.0.0.1', '2026-03-25 08:51:55', 0, NULL),
(361, 3, 'Chào bạn! Rất vui được hỗ trợ bạn. 😊\n\nBạn muốn tìm tour đi đâu, vào khoảng thời gian nào và có bao nhiêu người đi ạ? Hãy cho mình biết thêm thông tin nhé!', 'N', '127.0.0.1', '2026-03-25 08:51:58', 999, NULL),
(362, 3, 'tầm 11 người', 'Y', '127.0.0.1', '2026-03-25 09:24:22', 0, NULL),
(363, 3, 'Chào bạn! Với số lượng khoảng 11 người, bạn muốn tìm tour đi đâu và vào khoảng thời gian nào ạ?\n\nVà trong 11 người đó có bao nhiêu người lớn và bao nhiêu trẻ em để mình tiện báo giá chính xác nhất nhé! 😊', 'N', '127.0.0.1', '2026-03-25 09:24:28', 999, NULL),
(364, 3, 'tìm tour cho 11 người', 'Y', '127.0.0.1', '2026-03-25 09:25:03', 0, NULL),
(365, 3, 'Chào bạn! Để mình có thể tìm tour phù hợp nhất cho 11 người, bạn vui lòng cho mình biết thêm các thông tin sau nhé:\n\n1.  Bạn muốn đi đâu? (Ví dụ: Hà Nội, Hạ Long, Đà Nẵng,...)\n2.  Bạn muốn đi vào khoảng thời gian nào? (Ví dụ: tháng 4, tháng 5, cuối tuần này,...)\n3.  Trong 11 người đó có bao nhiêu người lớn và bao nhiêu trẻ em? (Để mình báo giá chính xác nhất ạ)\n\nMình chờ thông tin từ bạn nhé! 😊', 'N', '127.0.0.1', '2026-03-25 09:25:06', 999, NULL),
(366, 3, 'hà nội', 'Y', '127.0.0.1', '2026-03-25 09:25:22', 0, NULL),
(367, 3, 'Chào bạn! Hiện tại GoViet Travel có tour Hà Nội - Hạ Long rất hấp dẫn, với thời gian 3 ngày 2 đêm.\n\nDưới đây là các lịch khởi hành và giá tour:\n\n   Ngày 01/05/2026:\n       Giá người lớn: 1.670.000 VNĐ\n       Giá trẻ em: 980.000 VNĐ\n       Số chỗ còn: 15 chỗ\n   Ngày 01/04/2026:\n       Giá người lớn: 1.500.000 VNĐ\n       Giá trẻ em: 900.000 VNĐ\n       Số chỗ còn: 1 chỗ\n   Ngày 01/05/2026:\n       Giá người lớn: 1.200.000 VNĐ\n       Giá trẻ em: 600.000 VNĐ\n       Số chỗ còn: 7 chỗ\n\nBạn muốn đi vào ngày nào và trong 11 người có bao nhiêu người lớn, bao nhiêu trẻ em để mình tính tổng chi phí chính xác nhất nhé! 😊', 'N', '127.0.0.1', '2026-03-25 09:25:27', 999, NULL),
(368, 25, 'Chào bạn! ✨ Tôi là trợ lý AI của GoViet Travel. Tôi có thể giúp bạn tìm tour, báo giá hoặc kiểm tra lịch trình. Bạn muốn đi đâu nào?', 'N', '127.0.0.1', '2026-03-25 13:56:10', 999, NULL),
(369, 25, 'tour hot nhất', 'N', '127.0.0.1', '2026-03-25 13:56:20', 0, NULL),
(370, 25, 'Chào bạn, hiện tại GoViet Travel chưa có danh mục \"tour hot nhất\" ạ.\n\nBạn có muốn mình giới thiệu các tour hiện có không, hay bạn đang tìm tour đi đâu, vào thời gian nào để mình tìm kiếm cho phù hợp nhé?', 'N', '127.0.0.1', '2026-03-25 13:56:23', 999, NULL),
(371, 25, 'tour tháng 9', 'N', '127.0.0.1', '2026-03-25 13:56:38', 0, NULL),
(372, 25, 'Chào bạn, hiện tại GoViet Travel chưa có tour nào khởi hành vào tháng 9 ạ.\n\nBạn có muốn tìm tour vào tháng khác không, hay bạn đang quan tâm đến địa điểm nào để mình kiểm tra nhé?', 'N', '127.0.0.1', '2026-03-25 13:56:41', 999, NULL),
(373, 25, 'tuor hiện có', 'N', '127.0.0.1', '2026-03-25 13:56:52', 0, NULL),
(374, 25, 'Chào bạn, GoViet Travel hiện có các tour sau:\n\n1. Tour Hà Nội - Hạ Long\n   Thời gian: 3 ngày 2 đêm\n       Ngày đi 01/04/2026:\n           Giá người lớn: 1.500.000 VNĐ\n           Giá trẻ em: 900.000 VNĐ\n           Chỗ còn: 1\n       Ngày đi 01/05/2026:\n           Giá người lớn: 1.670.000 VNĐ\n           Giá trẻ em: 980.000 VNĐ\n           Chỗ còn: 15\n       Ngày đi 01/05/2026:\n           Giá người lớn: 1.200.000 VNĐ\n           Giá trẻ em: 600.000 VNĐ\n           Chỗ còn: 6\n\n2. Tour dddd\n   Thời gian: 3 ngày 3 đêm\n       Ngày đi 25/03/2026:\n           Giá người lớn: 1.000.011 VNĐ\n           Giá trẻ em: 1.111 VNĐ\n           Chỗ còn: 3\n\nBạn quan tâm đến tour nào hay muốn mình tư vấn thêm không ạ?', 'N', '127.0.0.1', '2026-03-25 13:56:58', 999, NULL),
(375, 25, 'miền trung có tour nào', 'N', '127.0.0.1', '2026-03-25 13:57:09', 0, NULL),
(376, 25, 'Chào bạn, hiện tại GoViet Travel chưa có tour nào khởi hành đi miền Trung ạ.\n\nBạn có muốn mình tìm tour ở các địa điểm khác không?', 'N', '127.0.0.1', '2026-03-25 13:57:11', 999, NULL),
(377, 25, 'miền bắc', 'N', '127.0.0.1', '2026-03-25 13:57:18', 0, NULL),
(378, 25, 'Chào bạn, hiện tại GoViet Travel có tour đi miền Bắc là:\n\nTour Hà Nội - Hạ Long\n   Thời gian: 3 ngày 2 đêm\n       Ngày đi 01/04/2026:\n           Giá người lớn: 1.500.000 VNĐ\n           Giá trẻ em: 900.000 VNĐ\n           Chỗ còn: 1\n       Ngày đi 01/05/2026:\n           Giá người lớn: 1.670.000 VNĐ\n           Giá trẻ em: 980.000 VNĐ\n           Chỗ còn: 15\n       Ngày đi 01/05/2026:\n           Giá người lớn: 1.200.000 VNĐ\n           Giá trẻ em: 600.000 VNĐ\n           Chỗ còn: 6\n\nBạn có muốn biết thêm chi tiết về tour này không ạ?', 'N', '127.0.0.1', '2026-03-25 13:57:22', 999, NULL),
(379, 3, 'Chào bạn! ✨ Tôi là trợ lý AI của GoViet Travel. Tôi có thể giúp bạn tìm tour, báo giá hoặc kiểm tra lịch trình. Bạn muốn đi đâu nào?', 'N', '127.0.0.1', '2026-03-26 12:31:00', 999, NULL),
(380, 3, 'chào bạn có tour mới trong tháng 9 không', 'Y', '127.0.0.1', '2026-03-26 12:31:20', 0, NULL),
(381, 3, 'Chào bạn! Rất tiếc hiện tại GoViet Travel chưa có tour nào khởi hành trong tháng 9 theo dữ liệu hiện có ạ.\n\nBạn có muốn tìm tour vào các tháng khác hoặc có điểm đến cụ thể nào không để mình kiểm tra lại nhé?', 'N', '127.0.0.1', '2026-03-26 12:31:23', 999, NULL),
(382, 3, 'chào bạn', 'Y', '127.0.0.1', '2026-03-26 12:37:06', 1, NULL),
(383, 3, 'bạn cần giúp gì', 'Y', '127.0.0.1', '2026-03-26 12:40:42', 1, NULL),
(384, 3, 'tôi kím tour', 'N', '127.0.0.1', '2026-03-26 12:40:57', 0, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_checkout`
--

CREATE TABLE `tbl_checkout` (
  `checkoutid` int(11) NOT NULL,
  `bookingid` int(11) NOT NULL,
  `paymentmethod` varchar(50) DEFAULT NULL,
  `paymentdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `amount` double NOT NULL,
  `paymentstatus` varchar(50) NOT NULL,
  `transactionid` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_history`
--

CREATE TABLE `tbl_history` (
  `historyid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `actionType` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_history`
--

INSERT INTO `tbl_history` (`historyid`, `userid`, `actionType`, `timestamp`) VALUES
(1, 3, 'Hủy booking ID: 25', '2026-03-14 07:37:57'),
(2, 3, 'Đặt lại tour ID: 9', '2026-03-14 07:44:43'),
(3, 3, 'Đặt lại tour ID: 9', '2026-03-14 07:44:54'),
(4, 3, 'Hủy booking ID: 29', '2026-03-14 07:45:06'),
(5, 3, 'Hủy booking ID: 26', '2026-03-14 08:01:02'),
(6, 3, 'Admin duyệt booking ID: 28', '2026-03-14 08:15:57'),
(7, 3, 'Admin chuyển booking ID: 29 về chờ xử lý', '2026-03-14 16:24:52'),
(8, 3, 'Hủy booking ID: 27', '2026-03-14 11:35:42'),
(9, 3, 'Đặt lại tour ID: 1', '2026-03-14 11:56:16'),
(10, 3, 'Admin duyệt booking ID: 40', '2026-03-18 08:00:02'),
(11, 18, 'Thanh toán đặt cọc thành công qua MoMo cho đơn hàng #21', '2026-03-18 05:37:01'),
(12, 18, 'Thanh toán đặt cọc thành công qua MoMo cho đơn hàng #19', '2026-03-18 05:41:33'),
(13, 3, 'Admin duyệt booking ID: 44', '2026-03-18 12:43:43'),
(14, 18, 'Thanh toán đặt cọc thành công đơn hàng #21', '2026-03-18 06:11:05'),
(15, 18, 'Tạo đơn đặt tour mới (ID: 45). Phương thức: cash', '2026-03-18 06:57:08'),
(16, 13, 'Tạo đơn đặt tour mới (ID: 46). Phương thức: cash', '2026-03-18 07:18:20'),
(17, 3, 'Admin cập nhật Booking ID: 47 | Tour: PENDING | Thanh toán: DEPOSIT_PAID', '2026-03-18 14:29:19'),
(18, 3, 'Tạo đơn đặt tour mới (ID: 48). Phương thức: cash', '2026-03-18 07:31:38'),
(19, 3, 'Admin cập nhật Booking ID: 48 | Tour: PENDING | Thanh toán: PAID', '2026-03-18 14:32:06'),
(20, 3, 'Admin cập nhật Booking ID: 48 | Tour: PENDING | Thanh toán: DEPOSIT_PAID', '2026-03-18 14:32:12'),
(21, 3, 'Admin cập nhật Booking ID: 48 | Tour: PENDING | Thanh toán: REFUND_PENDING', '2026-03-18 14:32:19'),
(22, 3, 'Admin cập nhật Booking ID: 48 | Tour: CONFIRMED | Thanh toán: REFUND_PENDING', '2026-03-18 14:32:26'),
(23, 3, 'Tạo đơn đặt tour mới (ID: 49). Phương thức: cash', '2026-03-18 07:45:12'),
(24, 3, 'Admin cập nhật Booking ID: 49 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-18 14:45:30'),
(25, 3, 'Admin cập nhật Booking ID: 50 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-18 14:47:15'),
(26, 3, 'Thanh toán đặt cọc thành công đơn hàng #45', '2026-03-18 07:51:52'),
(27, 3, 'Admin cập nhật Booking ID: 47 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-18 14:55:33'),
(28, 3, 'Admin cập nhật Booking ID: 52 | Tour: PENDING | Thanh toán: PAID', '2026-03-18 15:15:03'),
(29, 3, 'Admin cập nhật Booking ID: 52 | Tour: PENDING | Thanh toán: PAID', '2026-03-18 15:21:41'),
(30, 3, 'Admin cập nhật Booking ID: 52 | Tour: PENDING | Thanh toán: PAID', '2026-03-18 15:21:44'),
(31, 3, 'Admin cập nhật Booking ID: 52 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-18 15:22:01'),
(32, 8, 'Tạo đơn đặt tour mới (ID: 53). Phương thức: cash', '2026-03-18 08:30:15'),
(33, 3, 'Admin cập nhật Booking ID: 53 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-18 15:32:55'),
(34, 8, 'Khách hàng hủy Tour #53. Trạng thái: Chờ hoàn tiền', '2026-03-18 09:07:20'),
(35, 3, 'Admin cập nhật Booking ID: 54 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-18 16:49:00'),
(36, 3, 'Admin cập nhật Booking ID: 55 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-18 17:10:21'),
(37, 3, 'Admin cập nhật Booking ID: 56 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-18 17:16:51'),
(38, 3, 'Admin cập nhật Booking ID: 46 | Tour: CONFIRMED | Thanh toán: UNPAID', '2026-03-20 13:06:13'),
(39, 3, 'Admin cập nhật Booking ID: 46 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-20 13:24:43'),
(40, 21, 'Tạo đơn đặt tour mới (ID: 57). Phương thức: cash', '2026-03-21 15:01:50'),
(41, 3, 'Tạo đơn đặt tour mới (ID: 58). Phương thức: cash', '2026-03-22 14:29:00'),
(42, 3, 'Tạo đơn đặt tour mới (ID: 59). Phương thức: cash', '2026-03-22 14:58:38'),
(43, 3, 'Tạo đơn đặt tour mới (ID: 60). Phương thức: cash', '2026-03-22 16:41:34'),
(44, 3, 'Admin cập nhật Booking ID: 60 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-22 17:05:05'),
(45, 3, 'Admin cập nhật Booking ID: 60 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-22 17:05:48'),
(46, 3, 'Admin cập nhật Booking ID: 59 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-22 17:07:27'),
(47, 3, 'Tạo đơn đặt tour mới (ID: 61). Phương thức: cash', '2026-03-23 10:28:50'),
(48, 3, 'Admin cập nhật Booking ID: 62 | Tour: CONFIRMED | Thanh toán: UNPAID', '2026-03-23 10:46:33'),
(49, 3, 'Admin cập nhật Booking ID: 62 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-23 10:47:54'),
(50, 3, 'Admin cập nhật Booking ID: 62 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-23 10:50:32'),
(51, 3, 'Admin cập nhật Booking ID: 62 | Tour: CANCELLED | Thanh toán: REFUND_PENDING', '2026-03-23 10:53:35'),
(52, 3, 'Admin cập nhật Booking ID: 62 | Tour: CANCELLED | Thanh toán: PAID', '2026-03-23 11:20:04'),
(53, 3, 'Admin cập nhật Booking ID: #62 | Tour: CANCELLED | Thanh toán: REFUND_PENDING', '2026-03-23 11:23:47'),
(54, 3, 'Admin cập nhật Booking ID: #62 | Tour: CANCELLED | Thanh toán: REFUNDED', '2026-03-23 11:24:04'),
(55, 3, 'Admin cập nhật Booking ID: #48 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-23 11:44:18'),
(56, 3, 'Admin đã thu tiền mặt 100% cho đơn hàng #49', '2026-03-23 11:45:09'),
(57, 3, 'Admin cập nhật Booking ID: #49 | Tour: CANCELLED | Thanh toán: REFUNDED', '2026-03-23 11:46:29'),
(58, 3, 'Admin cập nhật Booking ID: #49 | Tour: CANCELLED | Thanh toán: REFUNDED', '2026-03-23 11:46:34'),
(59, 3, 'Admin cập nhật Booking ID: #59 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-23 11:47:06'),
(60, 3, 'Admin cập nhật Booking ID: #59 | Tour: CANCELLED | Thanh toán: DEPOSIT_PAID', '2026-03-23 11:47:41'),
(61, 3, 'Admin cập nhật Booking ID: #49 | Tour: CANCELLED | Thanh toán: REFUND_PENDING', '2026-03-23 11:48:20'),
(62, 3, 'Admin cập nhật Booking ID: #62 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-23 12:20:59'),
(63, 3, 'Admin cập nhật Booking ID: #62 | Tour: CANCELLED | Thanh toán: PAID', '2026-03-23 12:21:29'),
(64, 3, 'Admin cập nhật Booking ID: #62 | Tour: CANCELLED | Thanh toán: REFUND_PENDING', '2026-03-23 12:22:05'),
(65, 3, 'Admin cập nhật Booking ID: #48 | Tour: CONFIRMED | Thanh toán: REFUNDED', '2026-03-23 12:22:22'),
(66, 3, 'Admin cập nhật Booking ID: #48 | Tour: CONFIRMED | Thanh toán: REFUNDED', '2026-03-23 12:22:26'),
(67, 3, 'Admin cập nhật Booking ID: #58 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-23 12:34:08'),
(68, 3, 'Admin cập nhật Booking ID: #62 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-23 13:20:36'),
(69, 3, 'Admin cập nhật Booking ID: #62 | Tour: CANCELLED | Thanh toán: REFUNDED', '2026-03-23 13:20:44'),
(70, 3, 'Tạo đơn đặt tour mới (ID: 63). Phương thức: cash', '2026-03-23 13:59:40'),
(71, 3, 'Tạo đơn đặt tour mới (ID: 64). Phương thức: cash', '2026-03-23 14:00:50'),
(72, 3, 'Tạo đơn đặt tour mới (ID: 65). Phương thức: paypal', '2026-03-23 14:05:08'),
(73, 3, 'Admin cập nhật Booking ID: #65 | Tour: CONFIRMED | Thanh toán: UNPAID', '2026-03-23 14:07:09'),
(74, 3, 'Admin cập nhật Booking ID: #65 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-23 14:07:16'),
(75, 3, 'Admin cập nhật Booking ID: #62 | Tour: CANCELLED | Thanh toán: PAID', '2026-03-23 14:07:52'),
(76, 3, 'Admin cập nhật Booking ID: #65 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-23 14:08:19'),
(77, 3, 'Admin cập nhật Booking ID: #65 | Tour: CANCELLED | Thanh toán: REFUND_PENDING', '2026-03-23 14:08:48'),
(78, 3, 'Admin cập nhật Booking ID: #65 | Tour: CANCELLED | Thanh toán: REFUNDED', '2026-03-23 14:09:12'),
(79, 25, 'Tạo đơn đặt tour mới (ID: 66). Phương thức: cash', '2026-03-24 11:05:38'),
(80, 3, 'Tạo đơn đặt tour mới (ID: 67). Phương thức: cash', '2026-03-25 06:01:29'),
(81, 3, 'Admin cập nhật Booking ID: #67 | Tour: PENDING | Thanh toán: DEPOSIT_PAID', '2026-03-25 06:38:06'),
(82, 3, 'Admin cập nhật Booking ID: #67 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-25 06:38:45'),
(83, 3, 'Tạo đơn đặt tour mới (ID: 68). Phương thức: cash', '2026-03-25 06:43:13'),
(84, 3, 'Admin cập nhật Booking ID: #69 | Tour: PENDING | Thanh toán: DEPOSIT_PAID', '2026-03-25 06:45:01'),
(85, 3, 'Admin cập nhật Booking ID: #69 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-25 06:49:24'),
(86, 3, 'Admin cập nhật Booking ID: #70 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-25 06:51:51'),
(87, 3, 'Admin cập nhật Booking ID: #70 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-25 06:52:44'),
(88, 3, 'Admin cập nhật Booking ID: #70 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-25 07:02:18'),
(89, 3, 'Admin cập nhật Booking ID: #68 | Tour: CONFIRMED | Thanh toán: PAID', '2026-03-25 07:02:52'),
(90, 3, 'Khởi tạo đơn đặt tour #71 thành công. Hình thức: cash', '2026-03-25 07:22:11'),
(91, 25, 'Tạo đơn đặt tour mới (ID: 72). Phương thức: cash', '2026-03-25 07:47:02'),
(92, 3, 'Admin đã thu tiền mặt 100% và xuất hóa đơn cho đơn hàng #72', '2026-03-25 07:47:37'),
(93, 25, 'Tạo đơn đặt tour mới (ID: 73). Phương thức: cash', '2026-03-25 09:48:53'),
(94, 25, 'Thanh toán đặt cọc thành công! (Đơn hàng #75)', '2026-03-25 13:53:40'),
(95, 25, 'Thanh toán 100% số dư thành công! (Đơn hàng #75)', '2026-03-25 13:54:29'),
(96, 27, 'Tạo đơn đặt tour mới (ID: 76). Phương thức: cash', '2026-03-25 14:41:35'),
(97, 3, 'Admin đã thu tiền mặt 100% và xuất hóa đơn cho đơn hàng #76', '2026-03-25 14:43:02'),
(98, 3, 'Admin cập nhật Booking ID: #76 | Tour: CANCELLED | Thanh toán: REFUNDED', '2026-03-25 15:06:49'),
(99, 3, 'Admin cập nhật Booking ID: #76 | Tour: CANCELLED | Thanh toán: REFUNDED', '2026-03-25 15:18:19'),
(100, 3, 'Admin cập nhật Booking ID: #76 | Tour: CONFIRMED | Thanh toán: DEPOSIT_PAID', '2026-03-25 15:18:31'),
(101, 3, 'Admin xác nhận thu tiền mặt 100% đơn #76', '2026-03-25 15:27:11'),
(102, 27, 'Thanh toán đặt cọc thành công! (Đơn hàng #77)', '2026-03-25 15:30:51'),
(103, 27, 'Thanh toán 100% số dư thành công! (Đơn hàng #77)', '2026-03-25 15:31:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_images`
--

CREATE TABLE `tbl_images` (
  `imageid` int(11) NOT NULL,
  `tourid` int(11) NOT NULL,
  `imageurl` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_images`
--

INSERT INTO `tbl_images` (`imageid`, `tourid`, `imageurl`, `description`, `uploadDate`) VALUES
(1, 321, 'gallery1.jpg', 'Ảnh toàn cảnh vịnh Hạ Long từ trên cao', '2026-03-04 08:06:58'),
(2, 1, 'gallery2.jpg', 'Du khách chèo thuyền Kayak', '2026-03-04 08:06:58'),
(3, 2, 'gallery3.jpg', 'Vườn hoa thành phố Đà Lạt', '2026-03-04 08:06:58'),
(4, 2, 'gallery4.jpg', 'Thung lũng tình yêu buổi sáng', '2026-03-04 08:06:58'),
(5, 1, 'gallery1.jpg', 'Cảnh buồm trên vịnh Hạ Long', '2026-03-04 08:12:47'),
(6, 1, 'gallery2.jpg', 'Hang Sửng Sốt Hạ Long', '2026-03-04 08:12:47'),
(7, 2, 'gallery3.jpg', 'Ruộng bậc thang Sapa', '2026-03-04 08:12:47'),
(8, 2, 'gallery4.jpg', 'Đỉnh Fansipan trong mây', '2026-03-04 08:12:47'),
(9, 3, 'gallery5.jpg', 'Bãi biển Phú Quốc', '2026-03-04 08:12:47'),
(10, 8, 'gallery2.jpg\r\n', 'Khám phá vẻ đẹp kỳ vĩ của Đà Lạt', '2026-03-17 10:51:17'),
(11, 0, '', '2 Ngày 1 đêm', '2026-03-04 10:52:56'),
(12, 8, 'gallery2.jpg', 'Khám phá vẻ đẹp kỳ vĩ của Đà Lạt', '2026-03-17 10:51:17'),
(13, 0, '', '2 Ngày 1 đêm', '2026-03-04 10:53:06'),
(14, 8, 'gallery2.jpg', 'Khám phá vẻ đẹp kỳ vĩ của Đà Lạt', '2026-03-17 10:51:17'),
(15, 0, '', '2 Ngày 1 đêm', '2026-03-04 10:54:54'),
(16, 1, 'gallery1.jpg', 'Toàn cảnh vịnh', '2026-03-04 12:40:30'),
(17, 1, 'gallery4.jpg', 'Du thuyền nghỉ đêm', '2026-03-04 12:40:30'),
(18, 1, 'gallery5.jpg', 'Hang động đẹp', '2026-03-04 12:40:30'),
(19, 8, 'gallery5.jpg', 'Ảnh 1', '2026-03-04 13:00:59'),
(20, 8, 'gallery4.jpg', 'Ảnh 2', '2026-03-04 13:00:59'),
(21, 9, 'gallery9.jpg', 'Cầu Vàng', '2026-03-04 14:05:33'),
(22, 9, 'gallery8.jpg', 'Bà Nà Hills', '2026-03-04 14:05:33'),
(23, 9, 'gallery6.jpg', 'Phố cổ Hội An', '2026-03-04 14:05:33'),
(24, 11, 'gallery5.jpg', 'Bãi Sao', '2026-03-04 14:05:33'),
(25, 11, 'gallery7.jpg', 'VinWonders', '2026-03-04 14:05:33'),
(26, 11, 'gallery3.jpg', 'Sunset Town', '2026-03-04 14:05:33'),
(27, 10, 'gallery5.jpg', 'Bãi Sao', '2026-03-04 14:05:33'),
(28, 10, 'gallery7.jpg', 'VinWonders', '2026-03-04 14:05:33'),
(29, 10, 'gallery3.jpg', 'Sunset Town', '2026-03-04 14:05:33'),
(30, 12, 'gallery5.jpg', 'Bãi Sao', '2026-03-04 14:05:33'),
(31, 12, 'gallery7.jpg', 'VinWonders', '2026-03-04 14:05:33'),
(32, 12, 'gallery3.jpg', 'Sunset Town', '2026-03-04 14:05:33'),
(35, 17, '1773157201_69b03b51845d7.jpg', NULL, '2026-03-10 15:40:01'),
(37, 17, '1773508005_gallery_69b595a54c7e0.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:06:45'),
(38, 17, '1773508005_gallery_69b595a54d560.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:06:45'),
(39, 17, '1773508005_gallery_69b595a54dd59.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:06:45'),
(40, 17, '1773508005_gallery_69b595a54e59b.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:06:45'),
(41, 17, '1773508005_gallery_69b595a54ebdd.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:06:45'),
(42, 17, '1773508068_gallery_69b595e4ad92c.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:07:48'),
(43, 17, '1773508068_gallery_69b595e4aeabc.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:07:48'),
(44, 17, '1773508068_gallery_69b595e4af3f3.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:07:48'),
(45, 17, '1773508068_gallery_69b595e4afb57.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:07:48'),
(46, 17, '1773508068_gallery_69b595e4b0319.png', 'Ảnh chi tiết Test tour 1111', '2026-03-14 10:07:48'),
(52, 19, '1773510969_gallery_69b5a139d0c04.png', 'Ảnh chi tiết test tour 2', '2026-03-14 10:56:09'),
(53, 19, '1773510969_gallery_69b5a139d2028.png', 'Ảnh chi tiết test tour 2', '2026-03-14 10:56:09'),
(54, 19, '1773510969_gallery_69b5a139d2745.png', 'Ảnh chi tiết test tour 2', '2026-03-14 10:56:09'),
(55, 19, '1773510969_gallery_69b5a139d2f2f.png', 'Ảnh chi tiết test tour 2', '2026-03-14 10:56:09'),
(56, 19, '1773510997_gallery_69b5a1551c1bf.png', 'Ảnh chi tiết test tour 2', '2026-03-14 10:56:37'),
(57, 20, '1773553653_gallery_69b647f54e29f.png', 'Ảnh chi tiết tour 12', '2026-03-14 22:47:33'),
(58, 20, '1773553653_gallery_69b647f54ef73.png', 'Ảnh chi tiết tour 12', '2026-03-14 22:47:33'),
(59, 20, '1773553653_gallery_69b647f54f769.png', 'Ảnh chi tiết tour 12', '2026-03-14 22:47:33'),
(60, 20, '1773553653_gallery_69b647f54fea0.png', 'Ảnh chi tiết tour 12', '2026-03-14 22:47:33'),
(61, 20, '1773553653_gallery_69b647f550805.png', 'Ảnh chi tiết tour 12', '2026-03-14 22:47:33'),
(62, 21, '1773553830_gallery_69b648a6271f8.png', 'Ảnh chi tiết Test tour 13', '2026-03-14 22:50:30'),
(63, 21, '1773553830_gallery_69b648a627bf8.png', 'Ảnh chi tiết Test tour 13', '2026-03-14 22:50:30'),
(64, 21, '1773553830_gallery_69b648a62849d.png', 'Ảnh chi tiết Test tour 13', '2026-03-14 22:50:30'),
(65, 21, '1773553830_gallery_69b648a628bfd.png', 'Ảnh chi tiết Test tour 13', '2026-03-14 22:50:30'),
(66, 21, '1773553830_gallery_69b648a629479.png', 'Ảnh chi tiết Test tour 13', '2026-03-14 22:50:30'),
(72, 25, '1773579785_gallery_69b6ae09814a3.png', 'Ảnh chi tiết tour 1', '2026-03-15 06:03:05'),
(73, 25, '1773579785_gallery_69b6ae0981e72.png', 'Ảnh chi tiết tour 1', '2026-03-15 06:03:05'),
(74, 25, '1773579785_gallery_69b6ae0982625.png', 'Ảnh chi tiết tour 1', '2026-03-15 06:03:05'),
(75, 25, '1773579785_gallery_69b6ae0982cbd.png', 'Ảnh chi tiết tour 1', '2026-03-15 06:03:05'),
(76, 25, '1773579785_gallery_69b6ae098337a.png', 'Ảnh chi tiết tour 1', '2026-03-15 06:03:05'),
(77, 321, '1774196628_gallery_69c0179426443.png', NULL, '2026-03-22 16:23:48'),
(78, 321, '1774196628_gallery_69c01794272a7.png', NULL, '2026-03-22 16:23:48'),
(79, 321, '1774196628_gallery_69c0179427a17.png', NULL, '2026-03-22 16:23:48'),
(80, 321, '1774196628_gallery_69c0179428247.png', NULL, '2026-03-22 16:23:48'),
(81, 321, '1774196628_gallery_69c01794289d2.png', NULL, '2026-03-22 16:23:48'),
(82, 322, '1774196823_gallery_69c018574f2ed.png', 'Ảnh chi tiết dddd', '2026-03-22 16:27:03'),
(83, 322, '1774196823_gallery_69c018574fc1b.png', 'Ảnh chi tiết dddd', '2026-03-22 16:27:03'),
(84, 322, '1774196823_gallery_69c0185750164.png', 'Ảnh chi tiết dddd', '2026-03-22 16:27:03'),
(85, 322, '1774196823_gallery_69c018575056a.png', 'Ảnh chi tiết dddd', '2026-03-22 16:27:03'),
(86, 322, '1774196823_gallery_69c0185750a90.png', 'Ảnh chi tiết dddd', '2026-03-22 16:27:03'),
(92, 324, '1774200192_gallery_69c025804774e.png', 'Ảnh chi tiết hòa Minh', '2026-03-22 17:23:12'),
(93, 324, '1774200192_gallery_69c0258047e14.png', 'Ảnh chi tiết hòa Minh', '2026-03-22 17:23:12'),
(94, 324, '1774200192_gallery_69c02580482b4.png', 'Ảnh chi tiết hòa Minh', '2026-03-22 17:23:12'),
(95, 324, '1774200192_gallery_69c0258048706.png', 'Ảnh chi tiết hòa Minh', '2026-03-22 17:23:12'),
(96, 324, '1774200192_gallery_69c0258048dc7.png', 'Ảnh chi tiết hòa Minh', '2026-03-22 17:23:12'),
(97, 325, '1774445387_gallery_69c3e34bce34e.png', NULL, '2026-03-25 13:29:47'),
(98, 325, '1774445387_gallery_69c3e34bceb77.png', NULL, '2026-03-25 13:29:47'),
(99, 325, '1774445387_gallery_69c3e34bcf15e.png', NULL, '2026-03-25 13:29:47'),
(100, 325, '1774445387_gallery_69c3e34bcf683.png', NULL, '2026-03-25 13:29:47'),
(101, 325, '1774445387_gallery_69c3e34bcfb14.png', NULL, '2026-03-25 13:29:47'),
(102, 326, '1774446074_gallery_69c3e5fab33bc.png', NULL, '2026-03-25 13:41:14'),
(103, 326, '1774446074_gallery_69c3e5fab3ad3.png', NULL, '2026-03-25 13:41:14'),
(104, 326, '1774446074_gallery_69c3e5fab418f.png', NULL, '2026-03-25 13:41:14'),
(105, 326, '1774446074_gallery_69c3e5fab44fb.png', NULL, '2026-03-25 13:41:14'),
(106, 326, '1774446074_gallery_69c3e5fab48a9.png', NULL, '2026-03-25 13:41:14'),
(107, 327, '1774446630_gallery_69c3e82630fc7.png', NULL, '2026-03-25 13:50:30'),
(108, 327, '1774446630_gallery_69c3e82631528.png', NULL, '2026-03-25 13:50:30'),
(109, 327, '1774446630_gallery_69c3e826319c8.png', NULL, '2026-03-25 13:50:30'),
(110, 327, '1774446630_gallery_69c3e82631ee7.png', NULL, '2026-03-25 13:50:30'),
(111, 327, '1774446630_gallery_69c3e82632466.png', NULL, '2026-03-25 13:50:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `invoiceid` int(11) NOT NULL,
  `bookingid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `detelssued` date NOT NULL,
  `totalamount` double NOT NULL,
  `detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`invoiceid`, `bookingid`, `userid`, `email`, `detelssued`, `totalamount`, `detail`) VALUES
(1, 46, 13, 'khachhang@gmail.com', '2026-03-18', 2000000, 'Hóa đơn bổ sung'),
(2, 59, 3, 'khachhang@gmail.com', '2026-03-22', 2400000, 'Hóa đơn bổ sung'),
(3, 60, 3, 'khachhang@gmail.com', '2026-03-22', 1000011, 'Hóa đơn bổ sung'),
(4, 62, 3, 'khachhang@gmail.com', '2026-03-23', 11555, 'Hóa đơn bổ sung'),
(5, 67, 3, 'khachhang@gmail.com', '2026-03-25', 3000033, 'Hóa đơn bổ sung'),
(6, 69, 3, 'khachhang@gmail.com', '2026-03-25', 1000011, 'Hóa đơn bổ sung'),
(7, 70, 3, 'khachhang@gmail.com', '2026-03-25', 1002233, 'Hóa đơn bổ sung'),
(8, 68, 3, NULL, '2026-03-25', 1000011, 'Hóa đơn Tour: dddd'),
(9, 72, 25, 'mup3102007111@hotmail.com', '2026-03-25', 1002233, 'Hóa đơn thanh toán cho Tour: dddd'),
(10, 75, 25, 'khach@gmail.com', '2026-03-25', 10080.9, 'Hóa đơn Tour: Hội An'),
(11, 76, 27, 'nhatquan12497@hotmail.com', '2026-03-25', 11880, 'Hóa đơn thanh toán cho Tour: Test thêm tour'),
(12, 77, 27, 'vuongvanbui20@gmail.com', '2026-03-25', 11880, 'Hóa đơn Tour: Test thêm tour');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_promotion`
--

CREATE TABLE `tbl_promotion` (
  `promotionid` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_percent` double NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_promotion`
--

INSERT INTO `tbl_promotion` (`promotionid`, `code`, `discount_percent`, `startdate`, `enddate`, `quantity`) VALUES
(1, 'GoViet10', 10, '2026-03-19', '2026-03-27', 0),
(2, 'Goviet90', 90, '2026-03-25', '2026-04-24', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_reviews`
--

CREATE TABLE `tbl_reviews` (
  `reviewid` int(11) NOT NULL,
  `tourid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `rating` int(11) DEFAULT 5,
  `comment` text DEFAULT NULL,
  `createdat` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1,
  `admin_reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_reviews`
--

INSERT INTO `tbl_reviews` (`reviewid`, `tourid`, `userid`, `rating`, `comment`, `createdat`, `status`, `admin_reply`) VALUES
(1, 23, 3, 5, 'quá suất sắt', '2026-03-15 04:32:31', 1, NULL),
(2, 321, 3, 5, 'oke qua', '2026-03-23 14:00:09', 1, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_timeline`
--

CREATE TABLE `tbl_timeline` (
  `timelineID` int(11) NOT NULL,
  `tourid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_timeline`
--

INSERT INTO `tbl_timeline` (`timelineID`, `tourid`, `title`, `description`) VALUES
(1, 1, 'Ngày 1: Đón khách và Khởi hành', '0'),
(2, 1, 'Ngày 2: Thăm hang Sửng Sốt', '0'),
(3, 2, 'Ngày 1: Khám phá Phố cổ Hội An', '0'),
(4, 2, 'Ngày 2: Bà Nà Hills - Cầu Vàng', '0'),
(5, 9, 'Ngày 1', '0'),
(6, 9, 'Ngày 2', '0'),
(7, 9, 'Ngày 3', '0'),
(8, 10, 'Ngày 1', '0'),
(9, 10, 'Ngày 2', '0'),
(10, 10, 'Ngày 3', '0'),
(11, 10, 'Ngày 4', '0'),
(12, 10, 'Ngày 1', '0'),
(13, 10, 'Ngày 2', '0'),
(14, 10, 'Ngày 3', '0'),
(15, 10, 'Ngày 4', '0'),
(24, 25, 'Ăn Uống 1', 'fiuewfhuerh ì r heit  iherthhrt h  ehh eh  fiuewfhuerh ì r heit  iherthhrt h  ehh eh'),
(29, 21, 'Ăn Uống 1', 'JDSUIDHU BUICBUIWUIC  SJICSIC SBUIACIUSB SC HS USJICSIC SBUIACIUSB SC HS U\r\nSJICSIC SBUIACIUSB SC HS USJICSIC SBUIACIUSB SC HS U\r\nSJICSIC SBUIACIUSB SC HS U\r\nSJICSIC SBUIACIUSB SC HS UV\r\nSJICSIC SBUIACIUSB SC HS USJICSIC SBUIACIUSB SC HS U'),
(30, 21, 'Gia Lai', 'SJICSIC SBUIACIUSB SC HS USJICSIC SBUIACIUSB SC HS USJICSIC SBUIACIUSB SC HS USJICSIC SBUIACIUSB SC HS USJICSIC SBUIACIUSB SC HS USJICSIC SBUIACIUSB SC HS U'),
(32, 322, 'Ăn Uống 1', 'qqqqqqqqqq'),
(33, 327, 'Ăn Uống 1', 'qưd vHội An là một thành phố cổ thuộc tỉnh Quảng Nam, nổi tiếng với vẻ đẹp trầm mặc, di sản văn hóa và các hoạt động du lịch hấp dẫn.\r\nồn'),
(34, 327, 'Đi chơi', 'Biển An Bàng: Một bãi biển đẹp, lý tưởng để thư giãn và tắm nắng.\r\nLàng nghề truyền thống: Du khách có thể tham quan và trải nghiệm các nghề thủ công như làm đèn lồng, gốm sứ, và dệt vải. \r\n2\r\n\r\n\r\n2 Nguồn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_tours`
--

CREATE TABLE `tbl_tours` (
  `tourid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `time` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `availability` tinyint(1) NOT NULL,
  `domain` enum('b','t','n') NOT NULL COMMENT '''b''= Miền Bắc\r\n''t''= Miền trung\r\n''n''=Miền nam',
  `reviews` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `destination` varchar(255) NOT NULL,
  `images` text NOT NULL,
  `departure_city` varchar(255) DEFAULT NULL COMMENT 'Điểm đón'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_tours`
--

INSERT INTO `tbl_tours` (`tourid`, `title`, `time`, `description`, `availability`, `domain`, `reviews`, `duration`, `destination`, `images`, `departure_city`) VALUES
(1, 'Tour Vịnh Hạ Long - Du thuyền 5 sao', '3 ngày 3 đêm', 'Ngày 4: Tham quan Haha...', 0, 'b', NULL, 'Khám phá vẻ đẹp kỳ vĩ của Vịnh Hạ Long, thăm hang Sửng Sốt và chèo thuyền Kayak tại hang Luồn.', 'Hạ Long', '1773509210_main_69b59a5a7ea56.png', NULL),
(2, 'Tour Hà Nội - Hạ Long', '3 ngày 2 đêm', '<p>Khám phá vẻ đẹp thiên nhiên và văn hóa của Hà Nội và Hạ Long.</p>', 1, 'b', '', '3 ngày 2 đêm', 'Hà Nội - Hạ Long', '[\"ha-noi.jpg\",\"ha-long.jpg\",\"du-thuyen.jpg\",\"hang-sung-sot.jpg\",\"trang-an.jpg\"]', NULL),
(9, 'Nha Trang 3N2Đ', '3 ngày 3 đêm', '<p>Ngày 1: Tham quan VinWonders...</p>', 1, 'b', '5', 'Tour du lịch Nha Trang trọn gói', 'Nha Trang', '1773509248_main_69b59a806c03c.png', NULL),
(10, 'Tour Hạ Long 2N1Đ', '2 ngày 1 đêm', 'Du thuyền Vịnh Hạ Long', 1, '', '120', '2N1Đ', 'Hạ Long', '', NULL),
(11, 'Tour Phú Quốc 4N3Đ', '4 ngày 3 đêm', 'Biển xanh - VinWonders - 4 đảo', 1, '', '98', '4N3Đ', 'Phú Quốc', '', NULL),
(12, 'Tour Sapa 3N2Đ', '3 ngày 2 đêm', '<p>Fansipan - Bản Cát Cát</p>', 1, 'b', '75', '3N2Đ', 'Sapa', '1773580005_main_69b6aee51f428.png', NULL),
(17, 'Test tour 1111', NULL, '<p>fgfhrghdsfgdgfdg   àn dsbufueif few ew9r ewrew8r8fbwefy8 ư</p>', 1, 'b', NULL, '1ngày', 'QN', '1773508141_main_69b5962d38339.png', NULL),
(19, 'test tour 2', '3 ngày 3 đêm', '<p>test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1test tour 1</p>', 1, 'b', NULL, '1ngày', 'HCM 11', '1773509959_main_69b59d47aff8c.png', NULL),
(20, 'tour 12', '3 ngày 3 đêm', '<p>TEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f feTEST TOUR 12 mở bán iudsf fewfgew fefbu f fe</p>', 1, 'n', NULL, 'Khám phá vẻ đẹp kỳ vĩ của Vịnh Hạ Long, thăm hang Sửng Sốt và chèo thuyền Kayak tại hang Luồn.', 'gia lai', '1773553653_main_69b647f544344.png', NULL),
(21, 'Test tour 13', '4 ngày 3 đêm', '<p>DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau DakLak Du lich Việt nam Du Lịch DakKAk Măng đen Acf mau&nbsp;</p>', 1, 'n', NULL, 'Tour du lịch Đaklak trọn gói', 'Cà mau', '1773553830_main_69b648a61f5c3.png', NULL),
(22, 'Test thêm chi tiết lịch', '3 ngày 3 đêm', '<p>Test thêm chi tiết lịch Test thêm chi tiết lịch Test thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchùihrgfi hơiefher ghẻ gẻgeghgheghe&nbsp;</p>', 1, 'b', NULL, 'Tour du lịch Đaklak trọn gói', 'Chi Tiết', '1773562038_main_69b668b622033.png', NULL),
(23, 'Test thêm chi tiết lịch', '3 ngày 3 đêm', '<p>Test thêm chi tiết lịch Test thêm chi tiết lịch Test thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchTest thêm chi tiết lịchùihrgfi hơiefher ghẻ gẻgeghgheghe&nbsp;</p>', 1, 'b', NULL, 'Tour du lịch Đaklak trọn gói', 'Chi Tiết', '1773580226_main_69b6afc22271b.png', NULL),
(25, 'tour 1', '3 ngày 3 đêm', '<p>&nbsp; fiuewfhuerh ì r heit &nbsp;iherthhrt h &nbsp;ehh eh &nbsp;fiuewfhuerh ì r heit &nbsp;iherthhrt h &nbsp;ehh eh &nbsp;fiuewfhuerh ì r heit &nbsp;iherthhrt h &nbsp;ehh eh&nbsp;</p>', 1, 'b', NULL, NULL, 'QN', '1773579785_main_69b6ae0976c18.png', NULL),
(321, 'Tour Hà Nội - Hạ Long', '3 ngày 2 đêm', '<p>Khám phá vẻ đẹp thiên nhiên và văn hóa của Hà Nội và Hạ Long.</p>', 1, 'b', '', '3 ngày 2 đêm', 'Hà Nội - Hạ Long', '1773508141_main_69b5962d38339.png', NULL),
(322, 'dddd', '3 ngày 3 đêm', '<p>sddfewferv</p>', 1, 'b', NULL, '1ngày', 'dddd', '1774196823_main_69c018574d3a4.png', NULL),
(324, 'hòa Minh', '3 ngày 2 đêm', '<p>1@extends(\'admi</p><p>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<i>.accordion</i> <i>.card-header</i> button[<i>aria-expanded</i>=\"true\"] i<i>.fa-angle-down</i> { transform: rotate(180deg); transition: 0.3s; }</p><p>&nbsp; &nbsp; &lt;/style&gt;</p><p>@stop</p><p><br>&nbsp;</p><p>@section(\'js\')</p><p>&nbsp; &nbsp; &lt;script <i>src</i>=\"https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js\"&gt;&lt;/script&gt;</p><p>&nbsp; &nbsp; &lt;script&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; // 1. CKEditor</p><p>&nbsp; &nbsp; &nbsp; &nbsp; ClassicEditor.create(document.querySelector(\'#editor\')).catch(<i>error</i> =&gt; { console.error(error); });</p><p><br>&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; // 2. Preview Ảnh Chính</p><p>&nbsp; &nbsp; &nbsp; &nbsp; document.getElementById(\'main-image-input\').addEventListener(\'change\', function(<i>e</i>) {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const file = e.target.files[0];</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const preview = document.getElementById(\'main-image-preview\');</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; if (file) {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const reader = <strong>new</strong> FileReader();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; reader.onload = (<i>event</i>) =&gt; {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; preview.querySelector(\'img\').src = event.target.result;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; preview.style.display = \'block\';</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; }</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; reader.readAsDataURL(file);</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; }</p><p>&nbsp; &nbsp; &nbsp; &nbsp; });</p><p><br>&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; // 3. Preview Gallery</p><p>&nbsp; &nbsp; &nbsp; &nbsp; document.getElementById(\'gallery-image-input\').addEventListener(\'change\', function(<i>e</i>) {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const preview = document.getElementById(\'gallery-image-preview\');</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; preview.innerHTML = \'\';</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Array.from(e.target.files).slice(0, 5).forEach(<i>file</i> =&gt; {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const reader = <strong>new</strong> FileReader();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; reader.onload = (<i>event</i>) =&gt; {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const img = `&lt;div class=\"mr-2 mb-2\"&gt;&lt;img src=\"${event.target.result}\" class=\"img-thumbnail\" style=\"height: 60px; width: 60px; object-fit: cover;\"&gt;&lt;/div&gt;`;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; preview.insertAdjacentHTML(\'beforeend\', img);</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; }</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; reader.readAsDataURL(file);</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; });</p><p>&nbsp; &nbsp; &nbsp; &nbsp; });</p><p><br>&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; // 4. Timeline Logic</p><p>&nbsp; &nbsp; &nbsp; &nbsp; function addTimeline() {</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const wrapper = document.getElementById(\'timeline-wrapper\');</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const count = wrapper.querySelectorAll(\'.timeline-item\').length + 1;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const uniqueId = Date.now();</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; const html = `</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"card card-outline card-secondary mb-2 timeline-item border shadow-none\"&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &lt;div class=\"card-header p-2\"&gt;</p><p>&nbsp;</p>', 1, 'b', NULL, 'Tour du lịch Nha Trang trọn gói', 'Chi Tiết', '1774200192_main_69c0258045590.png', NULL),
(325, 'Tsee', '3 ngày 2 đêm', '<p><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;hr&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;{{-- THÔNG TIN GIÁ &amp; THỜI GIAN --}}<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;div class=\"row\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;div class=\"col-md-3\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;div class=\"form-group\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;label&gt;Ghi chú khởi hành&lt;/label&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;input type=\"text\" name=\"time\" class=\"form-control\" placeholder=\"VD: Thứ 7 hàng tuần\" value=\"{{ old(\'time\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;div class=\"col-md-3\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;div class=\"form-group\"&gt;<br>w\" data-parent=\"#timeline-wrapper\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;div class=\"card-body bg-light\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;input type=\"text\" name=\"timeline_title[]\" class=\"form-control title-input mb-2\" placeholder=\"Tiêu đề ngày\" onkeyup=\"updatePreviewTitle(this)\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;textarea name=\"timeline_description[]\" class=\"form-control\" rows=\"3\" placeholder=\"Mô tả lịch trình...\"&gt;&lt;/textarea&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>&nbsp; &nbsp; &nbsp; &nbsp;&lt;div class=\"card-footer text-right bg-white\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;a href=\"{{ route(\'admin.tours.index\') }}\" class=\"btn btn-default mr-2\"&gt;Hủy bỏ&lt;/a&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;button type=\"submit\" class=\"btn btn-primary shadow px-5\"&gt;&lt;i class=\"fas fa-save mr-1\"&gt;&lt;/i&gt; LƯU TOUR&lt;/button&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;<br>&nbsp; &nbsp;&lt;/form&gt;<br>&lt;/div&gt;<br>@stop</p><p>@section(\'css\')<br>&nbsp; &nbsp;&lt;style&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;.ck-editor__editable_inline { min-height: 200px; }<br>&nbsp; &nbsp; &nbsp; &nbsp;.gap-2 { gap: 0.5rem; }<br>&nbsp; &nbsp; &nbsp; &nbsp;.timeline-item .btn-link:hover { text-decoration: none; }<br>&nbsp; &nbsp;&lt;/style&gt;<br>@stop</p><p>@section(\'js\')<br>&nbsp; &nbsp;&lt;script src=\"https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js\"&gt;&lt;/script&gt;<br>&nbsp; &nbsp;&lt;script&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp;// 1. Editor<br>&nbsp; &nbsp; &nbsp; &nbsp;ClassicEditor.create(document.querySelector(\'#editor\')).catch(error =&gt; { console.error(error); });</p><p>&nbsp; &nbsp; &nbsp; &nbsp;// 2. Image Previews<br>&nbsp; &nbsp; &nbsp; &nbsp;function setupPreview(inputId, previewId, isMultiple = false) {<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;document.getElementById(inputId).addEventListener(\'change\', function(e) {<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;const container = document.getElementById(previewId);<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;if (!isMultiple) container.innerHTML = \'&lt;img src=\"\" class=\"img-thumbnail\" style=\"height: 100px; width: 100%; object-fit: cover;\"&gt;\';<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;else container.innerHTML = \'\';</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;const files = Array.from(e.target.files);<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;files.forEach(file =&gt; {<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;const reader = new FileReader();<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;reader.onload = function(event) {<br>&nbsp;&nbsp;</p>', 1, 't', NULL, '1ngày', 'QN', '1774445387_main_69c3e34bcbcfe.png', NULL),
(326, 'Test thêm tour', NULL, '<p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>&nbsp;</p><p>&nbsp;</p><p>hội an&nbsp;</p><p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;/div&gt;</p><p>\" name=\"enddate\" class=\"form-control\" value=\"{{ old(\'enddate\') }}\"&gt;<br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&lt;</p><p>AN&nbsp;<br>&nbsp;</p><p>s</p><p>fd</p><p>&nbsp;g<br>&nbsp;</p>', 1, 't', NULL, '1ngày', 'Hội An', '1774446074_main_69c3e5fab0a02.png', NULL),
(327, 'Hội An', '3 ngày 2 đêm', '<p><strong>Hội An là một thành phố cổ thuộc tỉnh Quảng Nam, nổi tiếng với vẻ đẹp trầm mặc, di sản văn hóa và các hoạt động du lịch hấp dẫn.</strong></p><h3>Vị trí địa lý</h3><p><a href=\"https://www.bing.com/ck/a?!&amp;&amp;p=e1d9cc28f351a02c30457d8615c1b363678c0ad4f3503df9ca45ec84cc8f560fJmltdHM9MTc3NDM5NjgwMA&amp;ptn=3&amp;ver=2&amp;hsh=4&amp;fclid=07934bc4-60a5-68ab-3e3e-584e61c36907&amp;psq=h%e1%bb%99i+an&amp;u=a1aHR0cHM6Ly92aW5wZWFybC5jb20vdmkvaG9pLWFuLW8tZGF1LWtpbmgtbmdoaWVtLWRpLWNodXllbi1sdXUtdHJ1LXR1LWEteg&amp;ntb=1\">Hội An nằm ở miền Trung Việt Nam, cách thành phố Đà Nẵng khoảng 30 km về phía Đông Nam và cách thành phố Tam Kỳ khoảng 50 km về phía Đông Bắc. Thành phố này nằm bên bờ Bắc hạ lưu sông Thu Bồn, có diện tích khoảng 61,71 km² và được thành lập với 13 đơn vị hành chính.</a></p><p>&nbsp;</p><p><a href=\"https://www.bing.com/ck/a?!&amp;&amp;p=e1d9cc28f351a02c30457d8615c1b363678c0ad4f3503df9ca45ec84cc8f560fJmltdHM9MTc3NDM5NjgwMA&amp;ptn=3&amp;ver=2&amp;hsh=4&amp;fclid=07934bc4-60a5-68ab-3e3e-584e61c36907&amp;psq=h%e1%bb%99i+an&amp;u=a1aHR0cHM6Ly92aW5wZWFybC5jb20vdmkvaG9pLWFuLW8tZGF1LWtpbmgtbmdoaWVtLWRpLWNodXllbi1sdXUtdHJ1LXR1LWEteg&amp;ntb=1\">Vinpearl<strong>+1</strong></a></p><h3>Lịch sử và văn hóa</h3><p><a href=\"https://www.bing.com/ck/a?!&amp;&amp;p=1449ee05bd98a73c15c79d045ba78491e2bca1b696486a111eeb0ebbd14762b2JmltdHM9MTc3NDM5NjgwMA&amp;ptn=3&amp;ver=2&amp;hsh=4&amp;fclid=07934bc4-60a5-68ab-3e3e-584e61c36907&amp;psq=h%e1%bb%99i+an&amp;u=a1aHR0cHM6Ly92aS53aWtpcGVkaWEub3JnL3dpa2kvSCVFMSVCQiU5OWlfQW5fKHRoJUMzJUEwbmhfcGglRTElQkIlOTEp&amp;ntb=1\">Hội An từng là một thương cảng quốc tế sầm uất từ thế kỷ XVI – XVII, nơi giao thương giữa các thương nhân Việt, Nhật, Trung Quốc và nhiều quốc gia phương Tây. Phố cổ Hội An đã được UNESCO công nhận là Di sản Văn hóa Thế giới từ năm 1999, nhờ vào kiến trúc giao thoa Á – Âu độc đáo và các di sản văn hóa phong phú.</a></p><p>&nbsp;</p><p><a href=\"https://www.bing.com/ck/a?!&amp;&amp;p=1449ee05bd98a73c15c79d045ba78491e2bca1b696486a111eeb0ebbd14762b2JmltdHM9MTc3NDM5NjgwMA&amp;ptn=3&amp;ver=2&amp;hsh=4&amp;fclid=07934bc4-60a5-68ab-3e3e-584e61c36907&amp;psq=h%e1%bb%99i+an&amp;u=a1aHR0cHM6Ly92aS53aWtpcGVkaWEub3JnL3dpa2kvSCVFMSVCQiU5OWlfQW5fKHRoJUMzJUEwbmhfcGglRTElQkIlOTEp&amp;ntb=1\">Wikipedia<strong>+1</strong></a></p><h3>Điểm tham quan và hoạt động</h3><p>Hội An không chỉ nổi bật với cảnh sắc thanh bình mà còn hấp dẫn bởi những công trình kiến trúc cổ, làng nghề truyền thống và nền ẩm thực phong phú. Một số điểm tham quan nổi bật bao gồm:</p><p><strong>Phố cổ Hội An</strong>: Nơi lưu giữ nhiều ngôi nhà cổ, chùa chiền và hội quán mang đậm dấu ấn lịch sử.</p><p><strong>Biển An Bàng</strong>: Một bãi biển đẹp, lý tưởng để thư giãn và tắm nắng.</p><p><a href=\"https://www.bing.com/ck/a?!&amp;&amp;p=e1d9cc28f351a02c30457d8615c1b363678c0ad4f3503df9ca45ec84cc8f560fJmltdHM9MTc3NDM5NjgwMA&amp;ptn=3&amp;ver=2&amp;hsh=4&amp;fclid=07934bc4-60a5-68ab-3e3e-584e61c36907&amp;psq=h%e1%bb%99i+an&amp;u=a1aHR0cHM6Ly92aW5wZWFybC5jb20vdmkvaG9pLWFuLW8tZGF1LWtpbmgtbmdoaWVtLWRpLWNodXllbi1sdXUtdHJ1LXR1LWEteg&amp;ntb=1\"><strong>Làng nghề truyền thống</strong>: Du khách có thể tham quan và trải nghiệm các nghề thủ công như làm đèn lồng, gốm sứ, và dệt vải.</a></p><p>&nbsp;</p><p><a href=\"https://www.bing.com/ck/a?!&amp;&amp;p=e1d9cc28f351a02c30457d8615c1b363678c0ad4f3503df9ca45ec84cc8f560fJmltdHM9MTc3NDM5NjgwMA&amp;ptn=3&amp;ver=2&amp;hsh=4&amp;fclid=07934bc4-60a5-68ab-3e3e-584e61c36907&amp;psq=h%e1%bb%99i+an&amp;u=a1aHR0cHM6Ly92aW5wZWFybC5jb20vdmkvaG9pLWFuLW8tZGF1LWtpbmgtbmdoaWVtLWRpLWNodXllbi1sdXUtdHJ1LXR1LWEteg&amp;ntb=1\"><strong>2</strong></a></p><p><img src=\"https://th.bing.com/th/id/ODF.s9HxZ8NPKgiUDJmwr1quCw?w=16&amp;h=16&amp;c=10&amp;o=6&amp;dpr=1.3&amp;pid=genserp&amp;rm=2\"></p><p><img src=\"https://th.bing.com/th/id/ODF.JdQKXsBbPVyKGy4WmGvjew?w=16&amp;h=16&amp;c=10&amp;o=6&amp;dpr=1.3&amp;pid=genserp&amp;rm=2\"></p><p>&nbsp;</p><p>2 Nguồn</p>', 1, 't', NULL, '1ngày', 'QNam', '1774446630_main_69c3e8262ef25.png', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_tour_pickups`
--

CREATE TABLE `tbl_tour_pickups` (
  `pickup_id` int(11) NOT NULL,
  `tourid` int(11) NOT NULL,
  `pickup_name` varchar(255) NOT NULL COMMENT 'tên điểm đón',
  `pickup_time` time NOT NULL COMMENT 'giờ đón',
  `extra_price` decimal(10,2) DEFAULT 0.00 COMMENT 'phụ phí',
  `fee_type` tinyint(1) DEFAULT 0 COMMENT '-- 0: Theo đầu người, 1: Theo đoàn (Cố định)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='điểm đón kh';

--
-- Đang đổ dữ liệu cho bảng `tbl_tour_pickups`
--

INSERT INTO `tbl_tour_pickups` (`pickup_id`, `tourid`, `pickup_name`, `pickup_time`, `extra_price`, `fee_type`) VALUES
(3, 322, 'Hà Nội', '03:23:00', 10000.00, 0),
(4, 322, 'tại nhà', '02:25:00', 50000.00, 0),
(5, 324, 'Hà Nội', '12:24:00', 50000.00, 0),
(6, 326, 'Hà Nội', '23:43:00', 1000.00, 0),
(7, 327, 'hạ long', '20:50:00', 0.00, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_tour_schedules`
--

CREATE TABLE `tbl_tour_schedules` (
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `tourid` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceadult` int(11) DEFAULT NULL,
  `pricechild` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='nhiều ngày cho 1 tour';

--
-- Đang đổ dữ liệu cho bảng `tbl_tour_schedules`
--

INSERT INTO `tbl_tour_schedules` (`schedule_id`, `tourid`, `startdate`, `enddate`, `quantity`, `priceadult`, `pricechild`, `created_at`, `updated_at`) VALUES
(10, 321, '2026-05-01', '2026-05-03', 15, 1670000, 980000, '2026-03-22 09:13:01', '2026-03-22 09:13:01'),
(16, 321, '2026-04-01', '2026-04-03', 1, 1500000, 900000, '2026-03-22 09:00:06', '2026-03-22 09:00:06'),
(19, 321, '2026-05-01', '2026-05-03', 6, 1200000, 600000, '2026-03-22 09:10:08', '2026-03-22 09:10:08'),
(20, 321, '2026-03-23', '2026-03-25', 16, 83234, 22324, '2026-03-22 15:51:52', '2026-03-22 15:51:52'),
(21, 25, '2026-03-24', '2026-03-26', 10, 1231212, 101010, '2026-03-22 15:59:25', '2026-03-22 15:59:25'),
(22, 322, '2026-03-25', '2026-03-26', 3, 1000011, 1111, '2026-03-22 16:27:03', '2026-03-22 16:27:03'),
(23, 324, '2026-03-25', '2026-03-26', 17, 111111, 111111, '2026-03-22 17:23:12', '2026-03-22 17:23:12'),
(24, 324, '2026-04-04', '2026-03-26', 20, 11111, 111, '2026-03-22 17:24:33', '2026-03-22 17:24:33'),
(25, 325, '2026-03-28', '2026-03-27', 20, 10000, 1111, '2026-03-25 13:29:47', '2026-03-25 13:29:47'),
(26, 325, '2026-12-09', '2026-12-09', 20, 10000, 2000, '2026-03-25 13:36:14', '2026-03-25 13:36:14'),
(27, 326, '2026-03-28', '2026-03-31', 20, 12000, 1200, '2026-03-25 13:41:14', '2026-03-25 13:41:14'),
(28, 327, '2026-03-28', '2026-03-27', 179, 10000, 1201, '2026-03-25 13:50:30', '2026-03-25 13:50:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `IpAdress` varchar(50) DEFAULT NULL,
  `isActive` tinyint(1) DEFAULT 1,
  `status` tinyint(1) DEFAULT 1,
  `avatar` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `role` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_users`
--

INSERT INTO `tbl_users` (`userid`, `username`, `password`, `email`, `phoneNumber`, `address`, `IpAdress`, `isActive`, `status`, `avatar`, `reset_token`, `provider`, `provider_id`, `role`) VALUES
(3, 'mup3102007@hotmail.com', '$2y$12$Vh1oPVAk9AXUpJ1nkQLK8..Yg7DoZoCyE5h744qKCSG/rOkt5ofta', 'mup3102007@hotmail.com', '0352789556', 'Hcm', '127.0.0.1', 1, 1, '1773147521.png', 'QEJSrzmpQKhH7r7TCy5YHYFNcWCZ7d6Pk3NLCNRe_1773571324', NULL, NULL, 1),
(4, 'mup3102007@hotmail.com', '$2y$12$AFV4cyFC3/xUyNzanxDfee5UtyOsv3iVtcWJP3KBX7WK9/Qo7lN7i', 'mup3102007@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, 'QEJSrzmpQKhH7r7TCy5YHYFNcWCZ7d6Pk3NLCNRe_1773571324', NULL, NULL, 0),
(5, 'mup3102007@hotmail.com', '$2y$12$tVNRihlAw1gLo7mU1N6JWOVnMrdvFhxFNA5wI9tQbKM6UywIAvWLW', 'mup3102007@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, 'QEJSrzmpQKhH7r7TCy5YHYFNcWCZ7d6Pk3NLCNRe_1773571324', NULL, NULL, 0),
(6, 'mup3102007@hotmail.com', '$2y$12$DYPrUg9Sn.Hc6DjACqVrWesGG2nNpIjxUz3JK4d62tl8l/NT.1aB6', 'mup3102007@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, 'QEJSrzmpQKhH7r7TCy5YHYFNcWCZ7d6Pk3NLCNRe_1773571324', NULL, NULL, 0),
(8, 'vuongvanbui20@gmail.com', '$2y$12$4Do1zDhQrt6mG31kB.b6Q.2LfzNRlwlxbot3lpEYAFBQIvQ0g0kHa', 'vuongvanbui20@gmail.com', '', '', '127.0.0.1', 1, 1, NULL, 'aVh89foMwgMAE6vOK4XP1Th68jsHhkojcynFa4Nd_1773055221', NULL, NULL, 0),
(10, 'mup@hotmail.com', '$2y$12$cNA6QjQMZLK4LUInwx9MZutQdm/rPeQy7HcORMCa5FPtAa0UV1GgO', 'mup@hotmail.com', '', '', '127.0.0.1', 1, 0, NULL, NULL, NULL, NULL, 0),
(11, 'mup3102007@hotmail.com', '$2y$12$ojKr9Hp35LENC7Tr7nclnOOiG2Q4pAgVVkJdO.xCIVHS202MJhxq6', 'mup0@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(12, 'mup3102007@hotmail.com', '$2y$12$NbxYqjdLMsuOAmb.gfwXUOqnqqN2IUgnvwSJRvcFZ/l4oYRHp/IB.', 'mup04@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(13, 'PhạmPhạm anh trí', '$2y$12$clayFOMjxFzSdh4H5ucKFeNNd38k9F9tJJmmr0uMtJ3YMnAkntRsC', 'phamphamanhtri@gmail.com', NULL, 'hà nội', '127.0.0.1', 1, 1, '1773122860.jpg', NULL, 'google', '102219874319747167878', 1),
(14, 'Elli Han', '$2y$12$MLrKBuAzpzwqwSzyH5PnqOY4aNSSfKh.10qLqDQtyjyaXKlUnKcYe', '10165145694231833@facebook.com', NULL, NULL, '127.0.0.1', 1, 1, NULL, NULL, 'facebook', '10165145694231833', 1),
(16, 'mup3102007@hotmail.com', '$2y$12$Fp/As7gNYFZGKIAo.ZfoMeffBHzpZDH2PEI1xvt9Bd.reR6YYR2Ha', 'mup123@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(17, 'mup3102007@hotmail.com', '$2y$12$Avb59B5fVnn/7AYWl.0c9.lsH8U/bDZ/nUEkqNCAQ41MsdPNR/Q3S', 'buivanvuong015@gmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(18, 'Ba Hồn', '$2y$12$Dj50KS55WNExqc8MvQ8ntuxNqJpVgN2CrBLPcvm8nNa2wcZMehJu.', 'honba01np@gmail.com', NULL, NULL, '127.0.0.1', 1, 1, NULL, NULL, 'google', '101859029873536403914', 1),
(19, 'Vương Bùi Văn', '$2y$12$UNHmylz0Tj4iqB0rwEHmd.HQUaD5rO0l66Oe99IScSdTzEDVIJUmq', 'vuong@gmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 1),
(20, 'mup31020071@hotmail.com', '$2y$12$FP8EVk63v8cf/PUHZNJSReN0zY74Gfng8PbSxctTumIqCVPUyqmPi', '12345678@123', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(21, 'mup31020071@hotmail.com', '$2y$12$Pua.HHnVI67Nvs7/zH1rbuSR7Jq1PlBrwRrqF5u9ALzKuvbQcDIim', 'mup31020071@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(22, 'an an', '$2y$12$yDsf9bldks5rfI22JF2DZuO4Emiox9Y9fvn0CWF5hkXU54pDNq2XO', 'an@an', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(23, 'an an', '$2y$12$Gg/oiV9BF.gr96gvxsJF1uWLJuQttXt5tzPQkzUH.N0Ck2IPIwvCC', 'anan@hhh', '', '', '127.0.0.1', 1, 1, '1774348589.png', NULL, NULL, NULL, 0),
(24, 'Vuong Van', '$2y$12$hVHpHfhziqqPWs/SoJBBt.KzxoBBs5GCjeoiIZU33jhDlFi54njze', 'mup310200712@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(25, 'Vuong Van', '$2y$12$bFrJSqBL/df6Rs5amlVT8uL9Rzf7r15N2ozc7OC68BUR1Km8IGKAG', 'mup3102007111@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(26, 'Test', '$2y$12$mFNqRHGLyaOiA5EA4xDb4OrtYujYzstZFKJmMiooFt7op92pB/Egm', 'test12@1', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0),
(27, 'Nhat Quang', '$2y$12$np7ZE6dGD2XUcFKaBF2Zd.8mA0/jInGrr0jOynFXEFUYiOOlMVfC6', 'nhatquan12497@hotmail.com', '', '', '127.0.0.1', 1, 1, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blogs_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Chỉ mục cho bảng `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  ADD PRIMARY KEY (`bookingid`);

--
-- Chỉ mục cho bảng `tbl_chat`
--
ALTER TABLE `tbl_chat`
  ADD PRIMARY KEY (`chatid`);

--
-- Chỉ mục cho bảng `tbl_checkout`
--
ALTER TABLE `tbl_checkout`
  ADD PRIMARY KEY (`checkoutid`);

--
-- Chỉ mục cho bảng `tbl_history`
--
ALTER TABLE `tbl_history`
  ADD PRIMARY KEY (`historyid`);

--
-- Chỉ mục cho bảng `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`imageid`);

--
-- Chỉ mục cho bảng `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`invoiceid`);

--
-- Chỉ mục cho bảng `tbl_promotion`
--
ALTER TABLE `tbl_promotion`
  ADD PRIMARY KEY (`promotionid`);

--
-- Chỉ mục cho bảng `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  ADD PRIMARY KEY (`reviewid`);

--
-- Chỉ mục cho bảng `tbl_timeline`
--
ALTER TABLE `tbl_timeline`
  ADD PRIMARY KEY (`timelineID`);

--
-- Chỉ mục cho bảng `tbl_tours`
--
ALTER TABLE `tbl_tours`
  ADD PRIMARY KEY (`tourid`);

--
-- Chỉ mục cho bảng `tbl_tour_pickups`
--
ALTER TABLE `tbl_tour_pickups`
  ADD PRIMARY KEY (`pickup_id`),
  ADD KEY `tour_id` (`tourid`);

--
-- Chỉ mục cho bảng `tbl_tour_schedules`
--
ALTER TABLE `tbl_tour_schedules`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Chỉ mục cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userid`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_bookings`
--
ALTER TABLE `tbl_bookings`
  MODIFY `bookingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT cho bảng `tbl_chat`
--
ALTER TABLE `tbl_chat`
  MODIFY `chatid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;

--
-- AUTO_INCREMENT cho bảng `tbl_checkout`
--
ALTER TABLE `tbl_checkout`
  MODIFY `checkoutid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tbl_history`
--
ALTER TABLE `tbl_history`
  MODIFY `historyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT cho bảng `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `imageid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT cho bảng `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `invoiceid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tbl_promotion`
--
ALTER TABLE `tbl_promotion`
  MODIFY `promotionid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tbl_reviews`
--
ALTER TABLE `tbl_reviews`
  MODIFY `reviewid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `tbl_timeline`
--
ALTER TABLE `tbl_timeline`
  MODIFY `timelineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `tbl_tours`
--
ALTER TABLE `tbl_tours`
  MODIFY `tourid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=328;

--
-- AUTO_INCREMENT cho bảng `tbl_tour_pickups`
--
ALTER TABLE `tbl_tour_pickups`
  MODIFY `pickup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `tbl_tour_schedules`
--
ALTER TABLE `tbl_tour_schedules`
  MODIFY `schedule_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_tour_pickups`
--
ALTER TABLE `tbl_tour_pickups`
  ADD CONSTRAINT `tbl_tour_pickups_ibfk_1` FOREIGN KEY (`tourid`) REFERENCES `tbl_tours` (`tourid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
