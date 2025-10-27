-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 30, 2024 at 02:04 PM
-- Server version: 10.5.19-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u526009527_euromarketn`
--

-- --------------------------------------------------------

--
-- Table structure for table `addon_settings`
--

CREATE TABLE `addon_settings` (
  `id` char(36) NOT NULL,
  `key_name` varchar(191) DEFAULT NULL,
  `live_values` longtext DEFAULT NULL,
  `test_values` longtext DEFAULT NULL,
  `settings_type` varchar(255) DEFAULT NULL,
  `mode` varchar(20) NOT NULL DEFAULT 'live',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `additional_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addon_settings`
--

INSERT INTO `addon_settings` (`id`, `key_name`, `live_values`, `test_values`, `settings_type`, `mode`, `is_active`, `created_at`, `updated_at`, `additional_data`) VALUES
('070c6bbd-d777-11ed-96f4-0c7a158e4469', 'twilio', '{\"gateway\":\"twilio\",\"mode\":\"live\",\"status\":\"0\",\"sid\":\"data\",\"messaging_service_sid\":\"data\",\"token\":\"data\",\"from\":\"data\",\"otp_template\":\"data\"}', '{\"gateway\":\"twilio\",\"mode\":\"live\",\"status\":\"0\",\"sid\":\"data\",\"messaging_service_sid\":\"data\",\"token\":\"data\",\"from\":\"data\",\"otp_template\":\"data\"}', 'sms_config', 'live', 0, NULL, '2023-08-12 07:01:29', NULL),
('070c766c-d777-11ed-96f4-0c7a158e4469', '2factor', '{\"gateway\":\"2factor\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":\"data\"}', '{\"gateway\":\"2factor\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":\"data\"}', 'sms_config', 'live', 0, NULL, '2023-08-12 07:01:36', NULL),
('0d8a9308-d6a5-11ed-962c-0c7a158e4469', 'mercadopago', '{\"gateway\":\"mercadopago\",\"mode\":\"live\",\"status\":0,\"access_token\":\"\",\"public_key\":\"\"}', '{\"gateway\":\"mercadopago\",\"mode\":\"live\",\"status\":0,\"access_token\":\"\",\"public_key\":\"\"}', 'payment_config', 'test', 0, NULL, '2023-08-27 11:57:11', '{\"gateway_title\":\"Mercadopago\",\"gateway_image\":null}'),
('0d8a9e49-d6a5-11ed-962c-0c7a158e4469', 'liqpay', '{\"gateway\":\"liqpay\",\"mode\":\"live\",\"status\":0,\"private_key\":\"\",\"public_key\":\"\"}', '{\"gateway\":\"liqpay\",\"mode\":\"live\",\"status\":0,\"private_key\":\"\",\"public_key\":\"\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:32:31', '{\"gateway_title\":\"Liqpay\",\"gateway_image\":null}'),
('101befdf-d44b-11ed-8564-0c7a158e4469', 'paypal', '{\"gateway\":\"paypal\",\"mode\":\"live\",\"status\":\"0\",\"client_id\":\"\",\"client_secret\":\"\"}', '{\"gateway\":\"paypal\",\"mode\":\"live\",\"status\":\"0\",\"client_id\":\"\",\"client_secret\":\"\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 03:41:32', '{\"gateway_title\":\"Paypal\",\"gateway_image\":null}'),
('133d9647-cabb-11ed-8fec-0c7a158e4469', 'hyper_pay', '{\"gateway\":\"hyper_pay\",\"mode\":\"test\",\"status\":\"0\",\"entity_id\":\"data\",\"access_code\":\"data\"}', '{\"gateway\":\"hyper_pay\",\"mode\":\"test\",\"status\":\"0\",\"entity_id\":\"data\",\"access_code\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:32:42', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('1821029f-d776-11ed-96f4-0c7a158e4469', 'msg91', '{\"gateway\":\"msg91\",\"mode\":\"live\",\"status\":\"0\",\"template_id\":\"data\",\"auth_key\":\"data\"}', '{\"gateway\":\"msg91\",\"mode\":\"live\",\"status\":\"0\",\"template_id\":\"data\",\"auth_key\":\"data\"}', 'sms_config', 'live', 0, NULL, '2023-08-12 07:01:48', NULL),
('18210f2b-d776-11ed-96f4-0c7a158e4469', 'nexmo', '{\"gateway\":\"nexmo\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":\"\",\"api_secret\":\"\",\"token\":\"\",\"from\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"nexmo\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":\"\",\"api_secret\":\"\",\"token\":\"\",\"from\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, '2023-04-10 02:14:44', NULL),
('18fbb21f-d6ad-11ed-962c-0c7a158e4469', 'foloosi', '{\"gateway\":\"foloosi\",\"mode\":\"test\",\"status\":\"0\",\"merchant_key\":\"data\"}', '{\"gateway\":\"foloosi\",\"mode\":\"test\",\"status\":\"0\",\"merchant_key\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:34:33', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('2767d142-d6a1-11ed-962c-0c7a158e4469', 'paytm', '{\"gateway\":\"paytm\",\"mode\":\"live\",\"status\":0,\"merchant_key\":\"\",\"merchant_id\":\"\",\"merchant_website_link\":\"\"}', '{\"gateway\":\"paytm\",\"mode\":\"live\",\"status\":0,\"merchant_key\":\"\",\"merchant_id\":\"\",\"merchant_website_link\":\"\"}', 'payment_config', 'test', 0, NULL, '2023-08-22 06:30:55', '{\"gateway_title\":\"Paytm\",\"gateway_image\":null}'),
('3201d2e6-c937-11ed-a424-0c7a158e4469', 'amazon_pay', '{\"gateway\":\"amazon_pay\",\"mode\":\"test\",\"status\":\"0\",\"pass_phrase\":\"data\",\"access_code\":\"data\",\"merchant_identifier\":\"data\"}', '{\"gateway\":\"amazon_pay\",\"mode\":\"test\",\"status\":\"0\",\"pass_phrase\":\"data\",\"access_code\":\"data\",\"merchant_identifier\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:36:07', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('4593b25c-d6a1-11ed-962c-0c7a158e4469', 'paytabs', '{\"gateway\":\"paytabs\",\"mode\":\"live\",\"status\":0,\"profile_id\":\"\",\"server_key\":\"\",\"base_url\":\"https:\\/\\/secure-egypt.paytabs.com\\/\"}', '{\"gateway\":\"paytabs\",\"mode\":\"live\",\"status\":0,\"profile_id\":\"\",\"server_key\":\"\",\"base_url\":\"https:\\/\\/secure-egypt.paytabs.com\\/\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:34:51', '{\"gateway_title\":\"Paytabs\",\"gateway_image\":null}'),
('4e9b8dfb-e7d1-11ed-a559-0c7a158e4469', 'bkash', '{\"gateway\":\"bkash\",\"mode\":\"live\",\"status\":\"0\",\"app_key\":\"\",\"app_secret\":\"\",\"username\":\"\",\"password\":\"\"}', '{\"gateway\":\"bkash\",\"mode\":\"live\",\"status\":\"0\",\"app_key\":\"\",\"app_secret\":\"\",\"username\":\"\",\"password\":\"\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:39:42', '{\"gateway_title\":\"Bkash\",\"gateway_image\":null}'),
('544a24a4-c872-11ed-ac7a-0c7a158e4469', 'fatoorah', '{\"gateway\":\"fatoorah\",\"mode\":\"test\",\"status\":\"0\",\"api_key\":\"data\"}', '{\"gateway\":\"fatoorah\",\"mode\":\"test\",\"status\":\"0\",\"api_key\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:36:24', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('58c1bc8a-d6ac-11ed-962c-0c7a158e4469', 'ccavenue', '{\"gateway\":\"ccavenue\",\"mode\":\"test\",\"status\":\"0\",\"merchant_id\":\"data\",\"working_key\":\"data\",\"access_code\":\"data\"}', '{\"gateway\":\"ccavenue\",\"mode\":\"test\",\"status\":\"0\",\"merchant_id\":\"data\",\"working_key\":\"data\",\"access_code\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 03:42:38', '{\"gateway_title\":null,\"gateway_image\":\"2023-04-13-643783f01d386.png\"}'),
('5e2d2ef9-d6ab-11ed-962c-0c7a158e4469', 'thawani', '{\"gateway\":\"thawani\",\"mode\":\"test\",\"status\":\"0\",\"public_key\":\"data\",\"private_key\":\"data\"}', '{\"gateway\":\"thawani\",\"mode\":\"test\",\"status\":\"0\",\"public_key\":\"data\",\"private_key\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:50:40', '{\"gateway_title\":null,\"gateway_image\":\"2023-04-13-64378f9856f29.png\"}'),
('60cc83cc-d5b9-11ed-b56f-0c7a158e4469', 'sixcash', '{\"gateway\":\"sixcash\",\"mode\":\"test\",\"status\":\"0\",\"public_key\":\"data\",\"secret_key\":\"data\",\"merchant_number\":\"data\",\"base_url\":\"data\"}', '{\"gateway\":\"sixcash\",\"mode\":\"test\",\"status\":\"0\",\"public_key\":\"data\",\"secret_key\":\"data\",\"merchant_number\":\"data\",\"base_url\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:16:17', '{\"gateway_title\":null,\"gateway_image\":\"2023-04-12-6436774e77ff9.png\"}'),
('68579846-d8e8-11ed-8249-0c7a158e4469', 'alphanet_sms', '{\"gateway\":\"alphanet_sms\",\"mode\":\"live\",\"status\":0,\"api_key\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"alphanet_sms\",\"mode\":\"live\",\"status\":0,\"api_key\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, NULL, NULL),
('6857a2e8-d8e8-11ed-8249-0c7a158e4469', 'sms_to', '{\"gateway\":\"sms_to\",\"mode\":\"live\",\"status\":0,\"api_key\":\"\",\"sender_id\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"sms_to\",\"mode\":\"live\",\"status\":0,\"api_key\":\"\",\"sender_id\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, NULL, NULL),
('74c30c00-d6a6-11ed-962c-0c7a158e4469', 'hubtel', '{\"gateway\":\"hubtel\",\"mode\":\"test\",\"status\":\"0\",\"account_number\":\"data\",\"api_id\":\"data\",\"api_key\":\"data\"}', '{\"gateway\":\"hubtel\",\"mode\":\"test\",\"status\":\"0\",\"account_number\":\"data\",\"api_id\":\"data\",\"api_key\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:37:43', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('74e46b0a-d6aa-11ed-962c-0c7a158e4469', 'tap', '{\"gateway\":\"tap\",\"mode\":\"test\",\"status\":\"0\",\"secret_key\":\"data\"}', '{\"gateway\":\"tap\",\"mode\":\"test\",\"status\":\"0\",\"secret_key\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:50:09', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('761ca96c-d1eb-11ed-87ca-0c7a158e4469', 'swish', '{\"gateway\":\"swish\",\"mode\":\"test\",\"status\":\"0\",\"number\":\"data\"}', '{\"gateway\":\"swish\",\"mode\":\"test\",\"status\":\"0\",\"number\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:17:02', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('7b1c3c5f-d2bd-11ed-b485-0c7a158e4469', 'payfast', '{\"gateway\":\"payfast\",\"mode\":\"test\",\"status\":\"0\",\"merchant_id\":\"data\",\"secured_key\":\"data\"}', '{\"gateway\":\"payfast\",\"mode\":\"test\",\"status\":\"0\",\"merchant_id\":\"data\",\"secured_key\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:18:13', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('8592417b-d1d1-11ed-a984-0c7a158e4469', 'esewa', '{\"gateway\":\"esewa\",\"mode\":\"test\",\"status\":\"0\",\"merchantCode\":\"data\"}', '{\"gateway\":\"esewa\",\"mode\":\"test\",\"status\":\"0\",\"merchantCode\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:17:38', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('9162a1dc-cdf1-11ed-affe-0c7a158e4469', 'viva_wallet', '{\"gateway\":\"viva_wallet\",\"mode\":\"test\",\"status\":\"0\",\"client_id\": \"\",\"client_secret\": \"\", \"source_code\":\"\"}\n', '{\"gateway\":\"viva_wallet\",\"mode\":\"test\",\"status\":\"0\",\"client_id\": \"\",\"client_secret\": \"\", \"source_code\":\"\"}\n', 'payment_config', 'test', 0, NULL, NULL, NULL),
('998ccc62-d6a0-11ed-962c-0c7a158e4469', 'stripe', '{\"gateway\":\"stripe\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":null,\"published_key\":null}', '{\"gateway\":\"stripe\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":null,\"published_key\":null}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:18:55', '{\"gateway_title\":\"Stripe\",\"gateway_image\":null}'),
('a3313755-c95d-11ed-b1db-0c7a158e4469', 'iyzi_pay', '{\"gateway\":\"iyzi_pay\",\"mode\":\"test\",\"status\":\"0\",\"api_key\":\"data\",\"secret_key\":\"data\",\"base_url\":\"data\"}', '{\"gateway\":\"iyzi_pay\",\"mode\":\"test\",\"status\":\"0\",\"api_key\":\"data\",\"secret_key\":\"data\",\"base_url\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:20:02', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('a76c8993-d299-11ed-b485-0c7a158e4469', 'momo', '{\"gateway\":\"momo\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":\"data\",\"api_user\":\"data\",\"subscription_key\":\"data\"}', '{\"gateway\":\"momo\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":\"data\",\"api_user\":\"data\",\"subscription_key\":\"data\"}', 'payment_config', 'live', 0, NULL, '2023-08-30 04:19:28', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('a8608119-cc76-11ed-9bca-0c7a158e4469', 'moncash', '{\"gateway\":\"moncash\",\"mode\":\"test\",\"status\":\"0\",\"client_id\":\"data\",\"secret_key\":\"data\"}', '{\"gateway\":\"moncash\",\"mode\":\"test\",\"status\":\"0\",\"client_id\":\"data\",\"secret_key\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:47:34', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('ad5af1c1-d6a2-11ed-962c-0c7a158e4469', 'razor_pay', '{\"gateway\":\"razor_pay\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":null,\"api_secret\":null}', '{\"gateway\":\"razor_pay\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":null,\"api_secret\":null}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:47:00', '{\"gateway_title\":\"Razor pay\",\"gateway_image\":null}'),
('ad5b02a0-d6a2-11ed-962c-0c7a158e4469', 'senang_pay', '{\"gateway\":\"senang_pay\",\"mode\":\"live\",\"status\":\"0\",\"callback_url\":null,\"secret_key\":null,\"merchant_id\":null}', '{\"gateway\":\"senang_pay\",\"mode\":\"live\",\"status\":\"0\",\"callback_url\":null,\"secret_key\":null,\"merchant_id\":null}', 'payment_config', 'test', 0, NULL, '2023-08-27 09:58:57', '{\"gateway_title\":\"Senang pay\",\"gateway_image\":null}'),
('b6c333f6-d8e9-11ed-8249-0c7a158e4469', 'akandit_sms', '{\"gateway\":\"akandit_sms\",\"mode\":\"live\",\"status\":0,\"username\":\"\",\"password\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"akandit_sms\",\"mode\":\"live\",\"status\":0,\"username\":\"\",\"password\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, NULL, NULL),
('b6c33c87-d8e9-11ed-8249-0c7a158e4469', 'global_sms', '{\"gateway\":\"global_sms\",\"mode\":\"live\",\"status\":0,\"user_name\":\"\",\"password\":\"\",\"from\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"global_sms\",\"mode\":\"live\",\"status\":0,\"user_name\":\"\",\"password\":\"\",\"from\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, NULL, NULL),
('b8992bd4-d6a0-11ed-962c-0c7a158e4469', 'paymob_accept', '{\"gateway\":\"paymob_accept\",\"mode\":\"live\",\"status\":\"0\",\"callback_url\":null,\"api_key\":\"\",\"iframe_id\":\"\",\"integration_id\":\"\",\"hmac\":\"\"}', '{\"gateway\":\"paymob_accept\",\"mode\":\"live\",\"status\":\"0\",\"callback_url\":null,\"api_key\":\"\",\"iframe_id\":\"\",\"integration_id\":\"\",\"hmac\":\"\"}', 'payment_config', 'test', 0, NULL, NULL, '{\"gateway_title\":\"Paymob accept\",\"gateway_image\":null}'),
('c41c0dcd-d119-11ed-9f67-0c7a158e4469', 'maxicash', '{\"gateway\":\"maxicash\",\"mode\":\"test\",\"status\":\"0\",\"merchantId\":\"data\",\"merchantPassword\":\"data\"}', '{\"gateway\":\"maxicash\",\"mode\":\"test\",\"status\":\"0\",\"merchantId\":\"data\",\"merchantPassword\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:49:15', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('c9249d17-cd60-11ed-b879-0c7a158e4469', 'pvit', '{\"gateway\":\"pvit\",\"mode\":\"test\",\"status\":\"0\",\"mc_tel_merchant\": \"\",\"access_token\": \"\", \"mc_merchant_code\": \"\"}', '{\"gateway\":\"pvit\",\"mode\":\"test\",\"status\":\"0\",\"mc_tel_merchant\": \"\",\"access_token\": \"\", \"mc_merchant_code\": \"\"}', 'payment_config', 'test', 0, NULL, NULL, NULL),
('cb0081ce-d775-11ed-96f4-0c7a158e4469', 'releans', '{\"gateway\":\"releans\",\"mode\":\"live\",\"status\":0,\"api_key\":\"\",\"from\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"releans\",\"mode\":\"live\",\"status\":0,\"api_key\":\"\",\"from\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, '2023-04-10 02:14:44', NULL),
('d4f3f5f1-d6a0-11ed-962c-0c7a158e4469', 'flutterwave', '{\"gateway\":\"flutterwave\",\"mode\":\"live\",\"status\":0,\"secret_key\":\"\",\"public_key\":\"\",\"hash\":\"\"}', '{\"gateway\":\"flutterwave\",\"mode\":\"live\",\"status\":0,\"secret_key\":\"\",\"public_key\":\"\",\"hash\":\"\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:41:03', '{\"gateway_title\":\"Flutterwave\",\"gateway_image\":null}'),
('d822f1a5-c864-11ed-ac7a-0c7a158e4469', 'paystack', '{\"gateway\":\"paystack\",\"mode\":\"live\",\"status\":\"0\",\"callback_url\":\"https:\\/\\/api.paystack.co\",\"public_key\":null,\"secret_key\":null,\"merchant_email\":null}', '{\"gateway\":\"paystack\",\"mode\":\"live\",\"status\":\"0\",\"callback_url\":\"https:\\/\\/api.paystack.co\",\"public_key\":null,\"secret_key\":null,\"merchant_email\":null}', 'payment_config', 'test', 0, NULL, '2023-08-30 04:20:45', '{\"gateway_title\":\"Paystack\",\"gateway_image\":null}'),
('daec8d59-c893-11ed-ac7a-0c7a158e4469', 'xendit', '{\"gateway\":\"xendit\",\"mode\":\"test\",\"status\":\"0\",\"api_key\":\"data\"}', '{\"gateway\":\"xendit\",\"mode\":\"test\",\"status\":\"0\",\"api_key\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:35:46', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('dc0f5fc9-d6a5-11ed-962c-0c7a158e4469', 'worldpay', '{\"gateway\":\"worldpay\",\"mode\":\"test\",\"status\":\"0\",\"OrgUnitId\":\"data\",\"jwt_issuer\":\"data\",\"mac\":\"data\",\"merchantCode\":\"data\",\"xml_password\":\"data\"}', '{\"gateway\":\"worldpay\",\"mode\":\"test\",\"status\":\"0\",\"OrgUnitId\":\"data\",\"jwt_issuer\":\"data\",\"mac\":\"data\",\"merchantCode\":\"data\",\"xml_password\":\"data\"}', 'payment_config', 'test', 0, NULL, '2023-08-12 06:35:26', '{\"gateway_title\":null,\"gateway_image\":\"\"}'),
('e0450278-d8eb-11ed-8249-0c7a158e4469', 'signal_wire', '{\"gateway\":\"signal_wire\",\"mode\":\"live\",\"status\":0,\"project_id\":\"\",\"token\":\"\",\"space_url\":\"\",\"from\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"signal_wire\",\"mode\":\"live\",\"status\":0,\"project_id\":\"\",\"token\":\"\",\"space_url\":\"\",\"from\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, NULL, NULL),
('e0450b40-d8eb-11ed-8249-0c7a158e4469', 'paradox', '{\"gateway\":\"paradox\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":\"\",\"sender_id\":\"\"}', '{\"gateway\":\"paradox\",\"mode\":\"live\",\"status\":\"0\",\"api_key\":\"\",\"sender_id\":\"\"}', 'sms_config', 'live', 0, NULL, '2023-09-10 01:14:01', NULL),
('ea346efe-cdda-11ed-affe-0c7a158e4469', 'ssl_commerz', '{\"gateway\":\"ssl_commerz\",\"mode\":\"live\",\"status\":\"0\",\"store_id\":\"\",\"store_password\":\"\"}', '{\"gateway\":\"ssl_commerz\",\"mode\":\"live\",\"status\":\"0\",\"store_id\":\"\",\"store_password\":\"\"}', 'payment_config', 'test', 0, NULL, '2023-08-30 03:43:49', '{\"gateway_title\":\"Ssl commerz\",\"gateway_image\":null}'),
('eed88336-d8ec-11ed-8249-0c7a158e4469', 'hubtel', '{\"gateway\":\"hubtel\",\"mode\":\"live\",\"status\":0,\"sender_id\":\"\",\"client_id\":\"\",\"client_secret\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"hubtel\",\"mode\":\"live\",\"status\":0,\"sender_id\":\"\",\"client_id\":\"\",\"client_secret\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, NULL, NULL),
('f149c546-d8ea-11ed-8249-0c7a158e4469', 'viatech', '{\"gateway\":\"viatech\",\"mode\":\"live\",\"status\":0,\"api_url\":\"\",\"api_key\":\"\",\"sender_id\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"viatech\",\"mode\":\"live\",\"status\":0,\"api_url\":\"\",\"api_key\":\"\",\"sender_id\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, NULL, NULL),
('f149cd9c-d8ea-11ed-8249-0c7a158e4469', '019_sms', '{\"gateway\":\"019_sms\",\"mode\":\"live\",\"status\":0,\"password\":\"\",\"username\":\"\",\"username_for_token\":\"\",\"sender\":\"\",\"otp_template\":\"\"}', '{\"gateway\":\"019_sms\",\"mode\":\"live\",\"status\":0,\"password\":\"\",\"username\":\"\",\"username_for_token\":\"\",\"sender\":\"\",\"otp_template\":\"\"}', 'sms_config', 'live', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `add_fund_bonus_categories`
--

CREATE TABLE `add_fund_bonus_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `bonus_type` varchar(50) NOT NULL,
  `bonus_amount` double(14,2) NOT NULL DEFAULT 0.00,
  `min_add_money_amount` double(14,2) NOT NULL DEFAULT 0.00,
  `max_bonus_amount` double(14,2) NOT NULL DEFAULT 0.00,
  `start_date_time` datetime DEFAULT NULL,
  `end_date_time` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `admin_role_id` bigint(20) NOT NULL DEFAULT 2,
  `image` varchar(30) NOT NULL DEFAULT 'def.png',
  `identify_image` text DEFAULT NULL,
  `identify_type` varchar(255) DEFAULT NULL,
  `identify_number` int(11) DEFAULT NULL,
  `email` varchar(80) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(80) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `phone`, `admin_role_id`, `image`, `identify_image`, `identify_type`, `identify_number`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Admin', '+31 6 14370766', 1, 'def.png', NULL, NULL, NULL, 'abdulkadertarrabrefaee@gmail.com', NULL, '$2y$10$a62vaNUdeWM3RhXgtJEgc./ll1dgnBnEfwBwsSBGu1qXuCf6DZ3GG', 'fV47RyqldmjxPOzOsIsfnZ6R7yoHecupRin1SXtglBgDRBlQddT1Md7hggRx', '2023-10-25 18:11:02', '2023-10-25 18:11:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `module_access` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `module_access`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Master Admin', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_wallets`
--

CREATE TABLE `admin_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `inhouse_earning` double NOT NULL DEFAULT 0,
  `withdrawn` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `commission_earned` double(8,2) NOT NULL DEFAULT 0.00,
  `delivery_charge_earned` double(8,2) NOT NULL DEFAULT 0.00,
  `pending_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `total_tax_collected` double(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_wallets`
--

INSERT INTO `admin_wallets` (`id`, `admin_id`, `inhouse_earning`, `withdrawn`, `created_at`, `updated_at`, `commission_earned`, `delivery_charge_earned`, `pending_amount`, `total_tax_collected`) VALUES
(1, 1, 618.2721, 0, NULL, '2024-01-25 12:13:42', 74.00, 20.00, 0.00, 0.60),
(2, 1, 0, 0, '2023-10-25 18:11:02', '2023-10-25 18:11:02', 0.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `admin_wallet_histories`
--

CREATE TABLE `admin_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `payment` varchar(191) NOT NULL DEFAULT 'received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Size', '2023-11-03 23:28:00', '2023-11-03 23:28:00'),
(2, 'Material', '2023-11-03 23:30:55', '2023-11-03 23:30:55'),
(3, 'Volume', '2023-11-03 23:31:20', '2023-11-03 23:31:20'),
(4, 'Skin Type', '2023-11-03 23:31:36', '2023-11-03 23:31:36'),
(5, 'Shade', '2023-11-03 23:31:49', '2023-11-03 23:31:49'),
(6, 'Age Range', '2023-11-03 23:32:08', '2023-11-03 23:50:17'),
(7, 'Wattage', '2023-11-03 23:32:39', '2023-11-03 23:32:39'),
(8, 'Engine Size', '2023-11-03 23:33:00', '2023-11-03 23:33:00'),
(9, 'Year', '2023-11-03 23:33:53', '2023-11-03 23:33:53'),
(10, 'Gemstone', '2023-11-03 23:34:22', '2023-11-03 23:34:22'),
(11, 'Storage Capacity', '2023-11-03 23:34:43', '2023-11-03 23:34:43'),
(12, 'RAM', '2023-11-03 23:34:49', '2023-11-03 23:34:49'),
(13, 'Processor', '2023-11-03 23:35:08', '2023-11-03 23:35:08'),
(14, 'Length', '2023-11-03 23:35:33', '2023-11-03 23:35:33'),
(15, 'Type', '2023-11-03 23:50:47', '2023-11-03 23:50:47'),
(16, 'Height', '2023-11-04 00:03:20', '2023-11-04 00:03:20'),
(17, 'Width', '2023-11-04 00:03:44', '2023-11-04 00:03:44'),
(18, 'Human Hair Type', '2023-11-04 00:05:41', '2023-11-04 00:05:41'),
(19, 'Base Material', '2023-11-04 00:06:01', '2023-11-04 00:06:01'),
(20, 'Color of Lace', '2023-11-04 00:06:15', '2023-11-04 00:06:15'),
(21, 'Frame Color', '2023-11-04 00:07:06', '2023-11-04 00:07:06'),
(22, 'Lenses Color', '2023-11-04 00:07:21', '2023-11-04 00:07:21'),
(23, 'Power (W)', '2023-11-04 00:08:58', '2023-11-04 00:08:58'),
(24, 'Voltage (V)', '2023-11-04 00:09:14', '2023-11-04 00:09:14'),
(25, 'Liter', '2023-11-04 00:11:48', '2023-11-04 00:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `banner_type` varchar(255) NOT NULL,
  `theme` varchar(255) NOT NULL DEFAULT 'default',
  `published` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `resource_type` varchar(191) DEFAULT NULL,
  `resource_id` bigint(20) DEFAULT NULL,
  `title` varchar(191) DEFAULT NULL,
  `sub_title` varchar(191) DEFAULT NULL,
  `button_text` varchar(191) DEFAULT NULL,
  `background_color` varchar(191) DEFAULT NULL,
  `lang` varchar(200) DEFAULT NULL,
  `for_mobile` int(20) NOT NULL,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `photo`, `banner_type`, `theme`, `published`, `created_at`, `updated_at`, `url`, `resource_type`, `resource_id`, `title`, `sub_title`, `button_text`, `background_color`, `lang`, `for_mobile`, `priority`) VALUES
(1, '2023-12-22-6584b125bfaa2.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-09 17:25:48', '2023-12-22 15:54:27', 'https://build.euromarketn.com/products?id=6&data_from=category&page=1', 'category', 6, NULL, NULL, NULL, NULL, 'en', 2, 28),
(2, '2023-11-09-654cebff105b5.png', 'Main Section Banner', 'theme_aster', 1, '2023-11-09 17:26:07', '2023-12-22 16:00:44', 'https://build.euromarketn.com/products?id=10&data_from=category&page=1', 'category', 10, NULL, NULL, NULL, NULL, 'en', 2, 21),
(4, '2023-11-22-655dfc2082c3a.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-16 00:57:16', '2023-12-22 16:44:36', 'https://build.euromarketn.com/products?id=2&data_from=category&page=1', 'category', 2, NULL, NULL, NULL, NULL, 'en', 2, 30),
(5, '2023-11-23-655f727bb97ef.webp', 'Main Banner', 'theme_aster', 1, '2023-11-22 13:55:01', '2023-12-08 17:40:14', 'https://build.euromarketn.com/', 'product', 111, NULL, NULL, NULL, NULL, 'en', 2, NULL),
(6, '2023-11-23-655f7212c0492.webp', 'Main Banner', 'theme_aster', 1, '2023-11-22 13:56:17', '2023-12-08 17:40:16', 'https://build.euromarketn.com/', 'shop', 1, NULL, NULL, NULL, NULL, 'en', 2, NULL),
(7, '2023-11-23-655f726912e69.webp', 'Main Banner', 'theme_aster', 1, '2023-11-22 13:56:36', '2023-12-08 17:40:18', 'https://build.euromarketn.com/', 'brand', 1, NULL, NULL, NULL, NULL, 'en', 2, NULL),
(8, '2024-01-12-65a057deb639c.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-22 15:01:16', '2024-01-12 00:04:30', 'https://build.euromarketn.com/products?id=4&data_from=category&page=1', 'category', 4, NULL, NULL, NULL, NULL, 'en', 2, 27),
(9, '2023-11-22-655dedde12bc1.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-22 15:02:38', '2023-12-22 15:58:31', 'https://build.euromarketn.com/products?id=5&data_from=category&page=1', 'category', 5, NULL, NULL, NULL, NULL, 'en', 2, 23),
(10, '2023-11-22-655dee23d4d9f.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-22 15:03:47', '2023-12-22 16:05:39', 'https://build.euromarketn.com/products?id=7&data_from=category&page=1', 'category', 6, NULL, NULL, NULL, NULL, 'en', 2, 20),
(11, '2023-11-22-655dee6748e5b.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-22 15:04:55', '2023-12-22 15:54:18', 'https://build.euromarketn.com/products?id=2&data_from=category&page=1', 'category', 3, NULL, NULL, NULL, NULL, 'en', 2, 29),
(12, '2023-11-22-655dfc4f817ea.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-22 15:05:41', '2023-12-22 15:57:32', 'https://build.euromarketn.com/products?id=8&data_from=category&page=1', 'category', 8, NULL, NULL, NULL, NULL, 'en', 2, 25),
(13, '2023-11-22-655def0891951.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-22 15:07:36', '2023-12-22 16:05:55', 'https://build.euromarketn.com/products?id=11&data_from=category&page=1', 'category', 11, NULL, NULL, NULL, NULL, 'en', 2, 19),
(14, '2023-11-22-655def2e0aba7.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-22 15:08:14', '2023-12-22 16:06:13', 'https://build.euromarketn.com/products?id=124&data_from=category&page=1', 'category', 124, NULL, NULL, NULL, NULL, 'en', 2, 18),
(15, '2024-01-12-65a05f2ec9347.webp', 'Main Section Banner', 'theme_aster', 1, '2023-11-22 15:08:53', '2024-01-12 00:35:42', 'https://build.euromarketn.com/products?id=271&data_from=category&page=1', 'category', 271, NULL, NULL, NULL, NULL, 'en', 2, 17),
(17, '2023-11-23-655f5351ca232.webp', 'Main Section Banner', 'theme_aster', 0, '2023-11-23 16:27:45', '2023-12-21 23:50:56', 'https://build.euromarketn.com/product/lige-2023-smart-watch-for-men-women-gift-full-touch-screen-sports-fitness-watches-bluetooth-calls-digital-smartwatch-wri', 'product', 149, NULL, NULL, NULL, NULL, 'en', 2, NULL),
(18, '2023-11-23-655f54b04db25.webp', 'Main Section Banner', 'theme_aster', 0, '2023-11-23 16:33:36', '2023-12-21 23:50:54', 'https://build.euromarketn.com/products?id=64&data_from=category&page=1', 'product', 113, NULL, NULL, NULL, NULL, 'en', 2, NULL),
(19, '2023-11-23-655f5543d279a.webp', 'Main Section Banner', 'theme_aster', 0, '2023-11-23 16:36:03', '2023-12-21 23:50:52', 'https://build.euromarketn.com/product/square-sunglasses-woman-brand-designer-fashion-rimless-gradient-sun-glasses-shades-cutting-lens-ladies-frameless-eyeglas', 'category', 2, NULL, NULL, NULL, NULL, 'en', 2, NULL),
(23, '2023-12-08-657331f5ed0d0.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:10:45', '2023-12-22 16:12:44', 'https://build.euromarketn.com/', 'product', 111, NULL, NULL, NULL, NULL, 'nl', 2, 28),
(24, '2023-12-08-65733230b231c.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:11:44', '2023-12-22 16:23:17', 'https://build.euromarketn.com/products?id=10&data_from=category&page=1', 'category', 10, NULL, NULL, NULL, NULL, 'nl', 2, 22),
(26, '2023-12-08-6573345eec0e1.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:21:02', '2023-12-22 16:44:43', 'https://build.euromarketn.com/products?id=2&data_from=category&page=1', 'category', 2, NULL, NULL, NULL, NULL, 'nl', 2, 30),
(27, '2024-01-12-65a057f38271e.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:21:40', '2024-01-12 00:04:51', 'https://build.euromarketn.com/products?id=4&data_from=category&page=1', 'category', 4, NULL, NULL, NULL, NULL, 'nl', 2, 27),
(28, '2023-12-08-657334c02f018.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:22:40', '2023-12-22 16:17:41', 'https://build.euromarketn.com/products?id=5&data_from=category&page=1', 'category', 5, NULL, NULL, NULL, NULL, 'nl', 2, 23),
(29, '2023-12-08-657334e308a67.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:23:15', '2023-12-22 16:24:06', 'https://build.euromarketn.com/products?id=7&data_from=category&page=1', 'category', 7, NULL, NULL, NULL, NULL, 'nl', 2, 20),
(30, '2023-12-08-657335b98a3e5.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:26:49', '2023-12-22 16:12:40', 'https://build.euromarketn.com/products?id=2&data_from=category&page=1', 'category', 3, NULL, NULL, NULL, NULL, 'nl', 2, 29),
(31, '2023-12-08-657335d789f3e.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:27:19', '2023-12-22 16:16:56', 'https://build.euromarketn.com/products?id=8&data_from=category&page=1', 'category', 8, NULL, NULL, NULL, NULL, 'nl', 2, 25),
(32, '2023-12-08-65733600574ea.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:28:00', '2023-12-22 16:25:24', 'https://build.euromarketn.com/products?id=11&data_from=category&page=1', 'category', 11, NULL, NULL, NULL, NULL, 'nl', 2, 19),
(34, '2023-12-08-65733628cd45a.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-08 18:28:40', '2023-12-22 16:25:58', 'https://build.euromarketn.com/products?id=124&data_from=category&page=1', 'category', 124, NULL, NULL, NULL, NULL, 'nl', 2, 18),
(36, '2023-12-13-6579baf26e46b.webp', 'Main Banner', 'theme_aster', 1, '2023-12-13 17:08:50', '2023-12-20 22:50:03', 'https://build.euromarketn.com/', 'product', 111, NULL, NULL, NULL, NULL, 'nl', 2, NULL),
(37, '2023-12-13-6579bb1849076.webp', 'Main Banner', 'theme_aster', 1, '2023-12-13 17:09:28', '2023-12-20 22:50:02', 'https://build.euromarketn.com/', 'product', 111, NULL, NULL, NULL, NULL, 'nl', 2, NULL),
(38, '2023-12-13-6579bbe36416c.webp', 'Main Banner', 'theme_aster', 1, '2023-12-13 17:12:51', '2023-12-20 22:50:00', 'https://build.euromarketn.com/', 'product', 111, NULL, NULL, NULL, NULL, 'nl', 2, NULL),
(39, '2023-12-13-6579bc429e41b.webp', 'Main Banner', 'theme_aster', 1, '2023-12-13 17:14:26', '2023-12-20 22:49:58', 'https://build.euromarketn.com/', 'product', 111, NULL, NULL, NULL, NULL, 'de', 2, NULL),
(40, '2023-12-13-6579bc51a9ce1.webp', 'Main Banner', 'theme_aster', 1, '2023-12-13 17:14:41', '2023-12-20 22:49:55', 'https://build.euromarketn.com/', 'product', 111, NULL, NULL, NULL, NULL, 'de', 2, NULL),
(41, '2023-12-13-6579bc5f76eea.webp', 'Main Banner', 'theme_aster', 1, '2023-12-13 17:14:55', '2023-12-19 15:12:04', 'https://build.euromarketn.com/', 'product', 111, NULL, NULL, NULL, NULL, 'de', 2, NULL),
(42, '2024-01-12-65a0628a3dd13.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-21 23:48:59', '2024-01-12 00:50:02', 'https://build.euromarketn.com/products?id=272&data_from=category&page=1', 'category', 272, NULL, NULL, NULL, NULL, 'en', 2, 22),
(43, '2024-01-12-65a062ade8f3e.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-21 23:49:28', '2024-01-12 00:50:37', 'https://build.euromarketn.com/products?id=272&data_from=category&page=1', 'category', 272, NULL, NULL, NULL, NULL, 'nl', 2, 23),
(44, '2024-01-12-65a062cbb89ae.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-21 23:49:54', '2024-01-12 00:51:07', 'https://build.euromarketn.com/products?id=272&data_from=category&page=1', 'category', 272, NULL, NULL, NULL, NULL, 'de', 2, 0),
(45, '2023-12-22-6584ae71b7129.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 00:30:25', '2023-12-22 15:55:43', 'https://build.euromarketn.com/products?id=259&data_from=category&page=1', 'category', 259, NULL, NULL, NULL, NULL, 'en', 2, 26),
(46, '2023-12-22-6584af1e23ca1.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 00:33:18', '2023-12-22 16:16:38', 'https://build.euromarketn.com/products?id=259&data_from=category&page=1', 'category', 259, NULL, NULL, NULL, NULL, 'nl', 2, 26),
(47, '2023-12-22-6584af3e90432.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 00:33:50', '2023-12-22 16:57:22', 'https://build.euromarketn.com/products?id=259&data_from=category&page=1', 'category', 259, NULL, NULL, NULL, NULL, 'de', 2, 26),
(48, '2023-12-22-6584b058e6b72.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 00:38:32', '2023-12-22 16:00:27', 'https://build.euromarketn.com/products?id=258&data_from=category&page=1', 'category', 258, NULL, NULL, NULL, NULL, 'en', 2, 21),
(49, '2023-12-22-6584b0782552a.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 00:39:04', '2023-12-22 16:23:50', 'https://build.euromarketn.com/products?id=258&data_from=category&page=1', 'category', 258, NULL, NULL, NULL, NULL, 'nl', 2, 21),
(50, '2023-12-22-6584b0b63c6ae.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 00:40:06', '2023-12-22 00:40:15', 'https://build.euromarketn.com/products?id=258&data_from=category&page=1', 'category', 258, NULL, NULL, NULL, NULL, 'de', 2, NULL),
(51, '2023-12-22-658585dd3168b.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 15:49:33', '2023-12-22 15:58:02', 'https://build.euromarketn.com/products?id=245&data_from=category&page=1', 'category', 245, NULL, NULL, NULL, NULL, 'en', 2, 24),
(52, '2023-12-22-658585f81ce76.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 15:50:00', '2023-12-22 16:17:19', 'https://build.euromarketn.com/products?id=245&data_from=category&page=1', 'category', 245, NULL, NULL, NULL, NULL, 'nl', 2, 24),
(53, '2023-12-22-6585860a56cbc.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 15:50:18', '2023-12-22 16:58:49', 'https://build.euromarketn.com/products?id=245&data_from=category&page=1', 'category', 245, NULL, NULL, NULL, NULL, 'de', 2, 24),
(54, '2024-01-12-65a05f62b9fde.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 16:34:52', '2024-01-12 00:36:34', 'https://build.euromarketn.com/products?id=271&data_from=category&page=1', 'category', 271, NULL, NULL, NULL, NULL, 'nl', 2, 17),
(55, '2023-12-22-658593835e806.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 16:47:47', '2023-12-22 16:48:10', 'https://build.euromarketn.com/products?id=2&data_from=category&page=1', 'category', 2, NULL, NULL, NULL, NULL, 'de', 2, 30),
(56, '2023-12-22-658593b4e93a9.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 16:48:36', '2023-12-22 16:51:00', 'https://build.euromarketn.com/products?id=3&data_from=category&page=1', 'category', 3, NULL, NULL, NULL, NULL, 'de', 2, 29),
(57, '2023-12-22-658594c9622e7.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 16:53:13', '2023-12-22 16:53:29', 'https://build.euromarketn.com/products?id=6&data_from=category&page=1', 'category', 6, NULL, NULL, NULL, NULL, 'de', 2, 28),
(58, '2024-01-12-65a05804834dd.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 16:54:51', '2024-01-12 00:05:08', 'https://build.euromarketn.com/products?id=4&data_from=category&page=1', 'category', 4, NULL, NULL, NULL, NULL, 'de', 2, 27),
(59, '2023-12-22-658595ead745f.webp', 'Main Section Banner', 'theme_aster', 1, '2023-12-22 16:58:02', '2023-12-22 16:58:23', 'https://build.euromarketn.com/products?id=8&data_from=category&page=1', 'category', 8, NULL, NULL, NULL, NULL, 'de', 2, 25),
(60, '2023-12-22-6585963aa1792.webp', 'Main Banner', 'theme_aster', 0, '2023-12-22 16:59:22', '2023-12-22 16:59:22', 'https://build.euromarketn.com/products?id=5&data_from=category&page=1', 'category', 5, NULL, NULL, NULL, NULL, 'Both', 2, NULL),
(61, '2024-01-12-65a05fa0b472b.webp', 'Main Section Banner', 'theme_aster', 1, '2024-01-12 00:37:36', '2024-01-12 00:37:59', 'https://build.euromarketn.com/products?id=271&data_from=category&page=1', 'category', 271, NULL, NULL, NULL, NULL, 'de', 2, 17);

-- --------------------------------------------------------

--
-- Table structure for table `billing_addresses`
--

CREATE TABLE `billing_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `contact_person_name` varchar(191) DEFAULT NULL,
  `address_type` varchar(191) DEFAULT NULL,
  `address` varchar(191) DEFAULT NULL,
  `city` varchar(191) DEFAULT NULL,
  `zip` varchar(191) DEFAULT NULL,
  `phone` varchar(191) DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `image` varchar(50) NOT NULL DEFAULT 'def.png',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Adidas', '2023-11-04-654644f8abfe0.png', 1, '2023-11-04 13:19:52', '2023-11-04 13:19:52'),
(2, 'Samsung', '2023-11-07-654a82e0365b5.png', 1, '2023-11-07 21:33:04', '2023-11-07 21:33:04'),
(3, 'Boss', '2023-11-07-654a84bbd14df.png', 1, '2023-11-07 21:40:59', '2023-11-07 21:40:59'),
(4, 'Chanel', '2023-11-07-654a8570d6760.png', 1, '2023-11-07 21:44:00', '2023-11-07 21:44:00'),
(5, 'Carter\'s', '2023-11-07-654a85c929594.png', 1, '2023-11-07 21:45:29', '2023-11-07 21:45:29'),
(6, 'Calvin Klein', '2023-11-07-654a85edef81c.png', 1, '2023-11-07 21:46:05', '2023-11-07 21:46:05'),
(7, 'Apple', '2023-11-07-654a860287601.png', 1, '2023-11-07 21:46:26', '2023-11-07 21:46:26'),
(8, 'Xiaomi', '2023-11-07-654a86c9cbdb7.png', 1, '2023-11-07 21:49:45', '2023-11-07 21:49:45');

-- --------------------------------------------------------

--
-- Table structure for table `business_settings`
--

CREATE TABLE `business_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(50) NOT NULL,
  `value` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `business_settings`
--

INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES
(1, 'system_default_currency', '1', '2020-10-11 07:43:44', '2021-06-04 18:25:29'),
(2, 'language', '[{\"id\":\"1\",\"name\":\"english\",\"direction\":\"ltr\",\"code\":\"en\",\"status\":1,\"default\":true},{\"id\":2,\"name\":\"Netherlands\",\"direction\":\"ltr\",\"code\":\"nl\",\"status\":1,\"default\":false},{\"id\":3,\"name\":\"Germany\",\"direction\":\"ltr\",\"code\":\"de\",\"status\":1,\"default\":false}]', '2020-10-11 07:53:02', '2024-01-27 02:09:08'),
(3, 'mail_config', '{\"status\":\"1\",\"name\":\"Admin\",\"host\":\"smtp.titan.email\",\"driver\":\"SMTP\",\"port\":\"587\",\"username\":\"admin@euromarketn.com\",\"email_id\":\"admin@euromarketn.com\",\"encryption\":\"TLS\",\"password\":\"eR3@o5D#WETd\"}', '2020-10-12 10:29:18', '2023-11-14 17:03:43'),
(4, 'cash_on_delivery', '{\"status\":\"1\"}', NULL, '2021-05-25 21:21:15'),
(6, 'ssl_commerz_payment', '{\"status\":\"0\",\"environment\":\"sandbox\",\"store_id\":\"\",\"store_password\":\"\"}', '2020-11-09 08:36:51', '2023-01-10 05:51:56'),
(7, 'paypal', '{\"status\":\"0\",\"environment\":\"sandbox\",\"paypal_client_id\":\"\",\"paypal_secret\":\"\"}', '2020-11-09 08:51:39', '2023-01-10 05:51:56'),
(8, 'stripe', '{\"status\":\"0\",\"api_key\":null,\"published_key\":null}', '2020-11-09 09:01:47', '2021-07-06 12:30:05'),
(10, 'company_phone', '0031613005511', NULL, '2020-12-08 14:15:01'),
(11, 'company_name', 'Euro Marketn', NULL, '2021-02-27 18:11:53'),
(12, 'company_web_logo', '2023-11-23-655f4fc8d0256.webp', NULL, '2023-11-23 16:12:40'),
(13, 'company_mobile_logo', '2023-11-06-654974d601055.png', NULL, '2023-11-06 23:20:54'),
(14, 'terms_condition', '<h2><strong>Introduction and Company Rules</strong></h2>\r\n\r\n<p><strong>Euro Marketn</strong> is an online store located in the Netherlands, Europe, specializing in wholesale, providing customers with high-quality products conveniently and professionally. We pride ourselves on delivering a unique and distinctive shopping experience for our customers in Europe and worldwide.</p>\r\n\r\n<p><strong>Efficient and Secure Transactions</strong> We offer an efficient and secure communication service between manufacturers and merchants, ensuring 100% rights for both parties. We prioritize facilitating e-commerce reliably and securely.</p>\r\n\r\n<p><strong>&quot;Goods Delivered, Money Received&quot; Principle</strong> At Euro Marketn, we follow the principle of &quot;Goods Delivered, Money Received,&quot; reflecting our commitment to transparency and integrity. When the buyer confirms receiving the goods, matching the description and expected quality, the seller can withdraw their funds easily and seamlessly. This approach ensures the rights of both the seller and the buyer, creating a business environment based on mutual trust. We strive to facilitate e-commerce transactions between parties while emphasizing the safety and transparency of deals.</p>\r\n\r\n<h3>Secure Payment and Deal Protection</h3>\r\n\r\n<p>Understanding the importance of security in trade deals, Euro Marketn provides secure payment methods that contribute to building trust based on the &quot;Goods Delivered, Money Received&quot; principle. This approach enhances protection for both manufacturers and merchants, sellers, and buyers, confirming the delivery of goods before receiving the financial amount.</p>\r\n\r\n<h3>Wholesale Sales and Business Deals</h3>\r\n\r\n<p>Our company specializes in wholesale sales and commercial deals from the manufacturer to the merchant. We are committed to providing a transparent and fair business environment, allowing involved parties to monitor deal operations accurately. This reflects our commitment to providing a reliable and secure business experience, promoting trust and contributing to the success of e-commerce transactions between manufacturers and merchants.</p>\r\n\r\n<h3>Focus on European Quality</h3>\r\n\r\n<p>Euro Marketn stands out by focusing on European quality, striving to provide a diverse range of products meeting the highest standards of quality and performance. Our online store offers a wide selection of goods, effectively meeting business needs.</p>\r\n\r\n<h3>Customer-Centric Approach</h3>\r\n\r\n<p>Putting the customer at the core of our concerns, we always aim to achieve their satisfaction by providing excellent customer service and prompt delivery. Our reliance on European quality standards reflects our commitment to delivering the best possible shopping experience for our customers.</p>\r\n\r\n<h3>Strategic Location and Global Readiness</h3>\r\n\r\n<p>Thanks to our location in the heart of Europe, we are ready to meet the needs of global companies and businesses. Choose Euro Marketn for a responsive success aligned with wholesale market requirements and a unique shopping experience.</p>\r\n\r\n<h3>Commitment to Quality and Security</h3>\r\n\r\n<p>Euro Marketn, headquartered in the Netherlands, Europe, is a pioneer in wholesale e-commerce. We take pride in working with European quality professionally, providing a wide range of high-quality products with elegant design and outstanding performance. Our online store is a reliable destination for businesses and entrepreneurs seeking a trustworthy source for large-scale supplies.</p>\r\n\r\n<h3>Customer Satisfaction Guarantee</h3>\r\n\r\n<p>We prioritize customer satisfaction, offering exceptional customer service and committing to fast delivery. Our strategic location in the Netherlands contributes to logistical strength and ease of communication, making Euro Market an ideal partner to meet wholesale market needs globally. Choose Euro Marketn for a wholesale shopping experience that combines quality and professionalism.</p>\r\n\r\n<h3>Information Protection and Privacy</h3>\r\n\r\n<p><strong>Intellectual Property Protection:</strong> We are committed to safeguarding the intellectual property rights of the products and trademarks we offer. Products are meticulously selected to ensure no infringement of the intellectual property rights of others. We support creativity and respect legal rights.</p>\r\n\r\n<p><strong>Information Protection and Privacy:</strong></p>\r\n\r\n<ul>\r\n	<li>We strongly emphasize protecting your personal information during all electronic transaction processes.</li>\r\n	<li>We commit not to use customer information for any purpose other than the services provided by our company.</li>\r\n	<li>Your privacy is essential to us, and we pledge not to use personal information for any purpose unrelated to the services we offer.</li>\r\n	<li>Information protection is crucial to us, and we consider it a valuable asset. Therefore, we take strict measures to ensure its security and promise not to share it with any external parties.</li>\r\n</ul>\r\n\r\n<p>These statements confirm the company&#39;s commitment to protecting customer personal information and providing a safe and reliable shopping experience. Thanks to our dedication to quality and safety, our customers can rely on Euro Market as a trusted partner to facilitate smooth trade operations between manufacturers and merchants.</p>\r\n\r\n<h2><strong>Sales Terms and Rules</strong></h2>\r\n\r\n<p>In our company, the sales terms and rules dictate that the manufacturer or seller must adhere to European CE quality standards. This CE mark serves as a safety certification, ensuring that the products are non-hazardous to human safety and the environment. Goods offered for sale must be of high quality and come with a quality guarantee. Sellers are required to present goods with high-resolution images that accurately reflect reality, including providing precise and honest details and dimensions. Sellers are prohibited from manipulating images to enhance appearance; all information must accurately reflect reality to ensure transparency and reliability in sales.</p>\r\n\r\n<p><strong>Writing the product&#39;s place of manufacture is mandatory. Transparency and reliability are crucial in sales operations.</strong></p>\r\n\r\n<p><em>(The seller must consider and adhere to the company&#39;s rules.)</em></p>\r\n\r\n<p><strong>Intellectual Property Protection:</strong> We are committed to protecting the intellectual property rights of the products and trademarks we offer. Products are carefully selected to ensure no violation of the intellectual property rights of others. We support creativity and respect the legal rights of rightful owners.</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p><em>Compliance with European Quality Standards (CE):</em> Manufacturers must comply with recognized European quality standards (CE), ensuring manufacturing according to the highest standards.</p>\r\n	</li>\r\n	<li>\r\n	<p><em>Product Quality and Quality Guarantee:</em> Goods must be of high quality, with the provision of an official guarantee confirming their quality and performance.</p>\r\n	</li>\r\n	<li>\r\n	<p><em>High-Resolution Images:</em> Sellers are required to display goods with high-quality and high-resolution images, ensuring that the images accurately depict reality.</p>\r\n	</li>\r\n	<li>\r\n	<p><em>Providing Comprehensive Details:</em> Sellers must provide comprehensive details about products, including dimensions and specifications, enabling buyers to make informed decisions.</p>\r\n	</li>\r\n	<li>\r\n	<p><em>Non-Manipulation of Images:</em> Sellers are strictly prohibited from manipulating images in ways that enhance appearance or deceive consumers.</p>\r\n	</li>\r\n	<li>\r\n	<p><em>Transparency and Fair Presentation:</em> Sellers must exhibit complete transparency in presenting products and dealing with information.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>We commit not to deal with low-quality, counterfeit, used, or forged goods. Sellers are fully responsible for the quality of the products they offer, and we strictly place this responsibility on them. Our goal is to provide high-quality and authentic products to our customers, emphasizing the importance of honesty and transparency in all sales operations.</strong></p>\r\n	</li>\r\n	<li>\r\n	<p><strong>We enforce a strict ban on selling harmful and spoiled products, prioritizing human safety and environmental well-being. We are committed to providing products that meet health and environmental standards, and sellers are expected to refrain from offering any product that could be harmful to consumers or negatively impact the environment.</strong></p>\r\n	</li>\r\n</ol>\r\n\r\n<p><strong>We emphasize the importance of focusing on safety and health, considering consumer protection and environmental care as integral parts of our responsibilities at Euro Marketn.</strong></p>\r\n\r\n<p><strong>These terms reflect our commitment to providing a reliable and quality-assured online shopping experience.</strong></p>\r\n\r\n<h2 style=\"font-style:italic\"><strong>Shipping Policy</strong></h2>\r\n\r\n<p>Our shipping policy allows the seller the freedom to choose the countries or cities they wish or can ship products to, with an approximate estimate of the delivery period to customers. We enable sellers to flexibly determine shipping options, allowing them to better meet customer needs based on shipping and delivery conditions.</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p><strong>Targeted Countries and Cities:</strong> The seller selects the countries and cities they wish to provide shipping services to, with the option to expand or reduce these choices as needed.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Shipping Cost:</strong> The seller bears the shipping cost, which is added to the original product price. This approach allows customers to benefit from free or low-cost shipping, making the purchasing process more transparent and reducing variables that may impact customer decisions.</p>\r\n\r\n	<p>We strive to balance providing reliable shipping services while maintaining price attractiveness, enhancing customer satisfaction, and ensuring a positive online shopping experience.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Approximate Delivery Period:</strong> The seller specifies an approximate timeframe for the delivery of orders to customers, promoting transparency and helping customers set their expectations.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Available Shipping Methods:</strong> The system allows the seller to specify available shipping methods, such as express mail, economy shipping, or others.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Tracking Information:</strong> Encouragement is given to provide tracking information to customers, enabling them to easily monitor the status of their orders.</p>\r\n	</li>\r\n	<li>\r\n	<p><strong>Additional Details:</strong> Sellers can add extra details, such as return policies or shipping insurance, to enhance the customer experience.</p>\r\n	</li>\r\n</ol>\r\n\r\n<h2><strong>Return Policy for Euromarketn.com</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Thank you for shopping at Euromarketn.com. We want to ensure that you are completely satisfied with your purchase. If you are not satisfied with your purchase, we are here to help.</p>\r\n\r\n<ol>\r\n	<li><strong>Online Return Portal</strong>: Facilitating the return process through an electronic portal.</li>\r\n	<li><strong>Non-use of the Product</strong>: The buyer must not use the product before deciding to keep or return it.</li>\r\n	<li><strong>Prompt Notification to the Seller</strong>: Reporting any product defects as soon as possible.</li>\r\n	<li><strong>Return Process</strong>: Submitting a return request within the specified period.</li>\r\n	<li><strong>Product Condition Verification</strong>: The seller must verify the condition of the product upon receipt.</li>\r\n</ol>\r\n\r\n<h3>General Notes</h3>\r\n\r\n<ul>\r\n	<li><strong>Enhancing Trust and Transparency</strong>: These policies aim to build strong relationships with customers and enhance transparency.</li>\r\n	<li><strong>Providing Alternatives</strong>: Offering alternatives to products if possible, to increase customer satisfaction.</li>\r\n</ul>\r\n\r\n<h2><strong>Refund Policy for Euromarketn.com</strong></h2>\r\n\r\n<ol>\r\n	<li>\r\n	<p><strong>Right to Return or Exchange</strong>: The buyer has the right to return or exchange products that do not match the advertised commercial data or if there is a discrepancy in characteristics and specifications.</p>\r\n	</li>\r\n	<li><strong>Return Period</strong>: 15 days from the date of product receipt.</li>\r\n	<li><strong>Defective or Non-conforming Products</strong>: Products that are defective or do not meet standard specifications can be returned or exchanged.</li>\r\n	<li><strong>Return Conditions</strong>: The product must be in its original, unused condition.</li>\r\n	<li><strong>Responsibility for Damage</strong>: If the product is not received in its original condition, the buyer bears responsibility.</li>\r\n</ol>\r\n\r\n<h2><strong>Cancellation Policy for Euromarketn.com</strong></h2>\r\n\r\n<p><strong>Order Cancellation:</strong></p>\r\n\r\n<ul>\r\n	<li>Orders can be canceled within&nbsp;24 hours&nbsp; of placement. After this period, the order may have already entered the processing or shipping phase and cannot be canceled.</li>\r\n</ul>\r\n\r\n<p><strong>Cancellation Process:</strong></p>\r\n\r\n<ol>\r\n	<li>To cancel an order, please contact our customer service team promptly at info@euromarketn.com or 0031613005511.</li>\r\n	<li>Provide your order number and a clear explanation of the reason for cancellation.</li>\r\n</ol>\r\n\r\n<p><strong>Refund for Canceled Orders:</strong></p>\r\n\r\n<ul>\r\n	<li>If your order is canceled within the specified timeframe, a full refund will be issued to your original method of payment.</li>\r\n	<li>Refunds may take [number of days, e.g., 5-7 days] to process, depending on your financial institution.</li>\r\n</ul>\r\n\r\n<p><strong>Exceptions:</strong></p>\r\n\r\n<ul>\r\n	<li>Customized or made-to-order items may not be eligible for cancellation once production has started.</li>\r\n</ul>\r\n\r\n<h2><strong>Privacy Policy for Euromarketn.com</strong></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Your privacy is important to us. This Privacy Policy outlines how Euromarketn.com collects, uses, maintains, and discloses information collected from users of the website.</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p><strong>Information Collection:</strong></p>\r\n\r\n	<ul>\r\n		<li>We may collect personal identification information from users when they visit our site, place an order, subscribe to the newsletter, or fill out a form. Users may be asked for their name, email address, phone number, and other relevant details.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>How We Use Collected Information:</strong></p>\r\n\r\n	<ul>\r\n		<li>Personal information collected may be used to process transactions, send periodic emails, and improve customer service. We do not sell, trade, or rent user information to others.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>Protection of Information:</strong></p>\r\n\r\n	<ul>\r\n		<li>We adopt appropriate data collection, storage, and processing practices and security measures to protect against unauthorized access, alteration, disclosure, or destruction of personal information.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>Sharing Personal Information:</strong></p>\r\n\r\n	<ul>\r\n		<li>We do not sell, trade, or rent users&#39; personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners and trusted affiliates.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>Changes to This Privacy Policy:</strong></p>\r\n\r\n	<ul>\r\n		<li>Euromarketn.com has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage users to frequently check this page for any changes.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>Your Acceptance of These Terms:</strong></p>\r\n\r\n	<ul>\r\n		<li>By using this site, you signify your acceptance of this policy. If you do not agree</li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n\r\n<p><strong>Contact Us:</strong> If you have any questions about our Return Policy, contact us at info@euromarketn.com or 0031613005511.</p>\r\n\r\n<p>This organization enhances the effectiveness of the shipping policy and ensures that the online shopping process is a convenient and transparent experience for customers.</p>\r\n\r\n<p>&nbsp;</p>', NULL, '2024-01-13 00:22:05'),
(15, 'about_us', '<h3><strong>Introductory Overview and Company Rules</strong></h3>\r\n\r\n<p><strong>Company Overview:</strong> Euro Marketn is an online store based in the Netherlands, Europe, specializing in wholesale. We pride ourselves on offering high-quality products with ease and professionalism, providing a unique shopping experience for customers in Europe and around the world.</p>\r\n\r\n<p><strong>Efficient and Secure Service:</strong> We provide an efficient and secure platform for communication between manufacturers and merchants, ensuring 100% rights for both parties. Our commitment is to facilitate reliable and secure e-commerce transactions.</p>\r\n\r\n<p><strong>Goods Received, Money Transferred Principle:</strong> At Euro Marketn, we adhere to the principle of &quot;Goods Received, Money Transferred,&quot; reflecting our commitment to transparency and integrity. When the buyer confirms receipt of the goods, matching the description and expected quality, the seller can easily and smoothly withdraw their funds.</p>\r\n\r\n<p>This approach ensures the rights of both the seller and the buyer, creating a business environment based on mutual trust. We strive to facilitate e-commerce transactions between parties, emphasizing the safety and transparency of deals.</p>\r\n\r\n<p><strong>Security in Trade Deals:</strong> Understanding the importance of security in trade deals, Euro Marketn provides secure payment methods, building trust based on the principle of &quot;Goods Received, Money Transferred.&quot; This approach enhances protection for both manufacturers and merchants, sellers, and buyers, confirming the delivery of goods before receiving payment.</p>\r\n\r\n<p><strong>Wholesale Sales and Business Deals:</strong> Our company specializes in wholesale sales and business deals, connecting manufacturers with merchants.</p>\r\n\r\n<p><strong>Transparent and Fair Business Environment:</strong> We are committed to providing a transparent and fair business environment, allowing involved parties to monitor transactions accurately. This commitment reflects our dedication to providing a reliable and secure business experience, fostering trust and contributing to the success of e-commerce transactions between manufacturers and merchants.</p>\r\n\r\n<p><strong>Focus on European Quality:</strong> Distinguishing ourselves through a focus on European quality, we strive to provide a diverse range of products meeting the highest standards. Our online store offers a wide selection, effectively meeting business needs.</p>\r\n\r\n<p><strong>Customer-Centric Approach:</strong> Placing the customer at the center of our priorities, we always aim to achieve their satisfaction by providing excellent customer service and prompt delivery. Our reliance on European quality standards reflects our commitment to offering the best shopping experience for our customers.</p>\r\n\r\n<p><strong>Global Reach:</strong> With our strategic location in the heart of Europe, we are ready to meet the needs of global businesses. Choose Euro Marketn for a responsive success in wholesale market requirements and a unique shopping experience.</p>\r\n\r\n<p><strong>European-Quality Products:</strong> Euro Marketn, based in the Netherlands, Europe, is a leading player in wholesale e-commerce. We take pride in offering a distinctive range of high-quality products, focusing on meeting global business and customer needs.</p>\r\n\r\n<p><strong>Customer Satisfaction:</strong> We prioritize customer satisfaction by providing exceptional customer service and committing to fast delivery. Our strategic location in the Netherlands contributes to logistical strength and easy communication, making Euro Market the ideal partner for global wholesale market needs. Choose Euro Marketn for a wholesale experience combining quality and professionalism.</p>\r\n\r\n<p><strong>Transaction Safety:</strong> We ensure transaction safety through &quot;Goods Received, Money Transferred&quot; principles and secure payments, building strong trust between parties. We strive to create a business environment that ensures transparency and fair dealings.</p>\r\n\r\n<p><strong>Intellectual Property Protection:</strong> We are committed to protecting the intellectual property rights of the products and trademarks we offer. Products are carefully selected to avoid violating the intellectual property rights of others. We support creativity and respect the rights of legal owners.</p>\r\n\r\n<p><strong>Information and Privacy Protection:</strong> We strongly emphasize protecting your personal information during all electronic transactions. We do not use customer information for any other purpose and commit to maintaining the confidentiality of your data. The use of personal information is restricted to the agreed-upon purpose, ensuring a safe and reliable shopping experience.</p>\r\n\r\n<p><strong>Privacy Commitment:</strong> We pledge not to use your personal information for any purpose unrelated to the services we provide. We prioritize protecting your privacy in all electronic transaction details.</p>\r\n\r\n<p><strong>Information Protection:</strong> We value the confidentiality of your data and consider it a valuable asset. Therefore, we take strict measures to ensure its security and promise not to share it with any external party. Enjoy a safe shopping experience with us.</p>\r\n\r\n<p>These statements are based on confirming the company&#39;s commitment to protecting customer personal information and providing a safe and reliable shopping experience. Thanks to our commitment to quality and safety, our customers can rely on Euro Market as a trusted partner to facilitate seamless trade operations between manufacturers and merchants.</p>\r\n\r\n<p><strong>Contact Us:</strong> If you have any questions about our Cancellation Policy, please contact us at info@euromarketn.com or 0031613005511.</p>', NULL, '2024-01-08 22:46:39'),
(16, 'sms_nexmo', '{\"status\":\"0\",\"nexmo_key\":\"custo5cc042f7abf4c\",\"nexmo_secret\":\"custo5cc042f7abf4c@ssl\"}', NULL, NULL),
(17, 'company_email', 'info@euromarketn.com', NULL, '2021-03-15 12:29:51'),
(18, 'colors', '{\"primary\":\"#ed8327\",\"secondary\":\"#2b2b2b\",\"primary_light\":\"#cfdffb\"}', '2020-10-11 13:53:02', '2023-10-13 05:34:53'),
(19, 'company_footer_logo', '2023-11-06-654974d602d82.png', NULL, '2023-11-06 23:20:54'),
(20, 'company_copyright_text', 'CopyRight Euro Marketn@2023', NULL, '2021-03-15 12:30:47'),
(21, 'download_app_apple_stroe', '{\"status\":\"1\",\"link\":\"https:\\/\\/www.target.com\\/s\\/apple+store++now?ref=tgt_adv_XS000000&AFID=msn&fndsrc=tgtao&DFA=71700000012505188&CPNG=Electronics_Portable+Computers&adgroup=Portable+Computers&LID=700000001176246&LNM=apple+store+near+me+now&MT=b&network=s&device=c&location=12&targetid=kwd-81913773633608:loc-12&ds_rl=1246978&ds_rl=1248099&gclsrc=ds\"}', NULL, '2020-12-08 12:54:53'),
(22, 'download_app_google_stroe', '{\"status\":\"1\",\"link\":\"https:\\/\\/play.google.com\\/store?hl=en_US&gl=US\"}', NULL, '2020-12-08 12:54:48'),
(23, 'company_fav_icon', '2023-11-06-654974d6037a5.png', '2020-10-11 13:53:02', '2023-11-06 23:20:54'),
(24, 'fcm_topic', '', NULL, NULL),
(25, 'fcm_project_id', '', NULL, NULL),
(26, 'push_notification_key', 'Put your firebase server key here.', NULL, NULL),
(27, 'order_pending_message', '{\"status\":\"1\",\"message\":\"order pen message\"}', NULL, NULL),
(28, 'order_confirmation_msg', '{\"status\":\"1\",\"message\":\"Order con Message\"}', NULL, NULL),
(29, 'order_processing_message', '{\"status\":\"1\",\"message\":\"Order pro Message\"}', NULL, NULL),
(30, 'out_for_delivery_message', '{\"status\":\"1\",\"message\":\"Order ouut Message\"}', NULL, NULL),
(31, 'order_delivered_message', '{\"status\":\"1\",\"message\":\"Order del Message\"}', NULL, NULL),
(32, 'razor_pay', '{\"status\":\"0\",\"razor_key\":null,\"razor_secret\":null}', NULL, '2021-07-06 12:30:14'),
(33, 'sales_commission', '20', NULL, '2023-11-07 02:26:02'),
(34, 'seller_registration', '1', NULL, '2023-11-07 02:26:02'),
(35, 'pnc_language', '[\"en\",\"nl\",\"de\"]', NULL, NULL),
(36, 'order_returned_message', '{\"status\":\"1\",\"message\":\"Order hh Message\"}', NULL, NULL),
(37, 'order_failed_message', '{\"status\":null,\"message\":\"Order fa Message\"}', NULL, NULL),
(40, 'delivery_boy_assign_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(41, 'delivery_boy_start_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(42, 'delivery_boy_delivered_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(43, 'terms_and_conditions', '', NULL, NULL),
(44, 'minimum_order_value', '1', NULL, NULL),
(45, 'privacy_policy', '<p><strong>Privacy Policy for Euromarketn.com</strong></p>\r\n\r\n<p><em>Effective Date: November 11, 2023</em></p>\r\n\r\n<p>Your privacy is important to us. This Privacy Policy outlines how Euromarketn.com collects, uses, maintains, and discloses information collected from users of the website.</p>\r\n\r\n<ol>\r\n	<li>\r\n	<p><strong>Information Collection:</strong></p>\r\n\r\n	<ul>\r\n		<li>We may collect personal identification information from users when they visit our site, place an order, subscribe to the newsletter, or fill out a form. Users may be asked for their name, email address, phone number, and other relevant details.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>How We Use Collected Information:</strong></p>\r\n\r\n	<ul>\r\n		<li>Personal information collected may be used to process transactions, send periodic emails, and improve customer service. We do not sell, trade, or rent user information to others.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>Protection of Information:</strong></p>\r\n\r\n	<ul>\r\n		<li>We adopt appropriate data collection, storage, and processing practices and security measures to protect against unauthorized access, alteration, disclosure, or destruction of personal information.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>Sharing Personal Information:</strong></p>\r\n\r\n	<ul>\r\n		<li>We do not sell, trade, or rent users&#39; personal identification information to others. We may share generic aggregated demographic information not linked to any personal identification information regarding visitors and users with our business partners and trusted affiliates.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>Changes to This Privacy Policy:</strong></p>\r\n\r\n	<ul>\r\n		<li>Euromarketn.com has the discretion to update this privacy policy at any time. When we do, we will revise the updated date at the bottom of this page. We encourage users to frequently check this page for any changes.</li>\r\n	</ul>\r\n	</li>\r\n	<li>\r\n	<p><strong>Your Acceptance of These Terms:</strong></p>\r\n\r\n	<ul>\r\n		<li>By using this site, you signify your acceptance of this policy. If you do not agree</li>\r\n	</ul>\r\n	</li>\r\n</ol>\r\n\r\n<p><strong>Contact Us:</strong> If you have any questions about our Return Policy, contact us at info@euromarketn.com or 0031613005511.</p>\r\n\r\n<p>&nbsp;</p>', NULL, '2024-01-05 00:45:20'),
(46, 'paystack', '{\"status\":\"0\",\"publicKey\":null,\"secretKey\":null,\"paymentUrl\":\"https:\\/\\/api.paystack.co\",\"merchantEmail\":null}', NULL, '2021-07-06 12:30:35'),
(47, 'senang_pay', '{\"status\":\"0\",\"secret_key\":null,\"merchant_id\":null}', NULL, '2021-07-06 12:30:23'),
(48, 'currency_model', 'multi_currency', NULL, NULL),
(49, 'social_login', '[{\"login_medium\":\"google\",\"client_id\":\"1005331757726-9klc27c8dup6bpb0luq9c826u20p35sa.apps.googleusercontent.com\",\"client_secret\":\"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\",\"status\":0},{\"login_medium\":\"facebook\",\"client_id\":\"1078025340045241\",\"client_secret\":\"52a5fd41a1f512fefddafa1899d1c121\",\"status\":0}]', NULL, '2024-01-26 23:37:25'),
(50, 'digital_payment', '{\"status\":\"1\"}', NULL, NULL),
(51, 'phone_verification', '0', NULL, NULL),
(52, 'email_verification', '1', NULL, NULL),
(53, 'order_verification', '0', NULL, '2023-11-07 02:28:27'),
(54, 'country_code', 'NL', NULL, NULL),
(55, 'pagination_limit', '10', NULL, NULL),
(56, 'shipping_method', 'inhouse_shipping', NULL, NULL),
(57, 'paymob_accept', '{\"status\":\"0\",\"api_key\":\"\",\"iframe_id\":\"\",\"integration_id\":\"\",\"hmac\":\"\"}', NULL, NULL),
(58, 'bkash', '{\"status\":\"0\",\"environment\":\"sandbox\",\"api_key\":\"\",\"api_secret\":\"\",\"username\":\"\",\"password\":\"\"}', NULL, '2023-01-10 05:51:56'),
(59, 'forgot_password_verification', 'email', NULL, NULL),
(60, 'paytabs', '{\"status\":0,\"profile_id\":\"\",\"server_key\":\"\",\"base_url\":\"https:\\/\\/secure-egypt.paytabs.com\\/\"}', NULL, '2021-11-21 03:01:40'),
(61, 'stock_limit', '10', NULL, NULL),
(62, 'flutterwave', '{\"status\":0,\"public_key\":\"\",\"secret_key\":\"\",\"hash\":\"\"}', NULL, NULL),
(63, 'mercadopago', '{\"status\":0,\"public_key\":\"\",\"access_token\":\"\"}', NULL, NULL),
(64, 'announcement', '{\"status\":null,\"color\":null,\"text_color\":null,\"announcement\":null}', NULL, NULL),
(65, 'fawry_pay', '{\"status\":0,\"merchant_code\":\"\",\"security_key\":\"\"}', NULL, '2022-01-18 09:46:30'),
(66, 'recaptcha', '{\"status\":\"1\",\"site_key\":\"6LdDFA8pAAAAAPPANPNJP-iFIfMr-oXNNIcOU66S\",\"secret_key\":\"6LdDFA8pAAAAAFn2GI9l5VOyFIlcHtjYIpt2nDQU\"}', '2023-11-14 17:05:21', '2023-11-14 17:05:21'),
(67, 'seller_pos', '1', NULL, '2023-11-07 02:26:02'),
(68, 'liqpay', '{\"status\":0,\"public_key\":\"\",\"private_key\":\"\"}', NULL, NULL),
(69, 'paytm', '{\"status\":0,\"environment\":\"sandbox\",\"paytm_merchant_key\":\"\",\"paytm_merchant_mid\":\"\",\"paytm_merchant_website\":\"\",\"paytm_refund_url\":\"\"}', NULL, '2023-01-10 05:51:56'),
(70, 'refund_day_limit', '0', NULL, '2023-11-07 02:28:27'),
(71, 'business_mode', 'multi', NULL, NULL),
(72, 'mail_config_sendgrid', '{\"status\":0,\"name\":\"\",\"host\":\"\",\"driver\":\"\",\"port\":\"\",\"username\":\"\",\"email_id\":\"\",\"encryption\":\"\",\"password\":\"\"}', NULL, '2023-11-14 17:03:43'),
(73, 'decimal_point_settings', '2', NULL, NULL),
(74, 'shop_address', 'Rotterdam Netherlands', NULL, NULL),
(75, 'billing_input_by_customer', '1', NULL, '2023-11-07 02:28:27'),
(76, 'wallet_status', '0', NULL, NULL),
(77, 'loyalty_point_status', '0', NULL, NULL),
(78, 'wallet_add_refund', '0', NULL, NULL),
(79, 'loyalty_point_exchange_rate', '0', NULL, NULL),
(80, 'loyalty_point_item_purchase_point', '0', NULL, NULL),
(81, 'loyalty_point_minimum_point', '0', NULL, NULL),
(82, 'minimum_order_limit', '1', NULL, NULL),
(83, 'product_brand', '1', NULL, NULL),
(84, 'digital_product', '1', NULL, NULL),
(85, 'delivery_boy_expected_delivery_date_message', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(86, 'order_canceled', '{\"status\":0,\"message\":\"\"}', NULL, NULL),
(87, 'refund-policy', '{\"status\":1,\"content\":\"<p><strong>Refund Policy for Euromarketn.com<\\/strong><\\/p>\\r\\n\\r\\n<p><em>Effective Date: November 11, 2023<\\/em><\\/p>\\r\\n\\r\\n<p>Thank you for shopping at Euromarketn.com. We want to ensure that you are completely satisfied with your purchase. If you are not satisfied with your purchase, we are here to help.<\\/p>\\r\\n\\r\\n<ol>\\r\\n\\t<li><strong>Right to Return or Exchange<\\/strong>: The buyer has the right to return or exchange products that do not match the advertised commercial data or if there is a discrepancy in characteristics and specifications.<\\/li>\\r\\n\\t<li><strong>Return Period<\\/strong>: 15 days from the date of product receipt.<\\/li>\\r\\n\\t<li><strong>Defective or Non-conforming Products<\\/strong>: Products that are defective or do not meet standard specifications can be returned or exchanged.<\\/li>\\r\\n\\t<li><strong>Return Conditions<\\/strong>: The product must be in its original, unused condition.<\\/li>\\r\\n\\t<li><strong>Responsibility for Damage<\\/strong>: If the product is not received in its original condition, the buyer bears responsibility.<\\/li>\\r\\n<\\/ol>\\r\\n\\r\\n<p><strong>Contact Us:<\\/strong> If you have any questions about our Return Policy, contact us at info@euromarketn.com or 0031613005511.<\\/p>\"}', NULL, '2024-01-05 00:45:08'),
(88, 'return-policy', '{\"status\":1,\"content\":\"<p><strong>Return Policy for Euromarketn.com<\\/strong><\\/p>\\r\\n\\r\\n<p><em>Effective Date: November 11, 2023<\\/em><\\/p>\\r\\n\\r\\n<p>Thank you for shopping at Euromarketn.com. We want to ensure that you are completely satisfied with your purchase. If you are not satisfied with your purchase, we are here to help.<\\/p>\\r\\n\\r\\n<ol>\\r\\n\\t<li><strong>Online Return Portal<\\/strong>: Facilitating the return process through an electronic portal.<\\/li>\\r\\n\\t<li><strong>Non-use of the Product<\\/strong>: The buyer must not use the product before deciding to keep or return it.<\\/li>\\r\\n\\t<li><strong>Prompt Notification to the Seller<\\/strong>: Reporting any product defects as soon as possible.<\\/li>\\r\\n\\t<li><strong>Return Process<\\/strong>: Submitting a return request within the specified period.<\\/li>\\r\\n\\t<li><strong>Product Condition Verification<\\/strong>: The seller must verify the condition of the product upon receipt.<\\/li>\\r\\n<\\/ol>\\r\\n\\r\\n<h3>General Notes<\\/h3>\\r\\n\\r\\n<ul>\\r\\n\\t<li><strong>Enhancing Trust and Transparency<\\/strong>: These policies aim to build strong relationships with customers and enhance transparency.<\\/li>\\r\\n\\t<li><strong>Providing Alternatives<\\/strong>: Offering alternatives to products if possible, to increase customer satisfaction.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p><strong>Contact Us:<\\/strong> If you have any questions about our Return Policy, contact us at info@euromarketn.com or 0031613005511.<\\/p>\"}', NULL, '2024-01-05 00:44:14'),
(89, 'cancellation-policy', '{\"status\":1,\"content\":\"<p><strong>Cancellation Policy for Euromarketn.com<\\/strong><\\/p>\\r\\n\\r\\n<p><em>Effective Date: November 11, 2023<\\/em><\\/p>\\r\\n\\r\\n<p>Thank you for choosing Euromarketn.com. We understand that circumstances may arise that require you to cancel your order, and we aim to make this process as straightforward as possible.<\\/p>\\r\\n\\r\\n<p><strong>Order Cancellation:<\\/strong><\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Orders can be canceled within&nbsp;24 hours&nbsp; of placement. After this period, the order may have already entered the processing or shipping phase and cannot be canceled.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p><strong>Cancellation Process:<\\/strong><\\/p>\\r\\n\\r\\n<ol>\\r\\n\\t<li>To cancel an order, please contact our customer service team promptly at info@euromarketn.com or 0031613005511.<\\/li>\\r\\n\\t<li>Provide your order number and a clear explanation of the reason for cancellation.<\\/li>\\r\\n<\\/ol>\\r\\n\\r\\n<p><strong>Refund for Canceled Orders:<\\/strong><\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>If your order is canceled within the specified timeframe, a full refund will be issued to your original method of payment.<\\/li>\\r\\n\\t<li>Refunds may take [number of days, e.g., 5-7 days] to process, depending on your financial institution.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p><strong>Exceptions:<\\/strong><\\/p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>Customized or made-to-order items may not be eligible for cancellation once production has started.<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<p><strong>Contact Us:<\\/strong> If you have any questions about our Cancellation Policy, please contact us at info@euromarketn.com or 0031613005511.<\\/p>\"}', NULL, '2024-01-05 00:46:22'),
(90, 'offline_payment', '{\"status\":0}', NULL, '2023-03-04 06:25:36'),
(91, 'temporary_close', '{\"status\":0}', NULL, '2023-03-04 06:25:36'),
(92, 'vacation_add', '{\"status\":0,\"vacation_start_date\":null,\"vacation_end_date\":null,\"vacation_note\":null}', NULL, '2023-03-04 06:25:36'),
(93, 'cookie_setting', '{\"status\":\"1\",\"cookie_text\":\"I hereby consent to the use of cookies on your website for an enhanced browsing experience. I understand and agree to your cookie policy as outlined in the privacy policy.\"}', NULL, '2023-11-14 16:55:48'),
(94, 'maximum_otp_hit', '0', NULL, '2023-06-13 13:04:49'),
(95, 'otp_resend_time', '0', NULL, '2023-06-13 13:04:49'),
(96, 'temporary_block_time', '0', NULL, '2023-06-13 13:04:49'),
(97, 'maximum_login_hit', '0', NULL, '2023-06-13 13:04:49'),
(98, 'temporary_login_block_time', '0', NULL, '2023-06-13 13:04:49'),
(99, 'maximum_otp_hit', '0', NULL, '2023-10-13 05:34:53'),
(100, 'otp_resend_time', '0', NULL, '2023-10-13 05:34:53'),
(101, 'temporary_block_time', '0', NULL, '2023-10-13 05:34:53'),
(102, 'maximum_login_hit', '0', NULL, '2023-10-13 05:34:53'),
(103, 'temporary_login_block_time', '0', NULL, '2023-10-13 05:34:53'),
(104, 'apple_login', '[{\"login_medium\":\"apple\",\"client_id\":\"\",\"client_secret\":\"\",\"status\":0,\"team_id\":\"\",\"key_id\":\"\",\"service_file\":\"\",\"redirect_url\":\"\"}]', NULL, '2023-10-13 05:34:53'),
(105, 'ref_earning_status', '0', NULL, '2023-10-13 05:34:53'),
(106, 'ref_earning_exchange_rate', '0', NULL, '2023-10-13 05:34:53'),
(107, 'guest_checkout', '1', NULL, '2023-11-07 02:28:27'),
(108, 'minimum_order_amount', '0', NULL, '2023-10-13 11:34:53'),
(109, 'minimum_order_amount_by_seller', '0', NULL, '2023-11-07 02:26:02'),
(110, 'minimum_order_amount_status', '0', NULL, '2023-11-07 02:28:27'),
(111, 'admin_login_url', 'admin', NULL, '2023-10-13 11:34:53'),
(112, 'employee_login_url', 'employee', NULL, '2023-10-13 11:34:53'),
(113, 'free_delivery_status', '1', NULL, '2023-11-07 02:28:27'),
(114, 'free_delivery_responsibility', 'admin', NULL, '2023-10-13 11:34:53'),
(115, 'free_delivery_over_amount', '0', NULL, '2023-10-13 11:34:53'),
(116, 'free_delivery_over_amount_seller', '0', NULL, '2023-11-07 02:28:27'),
(117, 'add_funds_to_wallet', '0', NULL, '2023-10-13 11:34:53'),
(118, 'minimum_add_fund_amount', '0', NULL, '2023-10-13 11:34:53'),
(119, 'maximum_add_fund_amount', '0', NULL, '2023-10-13 11:34:53'),
(120, 'user_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-13 11:34:53'),
(121, 'seller_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-13 11:34:53'),
(122, 'delivery_man_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-13 11:34:53'),
(123, 'whatsapp', '{\"status\":0,\"phone\":\"31613005511\"}', '2024-01-13 00:42:10', '2024-01-13 00:42:10'),
(124, 'currency_symbol_position', 'left', NULL, '2023-10-13 11:34:53'),
(125, 'ref_earning_status', '0', NULL, '2023-10-25 18:11:02'),
(126, 'ref_earning_exchange_rate', '0', NULL, '2023-10-25 18:11:02'),
(127, 'guest_checkout', '0', NULL, '2023-10-25 18:11:02'),
(128, 'minimum_order_amount', '0', NULL, '2023-10-25 18:11:02'),
(129, 'minimum_order_amount_by_seller', '0', NULL, '2023-10-25 18:11:02'),
(130, 'minimum_order_amount_status', '0', NULL, '2023-10-25 18:11:02'),
(131, 'admin_login_url', 'admin', NULL, '2023-10-25 18:11:02'),
(132, 'employee_login_url', 'employee', NULL, '2023-10-25 18:11:02'),
(133, 'free_delivery_status', '0', NULL, '2023-10-25 18:11:02'),
(134, 'free_delivery_responsibility', 'admin', NULL, '2023-10-25 18:11:02'),
(135, 'free_delivery_over_amount', '0', NULL, '2023-10-25 18:11:02'),
(136, 'free_delivery_over_amount_seller', '0', NULL, '2023-10-25 18:11:02'),
(137, 'add_funds_to_wallet', '0', NULL, '2023-10-25 18:11:02'),
(138, 'minimum_add_fund_amount', '0', NULL, '2023-10-25 18:11:02'),
(139, 'maximum_add_fund_amount', '0', NULL, '2023-10-25 18:11:02'),
(140, 'user_app_version_control', '0', NULL, '2023-10-25 18:11:02'),
(141, 'user_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-25 18:11:02'),
(142, 'seller_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-25 18:11:02'),
(143, 'delivery_man_app_version_control', '{\"for_android\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"},\"for_ios\":{\"status\":1,\"version\":\"14.1\",\"link\":\"\"}}', NULL, '2023-10-25 18:11:02'),
(144, 'whatsapp', '{\"status\":1,\"phone\":\"00000000000\"}', NULL, '2023-10-25 18:11:02'),
(145, 'currency_symbol_position', 'left', NULL, '2023-10-25 18:11:02'),
(146, 'timezone', 'Europe/Amsterdam', NULL, NULL),
(147, 'default_location', '{\"lat\":\"52.1558004\",\"lng\":\"5.3924507\"}', NULL, NULL),
(148, 'loader_gif', '2023-11-06-654974d606cf5.png', NULL, NULL),
(149, 'new_product_approval', '1', NULL, '2023-11-07 02:26:02'),
(150, 'product_wise_shipping_cost_approval', '1', NULL, '2023-11-07 02:26:02'),
(151, 'map_api_key', 'AIzaSyAS2uzKnA6Zjxv2ihfWszDLiYoxqKQmchI', NULL, NULL),
(152, 'map_api_key_server', 'AIzaSyAS2uzKnA6Zjxv2ihfWszDLiYoxqKQmchI', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `cart_group_id` varchar(191) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_type` varchar(20) NOT NULL DEFAULT 'physical',
  `digital_product_type` varchar(30) DEFAULT NULL,
  `color` varchar(191) DEFAULT NULL,
  `choices` text DEFAULT NULL,
  `variations` text DEFAULT NULL,
  `variant` text DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` double NOT NULL DEFAULT 1,
  `tax` double NOT NULL DEFAULT 1,
  `discount` double NOT NULL DEFAULT 1,
  `tax_model` varchar(20) NOT NULL DEFAULT 'exclude',
  `slug` varchar(191) DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `thumbnail` varchar(191) DEFAULT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `seller_is` varchar(191) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_info` varchar(191) DEFAULT NULL,
  `shipping_cost` double(8,2) DEFAULT NULL,
  `shipping_type` varchar(191) DEFAULT NULL,
  `is_guest` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `cart_group_id`, `product_id`, `product_type`, `digital_product_type`, `color`, `choices`, `variations`, `variant`, `quantity`, `price`, `tax`, `discount`, `tax_model`, `slug`, `name`, `thumbnail`, `seller_id`, `seller_is`, `created_at`, `updated_at`, `shop_info`, `shipping_cost`, `shipping_type`, `is_guest`) VALUES
(3, 46, 'guest-g16oe-1699313950', 112, 'physical', NULL, '#483D8B', '{\"choice_1\":\"S\"}', '{\"color\":\"DarkSlateBlue\",\"Size\":\"S\"}', 'DarkSlateBlue-S', 1, 40, 0, 2.8, 'include', 'xuibol-elegant-short-sleeve-gown-v-neck-blue-sequin-evening-dress-tulle-wedding-party-prom-cocktail-dresses-for-women-ve', 'XUIBOL Elegant Short Sleeve Gown V Neck Blue Sequin Evening Dress Tulle Wedding ', '2023-11-06-654955650ec1d.png', 1, 'admin', '2023-11-07 02:39:10', '2023-11-07 02:39:10', 'Euro Marketn', 0.00, 'order_wise', 1),
(4, 46, 'guest-g16oe-1699313950', 111, 'physical', NULL, '#0000FF', '{\"choice_1\":\"M\"}', '{\"color\":\"Blue\",\"Size\":\"M\"}', 'Blue-M', 1, 350, 0, 24.5, 'include', 'graceful-off-the-shoulder-long-sleeve-bride-robe-sparkly-crystal-beads-wedding-dress-luxury-long-bridal-gown-robe-de-mar', 'Graceful Off The Shoulder Long Sleeve Bride Robe Sparkly Crystal Beads Wedding D', '2023-11-04-65464a764c5df.png', 1, 'admin', '2023-11-07 02:47:35', '2023-11-07 02:47:35', 'Euro Marketn', 0.00, 'order_wise', 1),
(5, 47, 'guest-u9hsV-1699314478', 111, 'physical', NULL, '#0000FF', '{\"choice_1\":\"M\"}', '{\"color\":\"Blue\",\"Size\":\"M\"}', 'Blue-M', 1, 350, 0, 24.5, 'include', 'graceful-off-the-shoulder-long-sleeve-bride-robe-sparkly-crystal-beads-wedding-dress-luxury-long-bridal-gown-robe-de-mar', 'Graceful Off The Shoulder Long Sleeve Bride Robe Sparkly Crystal Beads Wedding D', '2023-11-04-65464a764c5df.png', 1, 'admin', '2023-11-07 02:47:58', '2023-11-07 02:47:58', 'Euro Marketn', 0.00, 'order_wise', 1),
(6, 92, 'guest-kXqVp-1699970874', 124, 'physical', NULL, '#000000', '{\"choice_1\":\"S\"}', '{\"color\":\"Black\",\"Size\":\"S\"}', 'Black-S', 1, 3, 0, 0, 'include', 'zoki-white-women-pleated-skirts-summer-high-waist-zipper-girls-dancing-jk-mini-skirts-black-fashion-student-a-line-falda', 'ZOKI White Women Pleated Skirts Summer High Waist Zipper Girls Dancing JK Mini S', '2023-11-08-654bdc0825615.png', 1, 'admin', '2023-11-14 17:07:54', '2023-11-14 17:07:54', 'Euro Marketn', 0.00, 'order_wise', 1),
(9, 163, 'guest-sPiXX-1700754664', 124, 'physical', NULL, '#000000', '{\"choice_1\":\"S\"}', '{\"color\":\"Black\",\"Size\":\"S\"}', 'Black-S', 1, 3, 0, 0, 'include', 'zoki-white-women-pleated-skirts-summer-high-waist-zipper-girls-dancing-jk-mini-skirts-black-fashion-student-a-line-falda', 'ZOKI White Women Pleated Skirts Summer High Waist Zipper Girls Dancing JK Mini S', '2023-11-08-654bdc0825615.png', 1, 'admin', '2023-11-23 18:51:04', '2023-11-23 18:51:04', 'Euro Marketn', 0.00, 'order_wise', 1),
(16, 223, 'guest-gtwdG-1701540731', 140, 'physical', NULL, '#FFD700', '[]', '{\"color\":\"Gold\"}', 'Gold', 1, 18, 0, 0.54, 'include', 'enfashion-para-mujer-ot-buckle-geometry-oval-necklace-for-womens-jewelry-necklaces-stainless-steel-fashion-trendy-cockta', 'ENFASHION Para Mujer OT Buckle Geometry Oval Necklace For Women\'s Jewelry Neckla', '2023-11-10-654e98435b742.webp', 1, 'admin', '2023-12-02 21:12:11', '2023-12-02 21:12:11', 'Euro Marketn', 0.00, 'order_wise', 1),
(17, 261, 'guest-2uH86-1701714380', 133, 'physical', NULL, '#000000', '[]', '{\"color\":\"Black\"}', 'Black', 1, 35, 0, 1.05, 'include', 'leather-car-seat-covers-for-renault-megane-2-3-fluence-scenic-clio-captur-kadjar-logan-2-duster-arkana-kangoo-for-vehicl', 'Leather Car Seat Covers for Renault Megane 2 3 Fluence Scenic Clio Captur Kadjar', '2023-11-09-654d41251331d.webp', 1, 'admin', '2023-12-04 21:26:20', '2023-12-04 21:26:20', 'Euro Marketn', 0.00, 'order_wise', 1),
(19, 290, 'guest-9BCR1-1701988550', 114, 'physical', NULL, NULL, '{\"choice_1\":\"2\"}', '{\"Size\":\"2\"}', '2', 1, 111, 0, 5.55, 'include', 'bespoke-v-neck-a-line-wedding-dress-with-spaghetti-straps-chapel-train-abito-da-sposa-completamente-in-pizzo-macrame-bac', 'Bespoke V-neck A-line Wedding Dress with Spaghetti Straps Chapel Train Abito Da ', '2023-11-07-654a3d170636e.png', 1, 'admin', '2023-12-08 01:35:50', '2023-12-08 01:35:50', 'Euro Marketn', 0.00, 'order_wise', 1),
(20, 358, 'guest-b1AQ8-1702677002', 117, 'physical', NULL, '#000000', '{\"choice_1\":\"S\"}', '{\"color\":\"Black\",\"Size\":\"S\"}', 'Black-S', 1, 6, 0, 0.3, 'include', 'womens-summer-t-shirts-sexy-transparent-mesh-crop-tops-long-sleeve-shirts-y2k-ladies-black-clubwear-skinny-slim-tees-clo', 'Women\'s Summer T-shirts Sexy Transparent Mesh Crop Tops Long Sleeve Shirts Y2K L', '2023-11-07-654a5774a88ef.png', 1, 'admin', '2023-12-16 00:50:02', '2023-12-16 00:50:02', 'Euro Marketn', 0.00, 'order_wise', 1),
(33, 749, 'guest-ZUtp7-1706305415', 114, 'physical', NULL, NULL, '{\"choice_1\":\"6\"}', '{\"Size\":\"6\"}', '6', 3, 112, 0, 5.6, 'include', 'bespoke-v-neck-a-line-wedding-dress-with-spaghetti-straps-chapel-train-abito-da-sposa-completamente-in-pizzo-macrame-bac', 'Bespoke V-neck A-line Wedding Dress with Spaghetti Straps Chapel Train Abito Da ', '2023-11-07-654a3d170636e.png', 1, 'admin', '2024-01-27 00:43:35', '2024-01-27 00:43:35', 'Euro Marketn', 0.00, 'order_wise', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart_shippings`
--

CREATE TABLE `cart_shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_group_id` varchar(191) DEFAULT NULL,
  `shipping_method_id` bigint(20) DEFAULT NULL,
  `shipping_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_shippings`
--

INSERT INTO `cart_shippings` (`id`, `cart_group_id`, `shipping_method_id`, `shipping_cost`, `created_at`, `updated_at`) VALUES
(2, 'guest-g16oe-1699313950', 2, 5.00, '2023-11-07 02:39:17', '2023-11-07 02:39:17'),
(3, 'guest-u9hsV-1699314478', 2, 5.00, '2023-11-07 02:48:04', '2023-11-07 02:48:04'),
(4, 'guest-kXqVp-1699970874', 2, 5.00, '2023-11-14 17:07:59', '2023-11-14 17:07:59'),
(7, 'guest-sPiXX-1700754664', 2, 5.00, '2023-11-23 18:51:08', '2023-11-23 18:51:08'),
(13, 'guest-b1AQ8-1702677002', 9, 0.00, '2023-12-16 00:51:10', '2023-12-16 00:51:10'),
(15, '6-ImKF3-1703984467', 2, 5.00, '2023-12-31 04:01:48', '2023-12-31 04:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `home_status` tinyint(1) NOT NULL DEFAULT 0,
  `priority` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `parent_id`, `position`, `created_at`, `updated_at`, `home_status`, `priority`) VALUES
(2, 'Women\'s Clothing', 'womens-clothing', '2023-11-03-65457afa718f7.png', 0, 0, '2023-11-03 22:58:02', '2023-11-03 22:58:02', 1, 0),
(3, 'Men\'s Clothing', 'mens-clothing', '2023-11-03-65457bc536de7.png', 0, 0, '2023-11-03 23:01:25', '2023-11-03 23:01:25', 1, 1),
(4, 'Shoes', 'shoes', '2023-12-21-658499fc29f76.webp', 0, 0, '2023-11-03 23:08:24', '2024-01-16 21:27:16', 1, 4),
(5, 'Beauty & Health', 'beauty-health', '2023-11-03-65457dc979375.png', 0, 0, '2023-11-03 23:10:01', '2023-11-03 23:10:06', 1, 3),
(6, 'Children\'s clothing', 'childrens-clothing', '2023-11-03-65457e3d8ad37.png', 0, 0, '2023-11-03 23:11:57', '2023-12-22 00:44:33', 1, 4),
(7, 'Toys & Games', 'toys-games', '2023-11-03-65457e94c17d8.png', 0, 0, '2023-11-03 23:13:24', '2023-11-09 17:24:03', 1, 5),
(8, 'Furniture', 'furniture', '2023-11-03-65457ee14f1f4.png', 0, 0, '2023-11-03 23:14:41', '2023-11-03 23:17:00', 1, 6),
(9, 'Jewelry, Watches & Accessories', 'jewelry-watches-accessories', '2023-11-03-65457f2e872be.png', 0, 0, '2023-11-03 23:15:58', '2023-11-09 17:24:06', 1, 7),
(10, 'Automotive & Motorcycle', 'automotive-motorcycle', '2023-11-03-65457f641a125.png', 0, 0, '2023-11-03 23:16:52', '2023-11-09 17:24:08', 1, 8),
(11, 'Electronics', 'electronics', '2023-11-03-65457fc97f83f.png', 0, 0, '2023-11-03 23:18:33', '2023-11-09 17:24:09', 1, 9),
(14, 'Shirts', 'shirts', '2023-11-06-65493d0a6f655.png', 3, 1, '2023-11-04 13:11:00', '2023-11-06 19:38:08', 0, 0),
(15, 'Blazer & Suits', 'blazer-suits', '2023-11-04-654643174e7bc.png', 3, 1, '2023-11-04 13:11:51', '2023-11-06 19:28:50', 0, 1),
(16, 'Wedding  Dress', 'wedding-dress', '2023-11-04-65464360aaa89.png', 2, 1, '2023-11-04 13:13:04', '2023-11-05 17:14:50', 0, 0),
(17, 'Living Room Furniture', 'living-room-furniture', '2023-11-04-65469c70435e7.png', 8, 1, '2023-11-04 19:33:04', '2023-11-04 19:36:48', 0, 2),
(18, 'Living Room Chairs', 'living-room-chairs', NULL, 17, 2, '2023-11-04 19:37:39', '2023-11-04 19:37:39', 0, 0),
(19, 'Bottoms', 'bottoms', '2023-11-05-6547c98a857f8.png', 2, 1, '2023-11-05 16:57:46', '2023-11-05 16:57:46', 0, 1),
(20, 'pants', 'pants', NULL, 19, 2, '2023-11-05 17:00:41', '2023-11-05 17:00:41', 0, 0),
(21, 'short', 'short', NULL, 19, 2, '2023-11-05 17:01:53', '2023-11-05 17:01:53', 0, 1),
(22, 'skirt', 'skirt', NULL, 19, 2, '2023-11-05 17:02:59', '2023-11-05 17:02:59', 0, 2),
(23, 'jeans', 'jeans', NULL, 19, 2, '2023-11-05 17:03:40', '2023-11-05 17:03:40', 0, 3),
(24, 'wedding party dress', 'wedding-party-dress', NULL, 16, 2, '2023-11-05 17:16:16', '2023-11-05 17:16:16', 0, 0),
(25, 'wedding  dresses', 'wedding-dresses', NULL, 16, 2, '2023-11-05 17:18:03', '2023-11-05 17:18:03', 0, 1),
(26, 'Wedding Accessories', 'wedding-accessories', NULL, 16, 2, '2023-11-05 17:18:45', '2023-11-05 17:18:45', 0, 2),
(27, 'Bespoke Wedding Dress', 'bespoke-wedding-dress', NULL, 16, 2, '2023-11-05 17:20:04', '2023-11-05 17:20:04', 0, 3),
(28, 'Tops', 'tops', '2023-11-05-6547d0693071d.png', 2, 1, '2023-11-05 17:27:05', '2023-11-05 17:27:05', 0, 0),
(29, 'Shirts & Blouses', 'shirts-blouses', NULL, 28, 2, '2023-11-05 17:30:38', '2023-11-05 17:30:38', 0, 1),
(30, 'Knitwears', 'knitwears', NULL, 28, 2, '2023-11-05 17:32:26', '2023-11-05 17:32:26', 0, 2),
(31, 'Long Sleeve Tees', 'long-sleeve-tees', NULL, 28, 2, '2023-11-05 17:34:42', '2023-11-05 17:34:42', 0, 3),
(32, 'O-Neck Pullovers', 'o-neck-pullovers', NULL, 28, 2, '2023-11-05 17:37:35', '2023-11-05 17:37:35', 0, 4),
(33, 'Dresses', 'dresses', '2023-11-06-65493c077aa78.png', 2, 1, '2023-11-06 12:43:32', '2023-11-06 19:18:31', 0, 0),
(34, 'Long Dresses', 'long-dresses', NULL, 33, 2, '2023-11-06 12:45:08', '2023-11-06 12:45:08', 0, 0),
(35, 'Short dresses', 'short-dresses', NULL, 33, 2, '2023-11-06 12:48:00', '2023-11-06 12:48:00', 0, 1),
(36, 'Party dresses', 'party-dresses', NULL, 33, 2, '2023-11-06 12:50:02', '2023-11-06 12:50:02', 0, 2),
(37, 'Midi dresses', 'midi-dresses', NULL, 33, 2, '2023-11-06 12:52:25', '2023-11-06 12:52:25', 0, 3),
(42, 'Pants', 'pants', '2023-11-06-65493faad3e5f.png', 3, 1, '2023-11-06 19:34:02', '2023-11-06 19:34:02', 0, 2),
(43, 'Jackets', 'jackets', '2023-11-06-65494035e8ee8.png', 3, 1, '2023-11-06 19:36:21', '2023-11-06 19:36:21', 0, 3),
(44, 'Cotton Shirt', 'cotton-shirt', NULL, 14, 2, '2023-11-06 19:40:12', '2023-11-06 19:40:12', 0, 0),
(45, 'Shirt Jacket', 'shirt-jacket', NULL, 14, 2, '2023-11-06 19:40:54', '2023-11-06 19:40:54', 0, 1),
(46, 'Printed Shirt', 'printed-shirt', NULL, 14, 2, '2023-11-06 19:41:26', '2023-11-06 19:41:26', 0, 2),
(47, 'Plain Shirt', 'plain-shirt', NULL, 14, 2, '2023-11-06 19:42:10', '2023-11-06 19:42:10', 0, 3),
(48, 'Suit Jackets', 'suit-jackets', NULL, 15, 2, '2023-11-06 19:42:56', '2023-11-06 19:42:56', 0, 0),
(49, 'Suits', 'suits', NULL, 15, 2, '2023-11-06 19:44:49', '2023-11-06 19:44:49', 0, 1),
(51, 'Suit Pants', 'suit-pants', NULL, 15, 2, '2023-11-06 19:47:38', '2023-11-06 19:47:38', 0, 3),
(52, 'Leather Pants', 'leather-pants', NULL, 42, 2, '2023-11-06 19:50:10', '2023-11-06 19:50:10', 0, 0),
(53, 'Pencil Pants', 'pencil-pants', NULL, 42, 2, '2023-11-06 19:51:21', '2023-11-06 19:51:21', 0, 1),
(54, 'Casual Pants', 'casual-pants', NULL, 42, 2, '2023-11-06 19:52:04', '2023-11-06 19:52:04', 0, 2),
(55, 'Straight Pants', 'straight-pants', NULL, 42, 2, '2023-11-06 19:52:50', '2023-11-06 19:52:50', 0, 3),
(56, 'Leather Coat', 'leather-coat', NULL, 43, 2, '2023-11-06 19:54:15', '2023-11-06 19:54:15', 0, 0),
(57, 'Baseball Uniform', 'baseball-uniform', NULL, 43, 2, '2023-11-06 19:55:06', '2023-11-06 19:55:06', 0, 1),
(58, 'Vest', 'vest', NULL, 43, 2, '2023-11-06 19:56:25', '2023-11-06 19:56:25', 0, 2),
(59, 'Trench', 'trench', NULL, 43, 2, '2023-11-06 19:57:57', '2023-11-06 19:57:57', 0, 3),
(62, 'Bedroom Furniture', 'bedroom-furniture', '2023-11-06-65494872d07a9.png', 8, 1, '2023-11-06 20:11:30', '2023-11-06 20:11:30', 0, 1),
(63, 'Office Furniture', 'office-furniture', '2023-11-06-654948f2de9cb.png', 8, 1, '2023-11-06 20:13:38', '2023-11-06 20:13:38', 0, 4),
(64, 'Outdoor Furniture', 'outdoor-furniture', '2023-11-06-654949717b0a6.png', 8, 1, '2023-11-06 20:15:45', '2023-11-06 20:15:45', 0, 5),
(65, 'Living Room Sofas', 'living-room-sofas', NULL, 17, 2, '2023-11-06 20:17:22', '2023-11-06 20:17:22', 0, 1),
(66, 'Living Room Cabinets', 'living-room-cabinets', NULL, 17, 2, '2023-11-06 20:18:17', '2023-11-06 20:18:17', 0, 2),
(67, 'Open Closets', 'open-closets', NULL, 62, 2, '2023-11-06 20:20:53', '2023-11-06 20:20:53', 0, 0),
(68, 'Headboards', 'headboards', NULL, 62, 2, '2023-11-06 20:22:21', '2023-11-06 20:22:21', 0, 1),
(69, 'Nightstands', 'nightstands', NULL, 62, 2, '2023-11-06 20:23:08', '2023-11-06 20:23:08', 0, 2),
(70, 'Filing Cabinets', 'filing-cabinets', NULL, 63, 2, '2023-11-06 20:24:06', '2023-11-06 20:24:06', 0, 0),
(71, 'Computer Desks', 'computer-desks', NULL, 63, 2, '2023-11-06 20:24:49', '2023-11-06 20:24:49', 0, 1),
(72, 'Office Chairs', 'office-chairs', NULL, 63, 2, '2023-11-06 20:25:44', '2023-11-06 20:25:44', 0, 2),
(73, 'Garden Furniture Sets', 'garden-furniture-sets', NULL, 64, 2, '2023-11-06 20:26:44', '2023-11-06 20:26:44', 0, 0),
(74, 'Beach Chairs', 'beach-chairs', NULL, 64, 2, '2023-11-06 20:27:44', '2023-11-06 20:27:44', 0, 1),
(75, 'Hammocks', 'hammocks', NULL, 64, 2, '2023-11-06 20:28:51', '2023-11-06 20:28:51', 0, 2),
(76, 'Handbags', 'handbags', '2023-11-07-6549f2c4c44d3.png', 259, 1, '2023-11-07 11:18:12', '2023-11-07 11:18:12', 0, 0),
(77, 'Wallet & ID Holder', 'wallet-id-holder', '2023-11-07-6549f3138af86.png', 259, 1, '2023-11-07 11:19:31', '2023-11-07 11:19:31', 0, 1),
(78, 'Travel Bags & Luggage', 'travel-bags-luggage', '2023-11-07-6549f37091b3c.png', 259, 1, '2023-11-07 11:21:04', '2023-11-07 11:21:04', 0, 2),
(80, 'Bucket Bag', 'bucket-bag', NULL, 76, 2, '2023-11-07 11:24:07', '2023-11-07 11:24:07', 0, 0),
(81, 'Square Bag', 'square-bag', NULL, 76, 2, '2023-11-07 11:25:13', '2023-11-07 11:25:13', 0, 1),
(82, 'Messenger Bag', 'messenger-bag', NULL, 76, 2, '2023-11-07 11:26:08', '2023-11-07 11:26:08', 0, 2),
(83, 'Mens Wallet with Zipper', 'mens-wallet-with-zipper', NULL, 77, 2, '2023-11-07 11:27:02', '2023-11-07 11:27:02', 0, 0),
(84, 'Travel Wallets', 'travel-wallets', NULL, 77, 2, '2023-11-07 11:27:50', '2023-11-07 11:27:50', 0, 1),
(85, 'Women\'s Fold Wallet', 'womens-fold-wallet', NULL, 77, 2, '2023-11-07 11:28:50', '2023-11-07 11:28:50', 0, 2),
(86, 'Travel Bag', 'travel-bag', NULL, 78, 2, '2023-11-07 11:29:44', '2023-11-07 11:29:44', 0, 0),
(87, 'Large Size Luggage', 'large-size-luggage', NULL, 78, 2, '2023-11-07 11:30:29', '2023-11-07 11:30:29', 0, 1),
(88, 'Middle Size Luggage', 'middle-size-luggage', NULL, 78, 2, '2023-11-07 11:31:05', '2023-11-07 11:31:05', 0, 2),
(89, 'Women\'s Casual shoes', 'womens-casual-shoes', NULL, 237, 2, '2023-11-07 11:32:22', '2023-11-07 11:32:22', 0, 0),
(90, 'men\'s Casual shoes', 'mens-casual-shoes', NULL, 237, 2, '2023-11-07 11:33:11', '2023-11-07 11:33:11', 0, 1),
(93, 'Massage & Relaxation', 'massage-relaxation', '2023-11-07-6549f71d8aa52.png', 5, 1, '2023-11-07 11:36:45', '2023-11-07 11:36:45', 0, 0),
(94, 'Nail art', 'nail-art', '2023-11-17-655764dd13ab2.webp', 5, 1, '2023-11-07 11:39:22', '2023-12-01 16:58:13', 0, 1),
(95, 'Dental Supplies', 'dental-supplies', '2023-11-07-6549f828b5fd9.png', 5, 1, '2023-11-07 11:41:12', '2023-11-07 11:41:12', 0, 2),
(96, 'Relaxation Treatment', 'relaxation-treatment', NULL, 93, 2, '2023-11-07 11:43:25', '2023-11-07 11:43:25', 0, 0),
(97, 'Eye Massage Instrument', 'eye-massage-instrument', NULL, 93, 2, '2023-11-07 11:44:52', '2023-11-07 11:44:52', 0, 1),
(98, 'Massage Roller', 'massage-roller', NULL, 93, 2, '2023-11-07 11:45:28', '2023-11-07 11:45:28', 0, 2),
(100, 'nail art', 'nail-art', NULL, 94, 2, '2023-11-07 11:47:22', '2023-11-17 17:01:34', 0, 1),
(101, 'Nail Sets & Kits', 'nail-sets-kits', NULL, 94, 2, '2023-11-07 11:48:11', '2023-11-17 17:00:06', 0, 2),
(102, 'Teeth Whitening Instrument', 'teeth-whitening-instrument', NULL, 95, 2, '2023-11-07 11:49:21', '2023-11-07 11:49:21', 0, 0),
(103, 'Dental Chair Cover', 'dental-chair-cover', NULL, 95, 2, '2023-11-07 11:50:01', '2023-11-07 11:50:01', 0, 1),
(105, 'Kids\' Clothing', 'kids-clothing', '2023-11-07-654a02e6d9551.png', 6, 1, '2023-11-07 12:27:02', '2023-11-07 12:27:02', 0, 0),
(106, 'Feeding', 'feeding', '2023-11-07-654a034259b57.png', 6, 1, '2023-11-07 12:28:34', '2023-11-07 12:28:34', 0, 1),
(107, 'Baby Clothing', 'baby-clothing', '2023-11-07-654a041e4c9fb.png', 6, 1, '2023-11-07 12:32:14', '2023-11-07 12:32:14', 0, 1),
(108, 'Baby Care', 'baby-care', '2023-11-07-654a048997c84.png', 6, 1, '2023-11-07 12:34:01', '2023-11-07 12:34:01', 0, 2),
(109, 'Kids Canvas Shoe', 'kids-canvas-shoe', NULL, 105, 2, '2023-11-07 12:36:14', '2023-11-07 12:36:14', 0, 0),
(110, 'Polo Shirts', 'polo-shirts', NULL, 105, 2, '2023-11-07 12:37:53', '2023-11-07 12:37:53', 0, 1),
(111, 'Outerwear', 'outerwear', NULL, 105, 2, '2023-11-07 12:38:41', '2023-11-07 12:38:41', 0, 2),
(112, 'Baby Food Mills', 'baby-food-mills', NULL, 106, 2, '2023-11-07 12:39:38', '2023-11-07 12:39:38', 0, 0),
(113, 'Cups', 'cups', NULL, 106, 2, '2023-11-07 12:40:49', '2023-11-07 12:40:49', 0, 1),
(114, 'Bottles', 'bottles', NULL, 106, 2, '2023-11-07 12:41:31', '2023-11-07 12:41:31', 0, 2),
(115, 'Baby Bottoms', 'baby-bottoms', NULL, 107, 2, '2023-11-07 12:43:04', '2023-11-07 12:43:04', 0, 0),
(116, 'Baby Swimwear', 'baby-swimwear', NULL, 107, 2, '2023-11-07 12:44:53', '2023-11-07 12:44:53', 0, 1),
(117, 'Baby Tops', 'baby-tops', NULL, 107, 2, '2023-11-07 12:45:50', '2023-11-07 12:45:50', 0, 2),
(118, 'Baby Wet Wipes', 'baby-wet-wipes', NULL, 108, 2, '2023-11-07 12:46:56', '2023-11-07 12:46:56', 0, 0),
(119, 'Baby Care Tools', 'baby-care-tools', NULL, 108, 2, '2023-11-07 12:47:26', '2023-11-07 12:47:26', 0, 1),
(120, 'Hair Care', 'hair-care', NULL, 108, 2, '2023-11-07 12:48:03', '2023-11-07 12:48:03', 0, 2),
(121, 'Kids Gifts', 'kids-gifts', '2023-11-07-654a0936a721a.png', 7, 1, '2023-11-07 12:52:02', '2023-11-07 12:53:58', 0, 0),
(122, 'Learning & Education', 'learning-education', '2023-11-07-654a0917634ff.png', 7, 1, '2023-11-07 12:53:27', '2023-11-07 12:53:27', 0, 1),
(123, 'Dolls & Accessories', 'dolls-accessories', '2023-11-07-654a097ee3049.png', 7, 1, '2023-11-07 12:55:10', '2023-11-07 12:55:10', 0, 2),
(124, 'Food & Beverage', 'food-beverage', '2023-11-07-654a09c85da9a.png', 0, 0, '2023-11-07 12:56:24', '2023-12-26 16:39:49', 1, 8),
(125, 'Magic Tricks', 'magic-tricks', NULL, 121, 2, '2023-11-07 13:20:10', '2023-11-07 13:20:10', 0, 0),
(126, 'Craft Toys', 'craft-toys', NULL, 121, 2, '2023-11-07 13:20:50', '2023-11-07 13:20:50', 0, 1),
(127, 'Stamps Toys', 'stamps-toys', NULL, 121, 2, '2023-11-07 13:21:26', '2023-11-07 13:21:26', 0, 2),
(128, 'Drawing Toys', 'drawing-toys', NULL, 122, 2, '2023-11-07 13:22:07', '2023-11-07 13:22:07', 0, 0),
(129, 'Math Toys', 'math-toys', NULL, 122, 2, '2023-11-07 13:22:40', '2023-11-07 13:22:40', 0, 1),
(130, 'Puzzles', 'puzzles', NULL, 122, 2, '2023-11-07 13:23:14', '2023-11-07 13:23:14', 0, 2),
(131, 'Dolls', 'dolls', NULL, 123, 2, '2023-11-07 13:24:10', '2023-11-07 13:24:10', 0, 0),
(132, 'Doll Houses', 'doll-houses', NULL, 123, 2, '2023-11-07 13:24:45', '2023-11-07 13:24:45', 0, 1),
(133, 'Dolls Accessories', 'dolls-accessories', NULL, 123, 2, '2023-11-07 13:25:15', '2023-11-07 13:25:15', 0, 2),
(134, 'Body Jewelry', 'body-jewelry', '2023-11-08-654b3a6e32573.png', 9, 1, '2023-11-08 10:36:14', '2023-11-08 10:36:14', 0, 0),
(135, 'Necklaces', 'necklaces', '2023-11-08-654b3ad1e22a5.png', 9, 1, '2023-11-08 10:37:53', '2023-11-08 10:37:53', 0, 1),
(136, 'Watches', 'watches', '2023-11-08-654b3b6408876.png', 9, 1, '2023-11-08 10:40:20', '2023-11-08 10:40:20', 0, 2),
(137, 'Ear Piercing', 'ear-piercing', NULL, 134, 2, '2023-11-08 10:41:52', '2023-11-08 10:41:52', 0, 0),
(138, 'Dental Grill', 'dental-grill', NULL, 134, 2, '2023-11-08 10:42:53', '2023-11-08 10:42:53', 0, 1),
(139, 'Nose Nail', 'nose-nail', NULL, 134, 2, '2023-11-08 10:43:27', '2023-11-08 10:43:27', 0, 2),
(140, 'Women\'s Necklace', 'womens-necklace', NULL, 135, 2, '2023-11-08 10:44:28', '2023-11-08 10:44:28', 0, 0),
(141, 'Men\'s Necklace', 'mens-necklace', NULL, 135, 2, '2023-11-08 10:45:14', '2023-11-08 10:45:14', 0, 1),
(142, 'Silver Necklace', 'silver-necklace', NULL, 135, 2, '2023-11-08 10:45:57', '2023-11-08 10:45:57', 0, 2),
(143, 'Digital Watches', 'digital-watches', NULL, 136, 2, '2023-11-08 10:47:00', '2023-11-08 10:47:00', 0, 0),
(144, 'mechanical watches', 'mechanical-watches', NULL, 136, 2, '2023-11-08 10:47:52', '2023-11-08 10:47:52', 0, 1),
(145, 'Watchbands', 'watchbands', NULL, 136, 2, '2023-11-08 10:48:43', '2023-11-08 10:48:43', 0, 2),
(146, 'Interior Accessories', 'interior-accessories', '2023-11-08-654b3e0e54cd5.png', 10, 1, '2023-11-08 10:51:42', '2023-11-08 10:51:42', 0, 0),
(147, 'Exterior Accessories', 'exterior-accessories', '2023-11-08-654b3e499ea2c.png', 10, 1, '2023-11-08 10:52:41', '2023-11-08 10:52:41', 0, 1),
(148, 'Car Repair Tools', 'car-repair-tools', '2023-11-08-654b3e9fc8a67.png', 10, 1, '2023-11-08 10:54:07', '2023-11-08 10:54:07', 0, 2),
(149, 'Motorcycle Parts', 'motorcycle-parts', '2023-11-08-654b3f219177e.png', 10, 1, '2023-11-08 10:56:17', '2023-11-08 10:56:17', 0, 3),
(150, 'Car Seat Covers', 'car-seat-covers', NULL, 146, 2, '2023-11-08 10:57:53', '2023-11-08 10:57:53', 0, 0),
(151, 'GPS Accessories', 'gps-accessories', NULL, 146, 2, '2023-11-08 10:58:51', '2023-11-08 10:58:51', 0, 1),
(152, 'Accessories', 'accessories', NULL, 146, 2, '2023-11-08 10:59:29', '2023-11-08 10:59:29', 0, 2),
(153, 'Car Covers', 'car-covers', NULL, 147, 2, '2023-11-08 11:00:11', '2023-11-08 11:00:11', 0, 0),
(154, 'Car Stickers', 'car-stickers', NULL, 147, 2, '2023-11-08 11:00:53', '2023-11-08 11:00:53', 0, 1),
(155, 'Accessories', 'accessories', NULL, 147, 2, '2023-11-08 11:01:24', '2023-11-08 11:01:24', 0, 2),
(156, 'Inspection Tools', 'inspection-tools', NULL, 148, 2, '2023-11-08 11:02:47', '2023-11-08 11:02:47', 0, 0),
(157, 'Tire Repair Tools', 'tire-repair-tools', NULL, 148, 2, '2023-11-08 11:03:45', '2023-11-08 11:03:45', 0, 1),
(158, 'Diagnostic Tools', 'diagnostic-tools', NULL, 148, 2, '2023-11-08 11:04:59', '2023-11-08 11:04:59', 0, 2),
(159, 'Engine Parts', 'engine-parts', NULL, 149, 2, '2023-11-08 11:05:48', '2023-11-08 11:05:48', 0, 0),
(160, 'Body & Frames', 'body-frames', NULL, 149, 2, '2023-11-08 11:07:03', '2023-11-08 11:07:03', 0, 1),
(161, 'Electrical & Ignitions', 'electrical-ignitions', NULL, 149, 2, '2023-11-08 11:07:47', '2023-11-08 11:07:47', 0, 2),
(164, 'Computer components', 'computer-components', '2023-11-10-654e274fefc8b.webp', 11, 1, '2023-11-10 15:51:27', '2023-12-01 15:59:13', 0, 0),
(165, 'Tablets and accessories', 'tablets-and-accessories', '2023-11-10-654e27dad4473.webp', 11, 1, '2023-11-10 15:53:46', '2023-11-10 15:53:46', 0, 1),
(166, 'Smart phone', 'smart-phone', '2023-11-10-654e282a8a8bd.webp', 11, 1, '2023-11-10 15:55:06', '2023-12-01 15:57:48', 0, 2),
(167, 'Laptop', 'laptop', '2023-11-10-654e289951878.webp', 11, 1, '2023-11-10 15:56:57', '2023-11-10 15:56:57', 0, 3),
(168, 'Graphics Cards', 'graphics-cards', NULL, 164, 2, '2023-11-10 16:00:55', '2023-11-11 00:47:25', 0, 0),
(169, 'Advanced Storage & Ram', 'advanced-storage-ram', NULL, 164, 2, '2023-11-10 16:03:01', '2023-11-11 00:48:14', 0, 1),
(170, 'Gaming Motherboard', 'gaming-motherboard', NULL, 164, 2, '2023-11-10 16:04:01', '2023-11-10 16:04:01', 0, 2),
(171, 'PC Power Supplies', 'pc-power-supplies', NULL, 164, 2, '2023-11-10 16:05:45', '2023-11-10 16:05:45', 0, 3),
(172, 'Drawing Tablet', 'drawing-tablet', NULL, 165, 2, '2023-11-10 16:08:08', '2023-11-10 16:08:08', 0, 0),
(173, 'Digital Cameras', 'digital-cameras', NULL, 165, 2, '2023-11-10 16:09:50', '2023-11-10 16:09:50', 0, 1),
(174, 'Wheels & Flight Joysticks', 'wheels-flight-joysticks', NULL, 165, 2, '2023-11-10 16:10:55', '2023-11-10 16:10:55', 0, 2),
(175, 'Bags', 'bags', NULL, 165, 2, '2023-11-10 16:13:47', '2023-11-10 16:13:47', 0, 3),
(176, 'Smartphones', 'smartphones', NULL, 166, 2, '2023-11-10 16:15:13', '2023-11-10 16:15:13', 0, 0),
(177, 'Phone Cases', 'phone-cases', NULL, 166, 2, '2023-11-10 16:16:29', '2023-11-10 16:16:29', 0, 1),
(178, 'Mobile Phone Chargers', 'mobile-phone-chargers', NULL, 166, 2, '2023-11-10 16:17:29', '2023-11-10 16:17:29', 0, 2),
(179, 'Phone Repair Tools', 'phone-repair-tools', NULL, 166, 2, '2023-11-10 16:18:07', '2023-11-10 16:18:07', 0, 3),
(180, 'Laptop', 'laptop', NULL, 167, 2, '2023-11-10 16:19:36', '2023-11-10 16:19:36', 0, 0),
(181, 'Laptop macbook', 'laptop-macbook', NULL, 167, 2, '2023-11-10 16:20:41', '2023-11-10 16:20:41', 0, 1),
(182, 'Laptop accessories', 'laptop-accessories', NULL, 167, 2, '2023-11-10 16:21:16', '2023-11-10 16:21:16', 0, 2),
(183, 'Jackets', 'jackets', '2023-11-13-6551d4f35c504.webp', 2, 1, '2023-11-13 10:49:07', '2023-12-01 15:44:56', 0, 4),
(184, 'one piece', 'one-piece', '2023-11-13-6551d52221882.webp', 2, 1, '2023-11-13 10:49:54', '2023-11-13 10:49:54', 0, 5),
(185, 'Jeans', 'jeans', '2023-11-13-6551d596d2ee2.webp', 3, 1, '2023-11-13 10:51:50', '2023-12-01 15:44:30', 0, 4),
(186, 'Gym clothes', 'gym-clothes', '2023-11-13-6551d61601e01.webp', 3, 1, '2023-11-13 10:53:58', '2023-12-01 15:43:46', 0, 5),
(187, 'Women\'s wallet', 'womens-wallet', '2023-11-13-6551d7daddd0c.webp', 259, 1, '2023-11-13 11:01:30', '2023-12-01 15:43:17', 0, 4),
(188, 'Backpack', 'backpack', '2023-11-13-6551d81ca228b.webp', 259, 1, '2023-11-13 11:02:36', '2023-12-01 15:42:40', 0, 5),
(189, 'Fascia gun', 'fascia-gun', '2023-11-13-6551d8b9b2aaf.webp', 5, 1, '2023-11-13 11:05:13', '2023-11-13 11:05:13', 0, 3),
(190, 'Make-up', 'make-up', '2023-11-17-655763e3869cf.webp', 5, 1, '2023-11-13 11:06:28', '2023-12-01 15:41:37', 0, 4),
(191, 'Skin Care', 'skin-care', '2023-11-17-65576284b3310.webp', 5, 1, '2023-11-13 11:07:33', '2023-11-17 15:54:28', 0, 5),
(192, 'Baby Shoes', 'baby-shoes', '2023-11-17-655796b957b86.webp', 4, 1, '2023-11-13 11:10:35', '2023-11-17 19:37:13', 0, 4),
(193, 'Activity & Gear', 'activity-gear', '2023-11-17-6557bc4ac5a02.webp', 6, 1, '2023-11-13 11:12:23', '2023-11-17 22:17:30', 0, 5),
(194, 'Stuffed Animals', 'stuffed-animals', '2023-11-13-6551dae25e803.webp', 7, 1, '2023-11-13 11:14:26', '2023-11-15 12:20:11', 0, 3),
(195, 'Action Games', 'action-games', '2023-11-13-6551db14d98d5.webp', 7, 1, '2023-11-13 11:15:16', '2023-12-01 15:38:35', 0, 4),
(196, 'Beach sand toys', 'beach-sand-toys', '2023-11-13-6551db4b8e0c7.webp', 7, 1, '2023-11-13 11:16:11', '2023-11-13 11:16:11', 0, 5),
(197, 'Tables', 'tables', '2023-11-13-6551dbcdf1d8c.webp', 8, 1, '2023-11-13 11:18:21', '2023-11-13 11:18:21', 0, 4),
(198, 'Umbrellas', 'umbrellas', '2023-11-13-6551dc1aacb1f.webp', 8, 1, '2023-11-13 11:19:38', '2023-12-01 15:36:36', 0, 5),
(199, 'silver', 'silver', '2023-11-13-6551dc6cdda7e.webp', 9, 1, '2023-11-13 11:21:00', '2023-11-13 11:21:00', 0, 3),
(200, 'Gold earrings', 'gold-earrings', '2023-11-13-6551dcb5eb767.webp', 9, 1, '2023-11-13 11:22:13', '2023-12-01 15:34:08', 0, 4),
(201, 'Sunglasses', 'sunglasses', '2023-11-18-6558a6466ed3e.webp', 9, 1, '2023-11-13 11:23:23', '2023-11-18 14:55:50', 0, 5),
(202, 'computer chips', 'computer-chips', '2023-11-13-6551dda36fa94.webp', 10, 1, '2023-11-13 11:26:11', '2023-11-13 11:26:11', 0, 4),
(203, 'car stickers', 'car-stickers', '2023-11-13-6551ddefeace5.webp', 10, 1, '2023-11-13 11:27:27', '2023-11-13 11:27:27', 0, 5),
(204, 'Batteries', 'batteries', '2023-11-13-6551df27b91da.webp', 11, 1, '2023-11-13 11:32:39', '2023-11-13 11:32:39', 0, 4),
(205, 'Smart home', 'smart-home', '2023-11-13-6551df69b82f5.webp', 11, 1, '2023-11-13 11:33:45', '2023-11-13 11:33:45', 0, 5),
(206, 'Foods', 'foods', '2023-11-13-6551e28817c32.webp', 124, 1, '2023-11-13 11:47:04', '2023-11-13 11:47:04', 0, 0),
(207, 'beverages', 'beverages', '2023-11-13-6551e2ffad4a1.webp', 124, 1, '2023-11-13 11:49:03', '2023-11-13 11:52:16', 0, 1),
(208, 'Fruits & vegetables', 'fruits-vegetables', '2023-11-13-6551e3712f137.webp', 124, 1, '2023-11-13 11:50:57', '2023-11-13 11:50:57', 0, 2),
(209, 'snacks', 'snacks', '2023-11-13-6551e418b826d.webp', 124, 1, '2023-11-13 11:53:44', '2023-11-13 11:53:44', 0, 2),
(210, 'milk & dairy', 'milk-dairy', '2023-11-13-6551e474dd988.webp', 124, 1, '2023-11-13 11:55:16', '2023-11-13 11:55:16', 0, 4),
(211, 'Breakfast', 'breakfast', '2023-11-13-6551e4af85208.webp', 124, 1, '2023-11-13 11:56:15', '2023-12-01 00:19:31', 0, 5),
(212, 'Fascia gun', 'fascia-gun', NULL, 189, 2, '2023-11-14 22:54:39', '2023-11-14 22:54:39', 0, 0),
(213, 'Tabel', 'tabel', NULL, 197, 2, '2023-11-15 00:14:29', '2023-11-15 00:14:29', 0, 4),
(214, 'Meat', 'meat', NULL, 206, 2, '2023-11-15 00:16:12', '2023-11-15 00:16:12', 0, 0),
(215, 'chickens', 'chickens', NULL, 206, 2, '2023-11-15 00:18:42', '2023-11-15 00:18:42', 0, 1),
(216, 'soup', 'soup', NULL, 206, 2, '2023-11-15 00:22:14', '2023-11-15 00:22:14', 0, 2),
(217, 'water', 'water', NULL, 207, 2, '2023-11-15 00:23:37', '2023-11-15 00:23:37', 0, 0),
(218, 'soda', 'soda', NULL, 207, 2, '2023-11-15 00:24:26', '2023-11-15 00:24:26', 0, 1),
(219, 'juice', 'juice', NULL, 207, 2, '2023-11-15 00:25:42', '2023-11-15 00:25:42', 0, 2),
(220, 'fruits', 'fruits', NULL, 208, 2, '2023-11-15 00:26:43', '2023-11-15 00:26:43', 0, 0),
(221, 'vegetables', 'vegetables', NULL, 208, 2, '2023-11-15 00:27:17', '2023-11-15 00:27:17', 0, 1),
(222, 'chips', 'chips', NULL, 209, 2, '2023-11-15 00:28:35', '2023-11-15 00:28:35', 0, 0),
(223, 'nuts', 'nuts', NULL, 209, 2, '2023-11-15 00:29:11', '2023-11-15 00:29:11', 0, 1),
(224, 'biscuits', 'biscuits', NULL, 209, 2, '2023-11-15 00:30:17', '2023-11-15 00:30:17', 0, 2),
(225, 'Milk', 'milk', NULL, 210, 2, '2023-11-15 00:31:26', '2023-11-15 00:31:26', 0, 0),
(226, 'Cheese', 'cheese', NULL, 210, 2, '2023-11-15 00:32:09', '2023-11-15 00:32:09', 0, 1),
(227, 'Yogurt', 'yogurt', NULL, 210, 2, '2023-11-15 00:32:55', '2023-11-15 00:32:55', 0, 2),
(228, 'Eggs', 'eggs', NULL, 211, 2, '2023-11-15 00:33:52', '2023-11-15 00:33:52', 0, 1),
(229, 'Bakery', 'bakery', NULL, 211, 2, '2023-11-15 00:34:47', '2023-11-15 00:34:47', 0, 1),
(230, 'Olives', 'olives', NULL, 211, 2, '2023-11-15 00:36:23', '2023-11-15 00:36:23', 0, 2),
(231, 'Movies & Plush Animals', 'movies-plush-animals', NULL, 194, 2, '2023-11-15 12:21:35', '2023-11-15 12:27:31', 0, 4),
(232, 'Plush Backpacks', 'plush-backpacks', NULL, 194, 2, '2023-11-15 12:25:41', '2023-11-15 12:25:41', 0, 3),
(233, 'Dentist set', 'dentist-set', NULL, 95, 2, '2023-11-17 15:36:37', '2023-11-17 15:36:37', 0, 2),
(234, 'Makeup Brushes & Tools', 'makeup-brushes-tools', NULL, 190, 2, '2023-11-17 19:14:59', '2023-11-17 19:14:59', 0, 1),
(235, 'Face and Eyes', 'face-and-eyes', NULL, 190, 2, '2023-11-17 19:17:35', '2023-11-17 19:17:35', 0, 2),
(236, 'Lips', 'lips', NULL, 190, 2, '2023-11-17 19:18:27', '2023-11-17 19:18:27', 0, 3),
(237, 'Casual Shoes', 'casual-shoes', '2024-01-16-65a5c14c9511c.webp', 4, 1, '2023-11-17 19:38:40', '2024-01-16 02:35:40', 0, 0),
(238, 'Sandals', 'sandals', NULL, 192, 2, '2023-11-17 19:40:20', '2023-11-17 19:40:20', 0, 2),
(239, 'Backpacks & Carriers', 'backpacks-carriers', NULL, 193, 2, '2023-11-17 19:44:13', '2023-11-17 22:19:29', 0, 0),
(240, 'Play Mats', 'play-mats', NULL, 193, 2, '2023-11-17 19:45:07', '2023-11-17 22:20:48', 0, 1),
(241, 'Women\'s Sunglasses', 'womens-sunglasses', NULL, 201, 2, '2023-11-18 14:57:02', '2023-11-18 14:57:02', 0, 0),
(242, 'Men\'s Sunglasses', 'mens-sunglasses', NULL, 201, 2, '2023-11-18 14:57:52', '2023-11-18 14:57:52', 0, 1),
(243, 'Children\'s Glasses', 'childrens-glasses', NULL, 201, 2, '2023-11-18 14:58:38', '2023-11-18 14:58:38', 0, 2),
(244, 'Machinery and Equipment', 'machinery-and-equipment', '2023-12-04-656df489af935.webp', 0, 0, '2023-12-04 18:23:47', '2023-12-25 22:13:04', 0, 10),
(245, 'Perfumes and Gift', 'perfumes-and-gift', '2023-12-07-6571c6a6eaae3.webp', 0, 0, '2023-12-07 16:20:38', '2023-12-21 23:54:15', 0, 10),
(246, 'Agricultural', 'agricultural', '2023-12-14-657af2d711bac.webp', 0, 0, '2023-12-14 15:18:02', '2023-12-14 16:56:12', 0, 10),
(247, 'Apparel', 'apparel', '2023-12-14-657af2b11538e.webp', 0, 0, '2023-12-14 15:18:57', '2023-12-14 16:55:52', 0, 10),
(248, 'Beauty & Personal Care', 'beauty-personal-care', '2023-12-14-657af338ac5df.webp', 0, 0, '2023-12-14 15:21:12', '2023-12-14 16:55:20', 0, 10),
(249, 'Chemicals', 'chemicals', '2023-12-14-657af39ab5c68.webp', 0, 0, '2023-12-14 15:22:50', '2023-12-14 16:55:17', 0, 10),
(250, 'Construction', 'construction', '2023-12-14-657af3e7514bf.webp', 0, 0, '2023-12-14 15:24:07', '2023-12-14 16:55:14', 0, 10),
(251, 'Consumer Electronics', 'consumer-electronics', '2023-12-14-657af43393f8e.webp', 0, 0, '2023-12-14 15:25:23', '2023-12-14 16:55:10', 0, 10),
(252, 'Electrical Equipment & Supplies', 'electrical-equipment-supplies', '2023-12-14-657af4ca1c07c.webp', 0, 0, '2023-12-14 15:27:54', '2023-12-14 16:55:07', 0, 10),
(253, 'Energy', 'energy', '2023-12-14-657af5496cafc.webp', 0, 0, '2023-12-14 15:30:01', '2023-12-14 16:55:04', 0, 10),
(254, 'Fabrication Services', 'fabrication-services', '2023-12-14-657af5ace4b96.webp', 0, 0, '2023-12-14 15:31:40', '2023-12-14 16:55:01', 0, 10),
(255, 'Fashion Accessories', 'fashion-accessories', '2023-12-14-657af5ec87d9a.webp', 0, 0, '2023-12-14 15:32:44', '2023-12-14 16:54:58', 0, 10),
(256, 'Health & Medical', 'health-medical', '2023-12-14-657b005dcc4b7.webp', 0, 0, '2023-12-14 16:17:17', '2023-12-14 16:17:17', 0, 10),
(257, 'Household items', 'household-items', '2023-12-21-6584a0c77cc75.webp', 0, 0, '2023-12-21 23:32:07', '2023-12-21 23:54:04', 0, 10),
(258, 'Textile & Leather Products', 'textile-leather-products', '2023-12-21-6584a5e37b344.webp', 0, 0, '2023-12-21 23:53:55', '2023-12-26 16:39:00', 0, 10),
(259, 'Bags', 'bags', '2023-12-22-6584ae03c6ba2.webp', 0, 0, '2023-12-22 00:28:35', '2024-01-12 00:41:10', 0, 9),
(260, 'Home & Garden', 'home-garden', '2023-12-26-658acd8f05043.webp', 0, 0, '2023-12-26 15:56:47', '2023-12-26 15:56:47', 0, 10),
(261, 'Lights & Lighting', 'lights-lighting', '2023-12-26-658ace5f1e977.webp', 0, 0, '2023-12-26 16:00:15', '2023-12-26 16:00:15', 0, 10),
(262, 'Minerals & Metallurgy', 'minerals-metallurgy', '2023-12-26-658aced516fd1.webp', 0, 0, '2023-12-26 16:02:13', '2023-12-26 16:02:13', 0, 10),
(263, 'Office & School Supplies', 'office-school-supplies', '2023-12-26-658acf7186b88.webp', 0, 0, '2023-12-26 16:04:49', '2023-12-26 16:04:49', 0, 10),
(264, 'Packaging & Printing', 'packaging-printing', '2023-12-26-658acfc0ab5e1.webp', 0, 0, '2023-12-26 16:06:08', '2023-12-26 16:06:08', 0, 10),
(265, 'Reduction & Recycling Products', 'reduction-recycling-products', '2023-12-26-658ad008ba3cf.webp', 0, 0, '2023-12-26 16:07:20', '2023-12-26 16:07:20', 0, 10),
(266, 'Rubber & Plastics', 'rubber-plastics', '2023-12-26-658ad08fbe48c.webp', 0, 0, '2023-12-26 16:09:35', '2023-12-26 16:09:35', 0, 10),
(267, 'Security & Protection', 'security-protection', '2023-12-26-658ad0e3837c7.webp', 0, 0, '2023-12-26 16:10:59', '2023-12-26 16:10:59', 0, 10),
(268, 'Service Equipment', 'service-equipment', '2023-12-26-658ad1412a1ec.webp', 0, 0, '2023-12-26 16:12:33', '2023-12-26 16:12:33', 0, 10),
(269, 'Sports & Entertainment', 'sports-entertainment', '2023-12-26-658ad178aa6e9.webp', 0, 0, '2023-12-26 16:13:28', '2023-12-26 16:13:28', 0, 10),
(270, 'Tools & Hardware', 'tools-hardware', '2023-12-26-658ad1c7d31b9.webp', 0, 0, '2023-12-26 16:14:47', '2023-12-26 16:14:47', 0, 10),
(271, 'Industrial accessories', 'industrial-accessories', '2024-01-12-65a05eca8566f.webp', 0, 0, '2024-01-12 00:34:02', '2024-01-12 00:34:02', 0, 10),
(272, 'Home Appliances', 'home-appliances', '2024-01-12-65a0623949e27.webp', 0, 0, '2024-01-12 00:48:41', '2024-01-12 00:48:41', 0, 10),
(273, 'Men\'s Shoes', 'mens-shoes', '2024-01-16-65a6cbda99c86.webp', 4, 1, '2024-01-16 21:24:58', '2024-01-16 21:32:58', 0, 1),
(274, 'Woman Shoes', 'woman-shoes', '2024-01-16-65a6ccf045484.webp', 4, 1, '2024-01-16 21:37:36', '2024-01-16 21:37:36', 0, 2),
(275, 'Casual Shoes', 'casual-shoes', NULL, 273, 2, '2024-01-18 17:56:44', '2024-01-18 17:56:44', 0, 0),
(276, 'Formal Shoes', 'formal-shoes', NULL, 273, 2, '2024-01-18 17:57:13', '2024-01-18 17:57:13', 0, 1),
(277, 'Sport Shoes', 'sport-shoes', NULL, 273, 2, '2024-01-18 18:20:59', '2024-01-18 18:20:59', 0, 3),
(278, 'Heels', 'heels', NULL, 274, 2, '2024-01-18 18:21:22', '2024-01-18 18:21:22', 0, 0),
(279, 'Flats', 'flats', NULL, 274, 2, '2024-01-18 18:21:57', '2024-01-18 18:21:57', 0, 1),
(280, 'Boots', 'boots', NULL, 274, 2, '2024-01-18 18:22:26', '2024-01-18 18:22:26', 0, 2),
(281, 'Sneakers', 'sneakers', NULL, 192, 2, '2024-01-18 18:23:10', '2024-01-18 18:23:10', 0, 0),
(282, 'Sandals', 'sandals', NULL, 192, 2, '2024-01-18 18:23:56', '2024-01-18 18:23:56', 0, 2),
(283, 'Children\'s shoes', 'childrens-shoes', '2024-01-26-65b3cb33b7afe.webp', 4, 1, '2024-01-26 18:09:39', '2024-01-26 18:09:39', 0, 3),
(284, 'Sports Shoes', 'sports-shoes', NULL, 283, 2, '2024-01-26 18:12:08', '2024-01-26 18:12:08', 0, 0),
(285, 'Formal Shoes', 'formal-shoes', NULL, 283, 2, '2024-01-26 18:13:29', '2024-01-26 18:13:29', 0, 1),
(286, 'Children\'s Boots', 'childrens-boots', NULL, 283, 2, '2024-01-26 18:14:08', '2024-01-26 18:14:08', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category_shipping_costs`
--

CREATE TABLE `category_shipping_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `cost` double(8,2) DEFAULT NULL,
  `multiply_qty` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_shipping_costs`
--

INSERT INTO `category_shipping_costs` (`id`, `seller_id`, `category_id`, `cost`, `multiply_qty`, `created_at`, `updated_at`) VALUES
(1, 0, 2, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(2, 0, 3, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(3, 0, 4, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(4, 0, 5, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(5, 0, 6, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(6, 0, 7, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(7, 0, 8, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(8, 0, 9, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(9, 0, 10, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(10, 0, 11, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(11, 0, 12, 0.00, NULL, '2023-11-07 02:27:12', '2023-11-07 02:27:12'),
(12, 0, 124, 0.00, NULL, '2023-11-07 23:46:08', '2023-11-07 23:46:08'),
(13, 0, 244, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(14, 0, 245, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(15, 0, 246, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(16, 0, 247, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(17, 0, 248, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(18, 0, 249, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(19, 0, 250, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(20, 0, 251, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(21, 0, 252, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(22, 0, 253, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(23, 0, 254, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(24, 0, 255, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(25, 0, 256, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(26, 0, 257, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(27, 0, 258, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(28, 0, 259, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(29, 0, 260, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(30, 0, 261, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(31, 0, 262, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(32, 0, 263, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(33, 0, 264, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(34, 0, 265, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(35, 0, 266, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(36, 0, 267, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(37, 0, 268, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(38, 0, 269, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(39, 0, 270, 0.00, NULL, '2024-01-01 23:07:06', '2024-01-01 23:07:06'),
(40, 12, 2, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(41, 12, 3, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(42, 12, 4, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(43, 12, 5, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(44, 12, 6, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(45, 12, 7, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(46, 12, 8, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(47, 12, 9, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(48, 12, 10, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(49, 12, 11, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(50, 12, 124, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(51, 12, 244, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(52, 12, 245, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(53, 12, 246, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(54, 12, 247, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(55, 12, 248, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(56, 12, 249, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(57, 12, 250, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(58, 12, 251, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(59, 12, 252, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(60, 12, 253, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(61, 12, 254, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(62, 12, 255, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(63, 12, 256, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(64, 12, 257, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(65, 12, 258, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(66, 12, 259, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(67, 12, 260, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(68, 12, 261, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(69, 12, 262, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(70, 12, 263, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(71, 12, 264, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(72, 12, 265, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(73, 12, 266, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(74, 12, 267, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(75, 12, 268, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(76, 12, 269, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(77, 12, 270, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(78, 12, 271, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(79, 12, 272, 0.00, NULL, '2024-01-26 21:27:05', '2024-01-26 21:27:05'),
(80, 13, 2, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(81, 13, 3, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(82, 13, 4, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(83, 13, 5, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(84, 13, 6, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(85, 13, 7, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(86, 13, 8, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(87, 13, 9, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(88, 13, 10, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(89, 13, 11, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(90, 13, 124, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(91, 13, 244, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(92, 13, 245, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(93, 13, 246, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(94, 13, 247, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(95, 13, 248, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(96, 13, 249, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(97, 13, 250, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(98, 13, 251, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(99, 13, 252, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(100, 13, 253, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(101, 13, 254, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(102, 13, 255, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(103, 13, 256, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(104, 13, 257, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(105, 13, 258, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(106, 13, 259, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(107, 13, 260, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(108, 13, 261, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(109, 13, 262, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(110, 13, 263, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(111, 13, 264, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(112, 13, 265, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(113, 13, 266, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(114, 13, 267, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(115, 13, 268, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(116, 13, 269, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(117, 13, 270, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(118, 13, 271, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27'),
(119, 13, 272, 0.00, NULL, '2024-01-26 22:24:27', '2024-01-26 22:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `chattings`
--

CREATE TABLE `chattings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `delivery_man_id` bigint(20) DEFAULT NULL,
  `message` text NOT NULL,
  `sent_by_customer` tinyint(1) NOT NULL DEFAULT 0,
  `sent_by_seller` tinyint(1) NOT NULL DEFAULT 0,
  `sent_by_admin` tinyint(1) DEFAULT NULL,
  `sent_by_delivery_man` tinyint(1) DEFAULT NULL,
  `seen_by_customer` tinyint(1) NOT NULL DEFAULT 1,
  `seen_by_seller` tinyint(1) NOT NULL DEFAULT 1,
  `seen_by_admin` tinyint(1) DEFAULT NULL,
  `seen_by_delivery_man` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shop_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `code`, `created_at`, `updated_at`) VALUES
(1, 'IndianRed', '#CD5C5C', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(2, 'LightCoral', '#F08080', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(3, 'Salmon', '#FA8072', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(4, 'DarkSalmon', '#E9967A', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(5, 'LightSalmon', '#FFA07A', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(6, 'Crimson', '#DC143C', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(7, 'Red', '#FF0000', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(8, 'FireBrick', '#B22222', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(9, 'DarkRed', '#8B0000', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(10, 'Pink', '#FFC0CB', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(11, 'LightPink', '#FFB6C1', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(12, 'HotPink', '#FF69B4', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(13, 'DeepPink', '#FF1493', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(14, 'MediumVioletRed', '#C71585', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(15, 'PaleVioletRed', '#DB7093', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(17, 'Coral', '#FF7F50', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(18, 'Tomato', '#FF6347', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(19, 'OrangeRed', '#FF4500', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(20, 'DarkOrange', '#FF8C00', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(21, 'Orange', '#FFA500', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(22, 'Gold', '#FFD700', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(23, 'Yellow', '#FFFF00', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(24, 'LightYellow', '#FFFFE0', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(25, 'LemonChiffon', '#FFFACD', '2018-11-05 02:12:26', '2018-11-05 02:12:26'),
(26, 'LightGoldenrodYellow', '#FAFAD2', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(27, 'PapayaWhip', '#FFEFD5', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(28, 'Moccasin', '#FFE4B5', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(29, 'PeachPuff', '#FFDAB9', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(30, 'PaleGoldenrod', '#EEE8AA', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(31, 'Khaki', '#F0E68C', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(32, 'DarkKhaki', '#BDB76B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(33, 'Lavender', '#E6E6FA', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(34, 'Thistle', '#D8BFD8', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(35, 'Plum', '#DDA0DD', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(36, 'Violet', '#EE82EE', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(37, 'Orchid', '#DA70D6', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(39, 'Magenta', '#FF00FF', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(40, 'MediumOrchid', '#BA55D3', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(41, 'MediumPurple', '#9370DB', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(42, 'Amethyst', '#9966CC', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(43, 'BlueViolet', '#8A2BE2', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(44, 'DarkViolet', '#9400D3', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(45, 'DarkOrchid', '#9932CC', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(46, 'DarkMagenta', '#8B008B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(47, 'Purple', '#800080', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(48, 'Indigo', '#4B0082', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(49, 'SlateBlue', '#6A5ACD', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(50, 'DarkSlateBlue', '#483D8B', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(51, 'MediumSlateBlue', '#7B68EE', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(52, 'GreenYellow', '#ADFF2F', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(53, 'Chartreuse', '#7FFF00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(54, 'LawnGreen', '#7CFC00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(55, 'Lime', '#00FF00', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(56, 'LimeGreen', '#32CD32', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(57, 'PaleGreen', '#98FB98', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(58, 'LightGreen', '#90EE90', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(59, 'MediumSpringGreen', '#00FA9A', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(60, 'SpringGreen', '#00FF7F', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(61, 'MediumSeaGreen', '#3CB371', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(62, 'SeaGreen', '#2E8B57', '2018-11-05 02:12:27', '2018-11-05 02:12:27'),
(63, 'ForestGreen', '#228B22', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(64, 'Green', '#008000', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(65, 'DarkGreen', '#006400', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(66, 'YellowGreen', '#9ACD32', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(67, 'OliveDrab', '#6B8E23', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(68, 'Olive', '#808000', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(69, 'DarkOliveGreen', '#556B2F', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(70, 'MediumAquamarine', '#66CDAA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(71, 'DarkSeaGreen', '#8FBC8F', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(72, 'LightSeaGreen', '#20B2AA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(73, 'DarkCyan', '#008B8B', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(74, 'Teal', '#008080', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(75, 'Aqua', '#00FFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(77, 'LightCyan', '#E0FFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(78, 'PaleTurquoise', '#AFEEEE', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(79, 'Aquamarine', '#7FFFD4', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(80, 'Turquoise', '#40E0D0', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(81, 'MediumTurquoise', '#48D1CC', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(82, 'DarkTurquoise', '#00CED1', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(83, 'CadetBlue', '#5F9EA0', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(84, 'SteelBlue', '#4682B4', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(85, 'LightSteelBlue', '#B0C4DE', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(86, 'PowderBlue', '#B0E0E6', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(87, 'LightBlue', '#ADD8E6', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(88, 'SkyBlue', '#87CEEB', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(89, 'LightSkyBlue', '#87CEFA', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(90, 'DeepSkyBlue', '#00BFFF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(91, 'DodgerBlue', '#1E90FF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(92, 'CornflowerBlue', '#6495ED', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(94, 'RoyalBlue', '#4169E1', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(95, 'Blue', '#0000FF', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(96, 'MediumBlue', '#0000CD', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(97, 'DarkBlue', '#00008B', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(98, 'Navy', '#000080', '2018-11-05 02:12:28', '2018-11-05 02:12:28'),
(99, 'MidnightBlue', '#191970', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(100, 'Cornsilk', '#FFF8DC', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(101, 'BlanchedAlmond', '#FFEBCD', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(102, 'Bisque', '#FFE4C4', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(103, 'NavajoWhite', '#FFDEAD', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(104, 'Wheat', '#F5DEB3', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(105, 'BurlyWood', '#DEB887', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(106, 'Tan', '#D2B48C', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(107, 'RosyBrown', '#BC8F8F', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(108, 'SandyBrown', '#F4A460', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(109, 'Goldenrod', '#DAA520', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(110, 'DarkGoldenrod', '#B8860B', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(111, 'Peru', '#CD853F', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(112, 'Chocolate', '#D2691E', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(113, 'SaddleBrown', '#8B4513', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(114, 'Sienna', '#A0522D', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(115, 'Brown', '#A52A2A', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(116, 'Maroon', '#800000', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(117, 'White', '#FFFFFF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(118, 'Snow', '#FFFAFA', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(119, 'Honeydew', '#F0FFF0', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(120, 'MintCream', '#F5FFFA', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(121, 'Azure', '#F0FFFF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(122, 'AliceBlue', '#F0F8FF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(123, 'GhostWhite', '#F8F8FF', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(124, 'WhiteSmoke', '#F5F5F5', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(125, 'Seashell', '#FFF5EE', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(126, 'Beige', '#F5F5DC', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(127, 'OldLace', '#FDF5E6', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(128, 'FloralWhite', '#FFFAF0', '2018-11-05 02:12:29', '2018-11-05 02:12:29'),
(129, 'Ivory', '#FFFFF0', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(130, 'AntiqueWhite', '#FAEBD7', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(131, 'Linen', '#FAF0E6', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(132, 'LavenderBlush', '#FFF0F5', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(133, 'MistyRose', '#FFE4E1', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(134, 'Gainsboro', '#DCDCDC', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(135, 'LightGrey', '#D3D3D3', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(136, 'Silver', '#C0C0C0', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(137, 'DarkGray', '#A9A9A9', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(138, 'Gray', '#808080', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(139, 'DimGray', '#696969', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(140, 'LightSlateGray', '#778899', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(141, 'SlateGray', '#708090', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(142, 'DarkSlateGray', '#2F4F4F', '2018-11-05 02:12:30', '2018-11-05 02:12:30'),
(143, 'Black', '#000000', '2018-11-05 02:12:30', '2018-11-05 02:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `mobile_number` varchar(191) NOT NULL,
  `subject` varchar(191) NOT NULL,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `feedback` varchar(191) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reply` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `added_by` varchar(191) NOT NULL DEFAULT 'admin',
  `coupon_type` varchar(50) DEFAULT NULL,
  `coupon_bearer` varchar(191) NOT NULL DEFAULT 'inhouse',
  `seller_id` bigint(20) DEFAULT NULL COMMENT 'NULL=in-house, 0=all seller',
  `customer_id` bigint(20) DEFAULT NULL COMMENT '0 = all customer',
  `title` varchar(100) DEFAULT NULL,
  `code` varchar(15) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `min_purchase` decimal(8,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(15) NOT NULL DEFAULT 'percentage',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `added_by`, `coupon_type`, `coupon_bearer`, `seller_id`, `customer_id`, `title`, `code`, `start_date`, `expire_date`, `min_purchase`, `max_discount`, `discount`, `discount_type`, `status`, `created_at`, `updated_at`, `limit`) VALUES
(1, 'admin', 'discount_on_purchase', 'seller', 0, 0, 'euromarketn', 'euromarketn', '2023-11-25', '2024-02-10', '1.00', '5000.00', '10.00', 'percentage', 1, '2023-11-25 14:23:53', '2023-11-25 14:23:53', 1);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `symbol` varchar(191) NOT NULL,
  `code` varchar(191) NOT NULL,
  `exchange_rate` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `code`, `exchange_rate`, `status`, `created_at`, `updated_at`) VALUES
(1, 'USD', '$', 'USD', '1', 1, NULL, '2021-06-27 13:39:37'),
(4, 'Euro', '€', 'EUR', '0.91551', 1, '2021-05-25 21:00:23', '2023-12-19 04:20:16'),
(120, 'Bahamian dollar', 'B$', 'BSD', '0.99994', 1, NULL, '2023-12-19 04:20:15'),
(121, 'Bhutanese ngultrum', 'Nu.', 'BTN', '83.038144', 1, NULL, '2023-12-19 04:20:16'),
(122, 'Botswana pula', 'P', 'BWP', '13.439742', 1, NULL, '2023-12-19 04:20:16'),
(123, 'Belarusian ruble', 'Br', 'BYR', '19600', 1, NULL, '2023-12-19 04:20:16'),
(124, 'Belize dollar', 'BZ$', 'BZD', '2.015549', 1, NULL, '2023-12-19 04:20:16'),
(125, 'Canadian dollar', '$', 'CAD', '1.339165', 1, NULL, '2023-12-19 04:20:16'),
(126, 'Congolese franc', 'F', 'CDF', '2700.000186', 1, NULL, '2023-12-19 04:20:16'),
(127, 'Swiss franc', 'Fr.', 'CHF', '0.867135', 1, NULL, '2023-12-19 04:20:16'),
(128, 'Chilean peso', '$', 'CLP', '874.249914', 1, NULL, '2023-12-19 04:20:16'),
(129, 'Chinese/Yuan renminbi', '¥', 'CNY', '7.133701', 1, NULL, '2023-12-19 04:20:16'),
(130, 'Colombian peso', 'Col$', 'COP', '3934.5', 1, NULL, '2023-12-19 04:20:16'),
(131, 'Costa Rican colon', '₡', 'CRC', '524.102292', 1, NULL, '2023-12-19 04:20:16'),
(132, 'Cuban peso', '$', 'CUC', '1', 1, NULL, '2023-12-19 04:20:16'),
(133, 'Cape Verdean escudo', 'Esc', 'CVE', '101.396877', 1, NULL, '2023-12-19 04:20:16'),
(134, 'Czech koruna', 'Kč', 'CZK', '22.441009', 1, NULL, '2023-12-19 04:20:16'),
(135, 'Djiboutian franc', 'Fdj', 'DJF', '177.720205', 1, NULL, '2023-12-19 04:20:16'),
(136, 'Danish krone', 'Kr', 'DKK', '6.82504', 1, NULL, '2023-12-19 04:20:16'),
(137, 'Dominican peso', 'RD$', 'DOP', '57.249809', 1, NULL, '2023-12-19 04:20:16'),
(138, 'Algerian dinar', 'دج', 'DZD', '134.541892', 1, NULL, '2023-12-19 04:20:16'),
(139, 'Estonian kroon', 'KR', 'EEK', '1', 1, NULL, NULL),
(140, 'Egyptian pound', 'e£', 'EGP', '30.898901', 1, NULL, '2023-12-19 04:20:16'),
(141, 'Eritrean nakfa', 'Nfa', 'ERN', '15', 1, NULL, '2023-12-19 04:20:16'),
(142, 'Ethiopian birr', 'Br', 'ETB', '56.253276', 1, NULL, '2023-12-19 04:20:16'),
(143, 'European Euro', '€', 'EUR', '0.91551', 1, NULL, '2023-12-19 04:20:16'),
(144, 'Fijian dollar', 'FJ$', 'FJD', '2.21345', 1, NULL, '2023-12-19 04:20:16'),
(145, 'Falkland Islands pound', '£', 'FKP', '0.788577', 1, NULL, '2023-12-19 04:20:16'),
(146, 'British pound', '£', 'GBP', '0.789945', 1, NULL, '2023-12-19 04:20:16'),
(147, 'Georgian lari', 'GEL', 'GEL', '2.689946', 1, NULL, '2023-12-19 04:20:16'),
(148, 'Ghanaian cedi', 'GH¢', 'GHS', '12.029923', 1, NULL, '2023-12-19 04:20:16'),
(149, 'Gibraltar pound', '£', 'GIP', '0.788577', 1, NULL, '2023-12-19 04:20:16'),
(150, 'Gambian dalasi', 'D', 'GMD', '67.375015', 1, NULL, '2023-12-19 04:20:16'),
(151, 'Guinean franc', 'FG', 'GNF', '8610.000211', 1, NULL, '2023-12-19 04:20:16'),
(152, 'Central African CFA franc', 'CFA', 'GQE', '1', 1, NULL, NULL),
(153, 'Guatemalan quetzal', 'Q', 'GTQ', '7.819386', 1, NULL, '2023-12-19 04:20:16'),
(154, 'Guyanese dollar', 'GY$', 'GYD', '209.193865', 1, NULL, '2023-12-19 04:20:16'),
(155, 'Hong Kong dollar', 'HK$', 'HKD', '7.79464', 1, NULL, '2023-12-19 04:20:16'),
(156, 'Honduran lempira', 'L', 'HNL', '24.657547', 1, NULL, '2023-12-19 04:20:16'),
(157, 'Croatian kuna', 'kn', 'HRK', '6.98177', 1, NULL, '2023-12-19 04:20:16'),
(158, 'Haitian gourde', 'G', 'HTG', '132.036486', 1, NULL, '2023-12-19 04:20:16'),
(159, 'Hungarian forint', 'Ft', 'HUF', '352.039709', 1, NULL, '2023-12-19 04:20:16'),
(160, 'Indonesian rupiah', 'Rp', 'IDR', '15492.9', 1, NULL, '2023-12-19 04:20:16'),
(161, 'Israeli new sheqel', '₪', 'ILS', '3.665102', 1, NULL, '2023-12-19 04:20:16'),
(162, 'Indian rupee', '₹', 'INR', '83.10715', 1, NULL, '2023-12-19 04:20:16'),
(163, 'Iraqi dinar', 'ع.د', 'IQD', '1308.911317', 1, NULL, '2023-12-19 04:20:16'),
(164, 'Iranian rial', 'IRR', 'IRR', '42274.999767', 1, NULL, '2023-12-19 04:20:16'),
(165, 'Icelandic króna', 'kr', 'ISK', '137.9698', 1, NULL, '2023-12-19 04:20:16'),
(166, 'Jamaican dollar', 'J$', 'JMD', '155.326284', 1, NULL, '2023-12-19 04:20:16'),
(167, 'Jordanian dinar', 'JOD', 'JOD', '0.7093', 1, NULL, '2023-12-19 04:20:16'),
(168, 'Japanese yen', '¥', 'JPY', '142.390269', 1, NULL, '2023-12-19 04:20:16'),
(169, 'Kenyan shilling', 'KSh', 'KES', '154.149349', 1, NULL, '2023-12-19 04:20:16'),
(170, 'Kyrgyzstani som', 'Лв', 'KGS', '89.05027', 1, NULL, '2023-12-19 04:20:16'),
(171, 'Cambodian riel', '៛', 'KHR', '4114.000152', 1, NULL, '2023-12-19 04:20:16'),
(172, 'Comorian franc', 'KMF', 'KMF', '450.534501', 1, NULL, '2023-12-19 04:20:16'),
(173, 'North Korean won', 'W', 'KPW', '900.000291', 1, NULL, '2023-12-19 04:20:16'),
(174, 'South Korean won', 'W', 'KRW', '1301.669889', 1, NULL, '2023-12-19 04:20:16'),
(175, 'Kuwaiti dinar', 'KWD', 'KWD', '0.30758', 1, NULL, '2023-12-19 04:20:16'),
(176, 'Cayman Islands dollar', 'KY$', 'KYD', '0.833257', 1, NULL, '2023-12-19 04:20:16'),
(177, 'Kazakhstani tenge', 'T', 'KZT', '458.911547', 1, NULL, '2023-12-19 04:20:16'),
(178, 'Lao kip', 'KN', 'LAK', '20608.770547', 1, NULL, '2023-12-19 04:20:16'),
(179, 'Lebanese lira', '.ل.ل', 'LBP', '15028.58766', 1, NULL, '2023-12-19 04:20:16'),
(180, 'Sri Lankan rupee', 'Rs', 'LKR', '326.985014', 1, NULL, '2023-12-19 04:20:16'),
(181, 'Liberian dollar', 'L$', 'LRD', '187.5502', 1, NULL, '2023-12-19 04:20:16'),
(182, 'Lesotho loti', 'M', 'LSL', '18.280413', 1, NULL, '2023-12-19 04:20:16'),
(183, 'Lithuanian litas', 'Lt', 'LTL', '2.95274', 1, NULL, '2023-12-19 04:20:16'),
(184, 'Latvian lats', 'Ls', 'LVL', '0.60489', 1, NULL, '2023-12-19 04:20:16'),
(185, 'Libyan dinar', 'LD', 'LYD', '4.798424', 1, NULL, '2023-12-19 04:20:16'),
(186, 'Moroccan dirham', 'MAD', 'MAD', '10.11096', 1, NULL, '2023-12-19 04:20:16'),
(187, 'Moldovan leu', 'MDL', 'MDL', '17.643717', 1, NULL, '2023-12-19 04:20:16'),
(188, 'Malagasy ariary', 'FMG', 'MGA', '4574.999983', 1, NULL, '2023-12-19 04:20:16'),
(189, 'Macedonian denar', 'MKD', 'MKD', '56.321202', 1, NULL, '2023-12-19 04:20:16'),
(190, 'Myanma kyat', 'K', 'MMK', '2099.818578', 1, NULL, '2023-12-19 04:20:16'),
(191, 'Mongolian tugrik', '₮', 'MNT', '3419.208923', 1, NULL, '2023-12-19 04:20:16'),
(192, 'Macanese pataca', 'P', 'MOP', '8.033407', 1, NULL, '2023-12-19 04:20:16'),
(193, 'Mauritanian ouguiya', 'UM', 'MRO', '1', 1, NULL, NULL),
(194, 'Mauritian rupee', 'Rs', 'MUR', '44.632476', 1, NULL, '2023-12-19 04:20:16'),
(195, 'Maldivian rufiyaa', 'Rf', 'MVR', '15.399746', 1, NULL, '2023-12-19 04:20:16'),
(196, 'Malawian kwacha', 'MK', 'MWK', '1683.19009', 1, NULL, '2023-12-19 04:20:16'),
(197, 'Mexican peso', '$', 'MXN', '17.163885', 1, NULL, '2023-12-19 04:20:16'),
(198, 'Malaysian ringgit', 'RM', 'MYR', '4.70015', 1, NULL, '2023-12-19 04:20:16'),
(199, 'Mozambican metical', 'MTn', 'MZM', '1', 1, NULL, NULL),
(200, 'Namibian dollar', 'N$', 'NAD', '18.28017', 1, NULL, '2023-12-19 04:20:16'),
(201, 'Nigerian naira', '₦', 'NGN', '789.909828', 1, NULL, '2023-12-19 04:20:16'),
(202, 'Nicaraguan córdoba', 'C$', 'NIO', '36.595534', 1, NULL, '2023-12-19 04:20:16'),
(203, 'Norwegian krone', 'kr', 'NOK', '10.388499', 1, NULL, '2023-12-19 04:20:16'),
(204, 'Nepalese rupee', 'NRs', 'NPR', '132.860847', 1, NULL, '2023-12-19 04:20:16'),
(205, 'New Zealand dollar', 'NZ$', 'NZD', '1.60757', 1, NULL, '2023-12-19 04:20:16'),
(206, 'Omani rial', 'OMR', 'OMR', '0.384944', 1, NULL, '2023-12-19 04:20:16'),
(207, 'Panamanian balboa', 'B/.', 'PAB', '0.99994', 1, NULL, '2023-12-19 04:20:16'),
(208, 'Peruvian nuevo sol', 'S/.', 'PEN', '3.761075', 1, NULL, '2023-12-19 04:20:16'),
(209, 'Papua New Guinean kina', 'K', 'PGK', '3.778702', 1, NULL, '2023-12-19 04:20:16'),
(210, 'Philippine peso', '₱', 'PHP', '55.827502', 1, NULL, '2023-12-19 04:20:16'),
(211, 'Pakistani rupee', 'Rs.', 'PKR', '279.723103', 1, NULL, '2023-12-19 04:20:16'),
(212, 'Polish zloty', 'zł', 'PLN', '3.957763', 1, NULL, '2023-12-19 04:20:16'),
(213, 'Paraguayan guarani', '₲', 'PYG', '7307.262365', 1, NULL, '2023-12-19 04:20:16'),
(214, 'Qatari riyal', 'QR', 'QAR', '3.640985', 1, NULL, '2023-12-19 04:20:16'),
(215, 'Romanian leu', 'L', 'RON', '4.5511', 1, NULL, '2023-12-19 04:20:16'),
(216, 'Serbian dinar', 'din.', 'RSD', '107.292984', 1, NULL, '2023-12-19 04:20:16'),
(217, 'Russian ruble', 'R', 'RUB', '90.524991', 1, NULL, '2023-12-19 04:20:16'),
(218, 'Saudi riyal', 'SR', 'SAR', '3.751299', 1, NULL, '2023-12-19 04:20:16'),
(219, 'Solomon Islands dollar', 'SI$', 'SBD', '8.475185', 1, NULL, '2023-12-19 04:20:16'),
(220, 'Seychellois rupee', 'SR', 'SCR', '13.360068', 1, NULL, '2023-12-19 04:20:16'),
(221, 'Sudanese pound', 'SDG', 'SDG', '600.999485', 1, NULL, '2023-12-19 04:20:16'),
(222, 'Swedish krona', 'kr', 'SEK', '10.213625', 1, NULL, '2023-12-19 04:20:16'),
(223, 'Singapore dollar', 'S$', 'SGD', '1.331775', 1, NULL, '2023-12-19 04:20:16'),
(224, 'Saint Helena pound', '£', 'SHP', '1.21675', 1, NULL, '2023-12-19 04:20:16'),
(225, 'Sierra Leonean leone', 'Le', 'SLL', '19750.000031', 1, NULL, '2023-12-19 04:20:16'),
(226, 'Somali shilling', 'Sh.', 'SOS', '571.00033', 1, NULL, '2023-12-19 04:20:16'),
(227, 'Surinamese dollar', '$', 'SRD', '37.4815', 1, NULL, '2023-12-19 04:20:16'),
(228, 'Syrian pound', 'LS', 'SYP', '13001.850253', 1, NULL, '2023-12-19 04:20:16'),
(229, 'Swazi lilangeni', 'E', 'SZL', '18.443875', 1, NULL, '2023-12-19 04:20:16'),
(230, 'Thai baht', '฿', 'THB', '34.956029', 1, NULL, '2023-12-19 04:20:16'),
(231, 'Tajikistani somoni', 'TJS', 'TJS', '10.918928', 1, NULL, '2023-12-19 04:20:16'),
(232, 'Turkmen manat', 'm', 'TMT', '3.51', 1, NULL, '2023-12-19 04:20:16'),
(233, 'Tunisian dinar', 'DT', 'TND', '3.066008', 1, NULL, '2023-12-19 04:20:16'),
(234, 'Turkish new lira', 'TRY', 'TRY', '29.062201', 1, NULL, '2023-12-19 04:20:16'),
(235, 'Trinidad and Tobago dollar', 'TT$', 'TTD', '6.789569', 1, NULL, '2023-12-19 04:20:16'),
(236, 'New Taiwan dollar', 'NT$', 'TWD', '31.359899', 1, NULL, '2023-12-19 04:20:16'),
(237, 'Tanzanian shilling', 'TZS', 'TZS', '2505.000023', 1, NULL, '2023-12-19 04:20:16'),
(238, 'Ukrainian hryvnia', 'UAH', 'UAH', '37.207755', 1, NULL, '2023-12-19 04:20:16'),
(239, 'Ugandan shilling', 'USh', 'UGX', '3771.423859', 1, NULL, '2023-12-19 04:20:16'),
(240, 'United States dollar', '$', 'USD', '1', 1, NULL, NULL),
(241, 'Uruguayan peso', '$U', 'UYU', '39.646326', 1, NULL, '2023-12-19 04:20:16'),
(242, 'Uzbekistani som', 'UZS', 'UZS', '12385.010079', 1, NULL, '2023-12-19 04:20:16'),
(243, 'Venezuelan bolivar', 'Bs', 'VEB', '1', 1, NULL, NULL),
(244, 'Vietnamese dong', '₫', 'VND', '24360', 1, NULL, '2023-12-19 04:20:16'),
(245, 'Vanuatu vatu', 'VT', 'VUV', '117.828633', 1, NULL, '2023-12-19 04:20:16'),
(246, 'Samoan tala', 'WS$', 'WST', '2.683112', 1, NULL, '2023-12-19 04:20:16'),
(247, 'Central African CFA franc', 'CFA', 'XAF', '601.042731', 1, NULL, '2023-12-19 04:20:16'),
(248, 'East Caribbean dollar', 'EC$', 'XCD', '2.70255', 1, NULL, '2023-12-19 04:20:16'),
(249, 'Special Drawing Rights', 'SDR', 'XDR', '0.745763', 1, NULL, '2023-12-19 04:20:16'),
(250, 'West African CFA franc', 'CFA', 'XOF', '601.023456', 1, NULL, '2023-12-19 04:20:16'),
(251, 'CFP franc', 'F', 'XPF', '108.700564', 1, NULL, '2023-12-19 04:20:16'),
(252, 'Yemeni rial', 'YER', 'YER', '250.375036', 1, NULL, '2023-12-19 04:20:16'),
(253, 'South African rand', 'R', 'ZAR', '18.5759', 1, NULL, '2023-12-19 04:20:16'),
(254, 'Zambian kwacha', 'ZK', 'ZMK', '9001.201691', 1, NULL, '2023-12-19 04:20:16'),
(255, 'Zimbabwean dollar', 'Z$', 'ZWR', '1', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_wallets`
--

CREATE TABLE `customer_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `royality_points` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_wallet_histories`
--

CREATE TABLE `customer_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `transaction_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `transaction_type` varchar(20) DEFAULT NULL,
  `transaction_method` varchar(30) DEFAULT NULL,
  `transaction_id` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deal_of_the_days`
--

CREATE TABLE `deal_of_the_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(12) NOT NULL DEFAULT 'amount',
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deal_of_the_days`
--

INSERT INTO `deal_of_the_days` (`id`, `title`, `product_id`, `discount`, `discount_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Black Friday', 111, '7.00', 'percent', 0, '2023-11-25 14:30:11', '2023-11-25 14:31:08'),
(2, 'Bespoke V-neck', 114, '5.00', 'percent', 1, '2023-11-25 14:31:01', '2023-11-25 14:31:08');

-- --------------------------------------------------------

--
-- Table structure for table `deliveryman_notifications`
--

CREATE TABLE `deliveryman_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `description` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveryman_wallets`
--

CREATE TABLE `deliveryman_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) NOT NULL,
  `current_balance` decimal(50,2) NOT NULL DEFAULT 0.00,
  `cash_in_hand` decimal(50,2) NOT NULL DEFAULT 0.00,
  `pending_withdraw` decimal(50,2) NOT NULL DEFAULT 0.00,
  `total_withdraw` decimal(50,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_country_codes`
--

CREATE TABLE `delivery_country_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_code` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_histories`
--

CREATE TABLE `delivery_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `deliveryman_id` bigint(20) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `location` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_man_transactions`
--

CREATE TABLE `delivery_man_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_man_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `transaction_id` char(36) NOT NULL,
  `debit` decimal(50,2) NOT NULL DEFAULT 0.00,
  `credit` decimal(50,2) NOT NULL DEFAULT 0.00,
  `transaction_type` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_men`
--

CREATE TABLE `delivery_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `f_name` varchar(100) DEFAULT NULL,
  `l_name` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `country_code` varchar(20) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `identity_number` varchar(30) DEFAULT NULL,
  `identity_type` varchar(50) DEFAULT NULL,
  `identity_image` varchar(191) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `bank_name` varchar(191) DEFAULT NULL,
  `branch` varchar(191) DEFAULT NULL,
  `account_no` varchar(191) DEFAULT NULL,
  `holder_name` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_online` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `auth_token` varchar(191) NOT NULL DEFAULT '6yIRXJRRfp78qJsAoKZZ6TTqhzuNJ3TcdvPBmk6n',
  `fcm_token` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_zip_codes`
--

CREATE TABLE `delivery_zip_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `zipcode` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `digital_product_otp_verifications`
--

CREATE TABLE `digital_product_otp_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_details_id` varchar(255) DEFAULT NULL,
  `identity` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `otp_hit_count` tinyint(4) NOT NULL DEFAULT 0,
  `is_temp_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `temp_block_time` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_contacts`
--

CREATE TABLE `emergency_contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(191) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feature_deals`
--

CREATE TABLE `feature_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(191) DEFAULT NULL,
  `photo` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_deals`
--

CREATE TABLE `flash_deals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `background_color` varchar(255) DEFAULT NULL,
  `text_color` varchar(255) DEFAULT NULL,
  `banner` varchar(100) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `deal_type` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flash_deals`
--

INSERT INTO `flash_deals` (`id`, `title`, `start_date`, `end_date`, `status`, `featured`, `background_color`, `text_color`, `banner`, `slug`, `created_at`, `updated_at`, `product_id`, `deal_type`) VALUES
(1, 'Euro Flash', '2023-11-25', '2024-02-28', 1, 0, NULL, NULL, '2023-11-25-6561da13d3484.webp', 'euro-flash', '2023-11-25 14:27:15', '2023-11-25 14:27:20', NULL, 'flash_deal'),
(2, 'Feature Deal  From Euro Marketn', '2023-11-25', '2024-01-31', 1, 0, NULL, NULL, 'def.webp', 'feature-deal-from-euro-marketn', '2023-11-25 14:33:20', '2023-11-25 14:33:38', NULL, 'feature_deal');

-- --------------------------------------------------------

--
-- Table structure for table `flash_deal_products`
--

CREATE TABLE `flash_deal_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flash_deal_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `discount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `discount_type` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `flash_deal_products`
--

INSERT INTO `flash_deal_products` (`id`, `flash_deal_id`, `product_id`, `discount`, `discount_type`, `created_at`, `updated_at`) VALUES
(1, 1, 160, '0.00', NULL, '2023-11-25 14:27:41', '2023-11-25 14:27:41'),
(2, 1, 151, '0.00', NULL, '2023-11-25 14:27:51', '2023-11-25 14:27:51'),
(3, 1, 149, '0.00', NULL, '2023-11-25 14:28:05', '2023-11-25 14:28:05'),
(4, 1, 178, '0.00', NULL, '2023-11-25 14:28:22', '2023-11-25 14:28:22'),
(5, 1, 128, '0.00', NULL, '2023-11-25 14:28:51', '2023-11-25 14:28:51'),
(6, 1, 131, '0.00', NULL, '2023-11-25 14:29:07', '2023-11-25 14:29:07'),
(7, 2, 115, '0.00', NULL, '2023-11-25 14:33:49', '2023-11-25 14:33:49'),
(8, 2, 118, '0.00', NULL, '2023-11-25 14:33:55', '2023-11-25 14:33:55'),
(9, 2, 123, '0.00', NULL, '2023-11-25 14:34:01', '2023-11-25 14:34:01'),
(10, 2, 127, '0.00', NULL, '2023-11-25 14:34:08', '2023-11-25 14:34:08'),
(11, 2, 125, '0.00', NULL, '2023-11-25 14:34:19', '2023-11-25 14:34:19'),
(12, 2, 113, '0.00', NULL, '2023-11-25 14:34:25', '2023-11-25 14:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `guest_users`
--

CREATE TABLE `guest_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `fcm_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guest_users`
--

INSERT INTO `guest_users` (`id`, `ip_address`, `fcm_token`, `created_at`, `updated_at`) VALUES
(1, '::1', NULL, '2023-10-13 05:34:54', NULL),
(2, '81.213.110.164', NULL, '2023-10-25 18:11:20', NULL),
(3, '65.154.226.171', NULL, '2023-10-25 18:16:57', NULL),
(4, '5.164.29.202', NULL, '2023-10-25 18:30:41', NULL),
(5, '81.213.110.164', NULL, '2023-10-25 18:41:23', NULL),
(6, '35.238.134.249', NULL, '2023-10-25 12:55:19', NULL),
(7, '205.169.39.195', NULL, '2023-10-25 19:47:40', NULL),
(8, '205.169.39.195', NULL, '2023-10-25 19:47:56', NULL),
(9, '45.128.160.157', NULL, '2023-10-25 20:20:52', NULL),
(10, '47.251.15.21', NULL, '2023-10-25 23:57:29', NULL),
(11, '2a02:4780:a:c0de::84', NULL, '2023-10-26 00:01:57', NULL),
(12, '2a02:4780:a:c0de::84', NULL, '2023-10-28 00:02:19', NULL),
(13, '2a02:4780:a:c0de::84', NULL, '2023-10-29 01:18:29', NULL),
(14, '159.146.73.36', NULL, '2023-10-29 14:05:29', NULL),
(15, '2a02:4780:a:c0de::84', NULL, '2023-10-30 01:18:29', NULL),
(16, '183.129.153.157', NULL, '2023-10-30 19:45:51', NULL),
(17, '183.129.153.157', NULL, '2023-10-30 19:45:51', NULL),
(18, '2a02:4780:a:c0de::84', NULL, '2023-10-31 01:18:28', NULL),
(19, '159.146.75.89', NULL, '2023-10-31 19:57:26', NULL),
(20, '159.146.75.89', NULL, '2023-11-01 22:30:06', NULL),
(21, '159.146.75.89', NULL, '2023-11-01 22:31:35', NULL),
(22, '2a02:4780:a:c0de::84', NULL, '2023-11-02 01:18:28', NULL),
(23, '2a02:4780:a:c0de::84', NULL, '2023-11-03 01:18:28', NULL),
(24, '159.146.75.89', NULL, '2023-11-03 20:29:12', NULL),
(25, '159.146.75.89', NULL, '2023-11-03 22:58:08', NULL),
(26, '2a02:4780:a:c0de::84', NULL, '2023-11-04 01:18:06', NULL),
(27, '45.128.163.132', NULL, '2023-11-04 09:06:29', NULL),
(28, '159.146.75.89', NULL, '2023-11-04 13:13:20', NULL),
(29, '159.146.75.89', NULL, '2023-11-04 18:41:26', NULL),
(30, '24.133.12.64', NULL, '2023-11-04 19:07:34', NULL),
(31, '159.146.75.89', NULL, '2023-11-04 20:40:47', NULL),
(32, '2a02:4780:a:c0de::84', NULL, '2023-11-05 00:14:18', NULL),
(33, '159.146.75.89', NULL, '2023-11-05 14:01:41', NULL),
(34, '78.191.71.73', NULL, '2023-11-05 16:37:48', NULL),
(35, '159.146.74.197', NULL, '2023-11-05 19:10:15', NULL),
(36, '159.146.74.197', NULL, '2023-11-05 20:51:25', NULL),
(37, '2a02:4780:a:c0de::84', NULL, '2023-11-06 00:14:18', NULL),
(38, '81.213.110.164', NULL, '2023-11-06 07:38:34', NULL),
(39, '78.191.71.73', NULL, '2023-11-06 10:32:57', NULL),
(40, '2a06:4880:7000::73', NULL, '2023-11-06 11:20:46', NULL),
(41, '78.191.71.73', NULL, '2023-11-06 12:50:44', NULL),
(42, '2a06:4880:d000::ec', NULL, '2023-11-06 13:16:06', NULL),
(43, '78.191.71.73', NULL, '2023-11-06 16:57:56', NULL),
(44, '78.191.71.73', NULL, '2023-11-06 19:14:11', NULL),
(45, '78.191.71.73', NULL, '2023-11-06 19:29:04', NULL),
(46, '159.146.73.212', NULL, '2023-11-06 22:26:29', NULL),
(47, '159.146.73.212', NULL, '2023-11-07 02:47:50', NULL),
(48, '2a02:4780:a:c0de::84', NULL, '2023-11-07 03:14:13', NULL),
(49, '159.146.73.212', NULL, '2023-11-07 10:47:00', NULL),
(50, '159.146.73.212', NULL, '2023-11-07 10:47:07', NULL),
(51, '159.146.73.212', NULL, '2023-11-07 10:47:09', NULL),
(52, '159.146.73.212', NULL, '2023-11-07 10:47:10', NULL),
(53, '159.146.21.106', NULL, '2023-11-07 11:09:20', NULL),
(54, '81.213.110.164', NULL, '2023-11-07 12:55:06', NULL),
(55, '52.19.16.11', NULL, '2023-11-07 13:38:22', NULL),
(56, '78.191.71.73', NULL, '2023-11-07 15:01:27', NULL),
(57, '81.213.110.164', NULL, '2023-11-07 17:53:13', NULL),
(58, '2a02:4780:a:c0de::84', NULL, '2023-11-08 03:14:17', NULL),
(59, '159.146.21.106', NULL, '2023-11-08 10:24:10', NULL),
(60, '151.135.75.102', NULL, '2023-11-08 10:35:57', NULL),
(61, '81.213.110.164', NULL, '2023-11-08 11:14:28', NULL),
(62, '78.191.71.73', NULL, '2023-11-08 15:23:11', NULL),
(63, '81.213.110.164', NULL, '2023-11-08 19:22:19', NULL),
(64, '2a02:4780:a:c0de::84', NULL, '2023-11-09 03:14:17', NULL),
(65, '81.213.110.164', NULL, '2023-11-09 16:44:51', NULL),
(66, '159.146.73.212', NULL, '2023-11-09 21:09:24', NULL),
(67, '78.191.71.73', NULL, '2023-11-09 22:13:49', NULL),
(68, '2a02:4780:a:c0de::84', NULL, '2023-11-10 03:14:13', NULL),
(69, '81.213.110.164', NULL, '2023-11-10 11:27:58', NULL),
(70, '78.191.71.73', NULL, '2023-11-10 14:55:09', NULL),
(71, '81.213.110.164', NULL, '2023-11-10 14:58:15', NULL),
(72, '159.146.21.106', NULL, '2023-11-10 15:47:53', NULL),
(73, '159.146.73.212', NULL, '2023-11-10 23:26:41', NULL),
(74, '2a02:4780:a:c0de::84', NULL, '2023-11-11 03:14:16', NULL),
(75, '45.128.163.132', NULL, '2023-11-11 08:46:55', NULL),
(76, '78.191.71.73', NULL, '2023-11-11 14:04:13', NULL),
(77, '78.191.71.73', NULL, '2023-11-11 14:33:41', NULL),
(78, '159.146.73.212', NULL, '2023-11-11 22:22:55', NULL),
(79, '159.146.73.212', NULL, '2023-11-11 22:22:57', NULL),
(80, '2a02:4780:a:c0de::84', NULL, '2023-11-12 08:27:45', NULL),
(81, '159.146.73.212', NULL, '2023-11-12 23:55:27', NULL),
(82, '2a02:4780:a:c0de::84', NULL, '2023-11-13 08:27:45', NULL),
(83, '159.146.21.106', NULL, '2023-11-13 10:43:52', NULL),
(84, '81.213.110.164', NULL, '2023-11-13 11:58:26', NULL),
(85, '78.191.71.73', NULL, '2023-11-13 15:52:23', NULL),
(86, '2a02:4780:a:c0de::84', NULL, '2023-11-14 08:27:45', NULL),
(87, '81.213.110.164', NULL, '2023-11-14 12:04:25', NULL),
(88, '81.213.110.164', NULL, '2023-11-14 12:15:45', NULL),
(89, '159.146.21.106', NULL, '2023-11-14 12:30:20', NULL),
(90, '81.213.110.164', NULL, '2023-11-14 14:25:24', NULL),
(91, '81.213.110.164', NULL, '2023-11-14 15:44:36', NULL),
(92, '81.213.110.164', NULL, '2023-11-14 16:50:15', NULL),
(93, '74.125.212.230', NULL, '2023-11-14 17:11:34', NULL),
(94, '81.213.110.164', NULL, '2023-11-14 17:12:41', NULL),
(95, '81.213.110.164', NULL, '2023-11-14 17:13:34', NULL),
(96, '31.220.23.41', NULL, '2023-11-14 17:30:11', NULL),
(97, '31.220.23.41', NULL, '2023-11-14 17:30:19', NULL),
(98, '31.220.23.41', NULL, '2023-11-14 17:30:49', NULL),
(99, '31.220.23.41', NULL, '2023-11-14 17:31:19', NULL),
(100, '31.220.23.41', NULL, '2023-11-14 17:31:44', NULL),
(101, '2a03:2880:31ff:e::face:b00c', NULL, '2023-11-14 18:21:05', NULL),
(102, '2a03:2880:31ff:11::face:b00c', NULL, '2023-11-14 18:21:05', NULL),
(103, '2a03:2880:31ff:19::face:b00c', NULL, '2023-11-14 18:21:06', NULL),
(104, '2a03:2880:31ff:71::face:b00c', NULL, '2023-11-14 18:21:06', NULL),
(105, '2a03:2880:31ff:77::face:b00c', NULL, '2023-11-14 18:21:06', NULL),
(106, '78.180.177.223', NULL, '2023-11-14 22:11:37', NULL),
(107, '159.146.73.212', NULL, '2023-11-14 23:12:14', NULL),
(108, '45.128.160.143', NULL, '2023-11-15 03:06:26', NULL),
(109, '2a02:4780:a:c0de::84', NULL, '2023-11-15 08:27:45', NULL),
(110, '78.180.177.223', NULL, '2023-11-15 12:12:25', NULL),
(111, '81.213.110.164', NULL, '2023-11-15 13:07:10', NULL),
(112, '45.128.160.157', NULL, '2023-11-15 13:52:20', NULL),
(113, '78.180.177.223', NULL, '2023-11-15 16:56:30', NULL),
(114, '31.223.52.30', NULL, '2023-11-15 23:13:59', NULL),
(115, '31.223.52.30', NULL, '2023-11-15 23:52:35', NULL),
(116, '65.154.226.167', NULL, '2023-11-16 02:44:35', NULL),
(117, '2a02:4780:a:c0de::84', NULL, '2023-11-16 08:27:46', NULL),
(118, '66.249.70.198', NULL, '2023-11-16 17:01:20', NULL),
(119, '66.249.70.198', NULL, '2023-11-16 17:01:22', NULL),
(120, '66.249.70.197', NULL, '2023-11-16 17:01:27', NULL),
(121, '66.249.70.197', NULL, '2023-11-16 17:01:29', NULL),
(122, '78.180.177.223', NULL, '2023-11-16 18:02:23', NULL),
(123, '31.223.52.30', NULL, '2023-11-16 21:16:21', NULL),
(124, '78.180.177.223', NULL, '2023-11-16 22:46:18', NULL),
(125, '31.223.52.30', NULL, '2023-11-16 22:54:06', NULL),
(126, '2a02:4780:a:c0de::84', NULL, '2023-11-17 08:27:46', NULL),
(127, '78.180.177.223', NULL, '2023-11-17 15:26:51', NULL),
(128, '78.180.177.223', NULL, '2023-11-17 15:26:59', NULL),
(129, '78.180.177.223', NULL, '2023-11-17 15:34:11', NULL),
(130, '2a02:4780:a:c0de::84', NULL, '2023-11-18 08:27:40', NULL),
(131, '45.128.163.132', NULL, '2023-11-18 14:09:03', NULL),
(132, '2a02:4780:a:c0de::84', NULL, '2023-11-19 07:56:28', NULL),
(133, '2a02:4780:a:c0de::84', NULL, '2023-11-20 07:56:33', NULL),
(134, '81.213.110.164', NULL, '2023-11-20 12:55:52', NULL),
(135, '78.180.177.223', NULL, '2023-11-20 13:51:08', NULL),
(136, '81.213.110.164', NULL, '2023-11-20 14:07:31', NULL),
(137, '81.213.110.164', NULL, '2023-11-20 15:45:26', NULL),
(138, '81.213.110.164', NULL, '2023-11-20 19:01:27', NULL),
(139, '78.180.177.223', NULL, '2023-11-20 22:30:20', NULL),
(140, '2a02:4780:a:c0de::84', NULL, '2023-11-21 07:56:33', NULL),
(141, '81.213.110.164', NULL, '2023-11-21 16:05:35', NULL),
(142, '31.223.41.107', NULL, '2023-11-21 22:39:04', NULL),
(143, '31.223.41.107', NULL, '2023-11-22 00:17:22', NULL),
(144, '31.223.41.107', NULL, '2023-11-22 01:27:57', NULL),
(145, '31.223.41.107', NULL, '2023-11-22 01:28:30', NULL),
(146, '2a02:4780:a:c0de::84', NULL, '2023-11-22 07:56:32', NULL),
(147, '81.213.110.164', NULL, '2023-11-22 11:45:13', NULL),
(148, '81.213.110.164', NULL, '2023-11-22 14:10:55', NULL),
(149, '81.213.110.164', NULL, '2023-11-22 14:12:10', NULL),
(150, '81.213.110.164', NULL, '2023-11-22 14:14:21', NULL),
(151, '81.213.110.164', NULL, '2023-11-22 15:11:01', NULL),
(152, '81.213.110.164', NULL, '2023-11-22 15:32:26', NULL),
(153, '81.213.110.164', NULL, '2023-11-22 15:32:29', NULL),
(154, '81.213.110.164', NULL, '2023-11-22 15:32:32', NULL),
(155, '81.213.110.164', NULL, '2023-11-22 15:32:33', NULL),
(156, '81.213.110.164', NULL, '2023-11-22 16:40:18', NULL),
(157, '66.249.70.197', NULL, '2023-11-22 16:40:31', NULL),
(158, '66.249.70.198', NULL, '2023-11-22 16:40:33', NULL),
(159, '31.223.52.222', NULL, '2023-11-22 21:48:45', NULL),
(160, '78.180.177.223', NULL, '2023-11-22 23:39:12', NULL),
(161, '2a02:4780:a:c0de::84', NULL, '2023-11-23 07:56:28', NULL),
(162, '81.213.110.164', NULL, '2023-11-23 12:46:25', NULL),
(163, '81.213.110.164', NULL, '2023-11-23 15:23:54', NULL),
(164, '81.213.110.164', NULL, '2023-11-23 16:13:09', NULL),
(165, '2a02:4780:a:c0de::84', NULL, '2023-11-24 07:56:28', NULL),
(166, '2a02:4780:a:c0de::84', NULL, '2023-11-25 07:56:32', NULL),
(167, '81.213.110.164', NULL, '2023-11-25 11:55:27', NULL),
(168, '81.213.110.164', NULL, '2023-11-25 14:20:15', NULL),
(169, '45.128.163.132', NULL, '2023-11-25 15:32:59', NULL),
(170, '31.223.52.222', NULL, '2023-11-25 22:00:20', NULL),
(171, '2a02:4780:a:c0de::84', NULL, '2023-11-26 11:24:27', NULL),
(172, '31.223.41.57', NULL, '2023-11-27 00:19:59', NULL),
(173, '2a02:4780:a:c0de::84', NULL, '2023-11-27 11:24:27', NULL),
(174, '81.213.110.164', NULL, '2023-11-27 14:59:04', NULL),
(175, '81.213.110.164', NULL, '2023-11-27 14:59:07', NULL),
(176, '81.213.110.164', NULL, '2023-11-27 14:59:10', NULL),
(177, '87.209.202.146', NULL, '2023-11-27 14:59:22', NULL),
(178, '87.209.202.146', NULL, '2023-11-27 15:53:06', NULL),
(179, '89.205.226.76', NULL, '2023-11-27 19:36:45', NULL),
(180, '87.209.202.146', NULL, '2023-11-27 21:12:02', NULL),
(181, '87.209.202.146', NULL, '2023-11-27 21:20:29', NULL),
(182, '87.209.202.146', NULL, '2023-11-27 23:15:21', NULL),
(183, '31.223.52.67', NULL, '2023-11-27 23:31:17', NULL),
(184, '31.223.52.67', NULL, '2023-11-28 00:06:46', NULL),
(185, '2a02:4780:a:c0de::84', NULL, '2023-11-28 11:24:31', NULL),
(186, '81.213.110.164', NULL, '2023-11-28 12:01:35', NULL),
(187, '87.209.202.146', NULL, '2023-11-28 16:06:26', NULL),
(188, '81.213.110.164', NULL, '2023-11-28 16:13:53', NULL),
(189, '87.209.202.146', NULL, '2023-11-28 16:18:50', NULL),
(190, '87.209.202.146', NULL, '2023-11-28 18:55:50', NULL),
(191, '87.209.202.146', NULL, '2023-11-29 02:20:44', NULL),
(192, '87.209.202.146', NULL, '2023-11-29 05:03:50', NULL),
(193, '87.209.202.146', NULL, '2023-11-29 06:04:59', NULL),
(194, '2a02:4780:a:c0de::84', NULL, '2023-11-29 11:24:31', NULL),
(195, '87.209.202.146', NULL, '2023-11-29 17:12:15', NULL),
(196, '188.58.96.22', NULL, '2023-11-29 18:41:56', NULL),
(197, '87.209.202.146', NULL, '2023-11-29 22:48:41', NULL),
(198, '31.223.42.160', NULL, '2023-11-30 00:38:39', NULL),
(199, '31.223.42.160', NULL, '2023-11-30 00:39:12', NULL),
(200, '31.223.42.160', NULL, '2023-11-30 03:53:20', NULL),
(201, '2a02:4780:a:c0de::84', NULL, '2023-11-30 11:24:31', NULL),
(202, '87.209.202.146', NULL, '2023-11-30 17:04:31', NULL),
(203, '78.191.86.171', NULL, '2023-12-01 00:17:31', NULL),
(204, '87.209.202.146', NULL, '2023-12-01 00:24:28', NULL),
(205, '87.209.202.146', NULL, '2023-12-01 02:59:34', NULL),
(206, '31.223.56.197', NULL, '2023-12-01 05:30:47', NULL),
(207, '2a02:4780:a:c0de::84', NULL, '2023-12-01 11:24:31', NULL),
(208, '31.223.56.197', NULL, '2023-12-01 14:22:04', NULL),
(209, '159.146.21.106', NULL, '2023-12-01 14:50:33', NULL),
(210, '31.223.56.197', NULL, '2023-12-01 23:24:48', NULL),
(211, '87.209.202.146', NULL, '2023-12-01 23:57:22', NULL),
(212, '31.223.56.197', NULL, '2023-12-02 02:30:18', NULL),
(213, '31.223.56.197', NULL, '2023-12-02 03:27:29', NULL),
(214, '31.223.56.197', NULL, '2023-12-02 03:44:25', NULL),
(215, '31.223.56.197', NULL, '2023-12-02 04:40:14', NULL),
(216, '31.223.56.197', NULL, '2023-12-02 04:43:15', NULL),
(217, '31.223.56.197', NULL, '2023-12-02 04:44:13', NULL),
(218, '31.223.56.197', NULL, '2023-12-02 04:46:19', NULL),
(219, '81.213.110.164', NULL, '2023-12-02 11:04:48', NULL),
(220, '2a02:4780:a:c0de::84', NULL, '2023-12-02 11:24:30', NULL),
(221, '45.128.163.132', NULL, '2023-12-02 12:29:03', NULL),
(222, '87.209.202.146', NULL, '2023-12-02 18:07:56', NULL),
(223, '87.209.202.146', NULL, '2023-12-02 21:11:30', NULL),
(224, '3.110.236.102', NULL, '2023-12-02 23:01:45', NULL),
(225, '31.223.56.197', NULL, '2023-12-03 00:21:30', NULL),
(226, '87.209.202.146', NULL, '2023-12-03 02:03:08', NULL),
(227, '87.209.202.146', NULL, '2023-12-03 02:47:56', NULL),
(228, '2a02:4780:a:c0de::84', NULL, '2023-12-03 06:11:33', NULL),
(229, '31.223.56.197', NULL, '2023-12-03 15:49:40', NULL),
(230, '31.223.56.197', NULL, '2023-12-03 15:49:45', NULL),
(231, '87.209.202.146', NULL, '2023-12-03 17:35:53', NULL),
(232, '87.209.202.146', NULL, '2023-12-03 17:54:35', NULL),
(233, '31.223.56.197', NULL, '2023-12-03 18:18:17', NULL),
(234, '31.223.56.197', NULL, '2023-12-03 18:53:45', NULL),
(235, '31.223.56.197', NULL, '2023-12-03 18:56:27', NULL),
(236, '31.223.56.197', NULL, '2023-12-03 18:57:33', NULL),
(237, '31.223.56.197', NULL, '2023-12-03 18:58:53', NULL),
(238, '31.223.56.197', NULL, '2023-12-03 18:59:13', NULL),
(239, '31.223.56.197', NULL, '2023-12-03 19:06:54', NULL),
(240, '31.223.56.197', NULL, '2023-12-03 19:07:12', NULL),
(241, '31.223.56.197', NULL, '2023-12-03 21:30:10', NULL),
(242, '87.209.202.146', NULL, '2023-12-03 23:59:01', NULL),
(243, '31.223.41.73', NULL, '2023-12-04 02:22:58', NULL),
(244, '87.209.202.146', NULL, '2023-12-04 03:26:22', NULL),
(245, '87.209.202.146', NULL, '2023-12-04 03:28:59', NULL),
(246, '87.209.202.146', NULL, '2023-12-04 03:36:37', NULL),
(247, '87.209.202.146', NULL, '2023-12-04 03:36:44', NULL),
(248, '87.209.202.146', NULL, '2023-12-04 05:58:14', NULL),
(249, '2a02:4780:a:c0de::84', NULL, '2023-12-04 06:11:33', NULL),
(250, '81.213.110.164', NULL, '2023-12-04 11:01:20', NULL),
(251, '31.223.41.73', NULL, '2023-12-04 11:35:17', NULL),
(252, '81.213.110.164', NULL, '2023-12-04 11:40:18', NULL),
(253, '81.213.110.164', NULL, '2023-12-04 14:31:54', NULL),
(254, '81.213.110.164', NULL, '2023-12-04 14:32:21', NULL),
(255, '81.213.110.164', NULL, '2023-12-04 17:09:30', NULL),
(256, '81.213.110.164', NULL, '2023-12-04 17:09:33', NULL),
(257, '81.213.110.164', NULL, '2023-12-04 17:09:37', NULL),
(258, '81.213.110.164', NULL, '2023-12-04 17:12:18', NULL),
(259, '54.229.34.116', NULL, '2023-12-04 18:02:18', NULL),
(260, '87.209.202.146', NULL, '2023-12-04 18:16:26', NULL),
(261, '87.209.202.146', NULL, '2023-12-04 21:25:41', NULL),
(262, '87.209.202.146', NULL, '2023-12-04 23:59:42', NULL),
(263, '54.154.254.68', NULL, '2023-12-05 00:02:10', NULL),
(264, '87.209.202.146', NULL, '2023-12-05 00:28:55', NULL),
(265, '2a02:4780:a:c0de::84', NULL, '2023-12-05 06:11:33', NULL),
(266, '89.205.226.48', NULL, '2023-12-05 18:01:28', NULL),
(267, '87.209.202.146', NULL, '2023-12-05 21:17:43', NULL),
(268, '31.223.41.73', NULL, '2023-12-05 21:34:46', NULL),
(269, '87.209.202.146', NULL, '2023-12-05 21:54:40', NULL),
(270, '87.209.202.146', NULL, '2023-12-05 21:54:49', NULL),
(271, '87.209.202.146', NULL, '2023-12-06 02:49:02', NULL),
(272, '87.209.202.146', NULL, '2023-12-06 04:40:08', NULL),
(273, '2a02:4780:a:c0de::84', NULL, '2023-12-06 06:11:37', NULL),
(274, '81.213.110.164', NULL, '2023-12-06 12:20:35', NULL),
(275, '87.209.202.146', NULL, '2023-12-06 20:29:55', NULL),
(276, '87.209.202.146', NULL, '2023-12-06 22:22:46', NULL),
(277, '87.209.202.146', NULL, '2023-12-06 23:13:51', NULL),
(278, '87.209.202.146', NULL, '2023-12-07 00:36:23', NULL),
(279, '31.223.41.247', NULL, '2023-12-07 02:21:57', NULL),
(280, '2a02:4780:a:c0de::84', NULL, '2023-12-07 06:11:38', NULL),
(281, '81.213.110.164', NULL, '2023-12-07 16:11:55', NULL),
(282, '81.213.110.164', NULL, '2023-12-07 16:23:54', NULL),
(283, '87.209.202.146', NULL, '2023-12-07 18:00:49', NULL),
(284, '87.209.202.146', NULL, '2023-12-07 19:09:56', NULL),
(285, '92.118.39.243', NULL, '2023-12-07 19:14:38', NULL),
(286, '87.209.202.146', NULL, '2023-12-07 19:53:00', NULL),
(287, '31.223.41.247', NULL, '2023-12-07 23:13:37', NULL),
(288, '87.209.202.146', NULL, '2023-12-07 23:39:51', NULL),
(289, '2a06:4880:b000::be', NULL, '2023-12-07 23:54:35', NULL),
(290, '87.209.202.146', NULL, '2023-12-08 01:34:10', NULL),
(291, '2a02:4780:a:c0de::84', NULL, '2023-12-08 06:11:37', NULL),
(292, '176.34.72.79', NULL, '2023-12-08 07:54:52', NULL),
(293, '165.22.39.64', NULL, '2023-12-08 12:48:10', NULL),
(294, '87.209.202.146', NULL, '2023-12-08 15:27:41', NULL),
(295, '81.213.110.164', NULL, '2023-12-08 17:33:20', NULL),
(296, '87.209.202.146', NULL, '2023-12-08 22:30:11', NULL),
(297, '31.223.41.247', NULL, '2023-12-09 01:33:13', NULL),
(298, '87.209.202.146', NULL, '2023-12-09 03:09:10', NULL),
(299, '2a02:4780:a:c0de::84', NULL, '2023-12-09 06:11:33', NULL),
(300, '87.209.202.146', NULL, '2023-12-09 15:02:19', NULL),
(301, '87.209.202.146', NULL, '2023-12-09 18:47:42', NULL),
(302, '45.128.163.132', NULL, '2023-12-09 21:29:31', NULL),
(303, '31.223.41.247', NULL, '2023-12-09 22:07:31', NULL),
(304, '31.223.41.247', NULL, '2023-12-09 22:07:54', NULL),
(305, '176.235.75.4', NULL, '2023-12-09 22:11:46', NULL),
(306, '87.209.202.146', NULL, '2023-12-10 00:12:42', NULL),
(307, '87.209.202.146', NULL, '2023-12-10 04:40:33', NULL),
(308, '87.209.202.146', NULL, '2023-12-10 06:26:55', NULL),
(309, '2a02:4780:a:c0de::84', NULL, '2023-12-10 08:49:10', NULL),
(310, '87.209.202.146', NULL, '2023-12-10 20:01:48', NULL),
(311, '87.209.202.146', NULL, '2023-12-10 22:50:30', NULL),
(312, '87.209.202.146', NULL, '2023-12-10 23:34:05', NULL),
(313, '87.209.202.146', NULL, '2023-12-11 01:55:54', NULL),
(314, '87.209.202.146', NULL, '2023-12-11 03:49:13', NULL),
(315, '2a02:4780:a:c0de::84', NULL, '2023-12-11 08:49:10', NULL),
(316, '87.209.202.146', NULL, '2023-12-11 15:06:04', NULL),
(317, '87.209.202.146', NULL, '2023-12-11 17:57:49', NULL),
(318, '87.209.202.146', NULL, '2023-12-11 20:00:47', NULL),
(319, '87.209.202.146', NULL, '2023-12-12 00:39:59', NULL),
(320, '18.215.159.15', NULL, '2023-12-12 01:08:59', NULL),
(321, '87.209.202.146', NULL, '2023-12-12 02:43:06', NULL),
(322, '87.209.202.146', NULL, '2023-12-12 05:43:42', NULL),
(323, '2a02:4780:a:c0de::84', NULL, '2023-12-12 08:49:14', NULL),
(324, '87.209.202.146', NULL, '2023-12-12 15:33:36', NULL),
(325, '87.209.202.146', NULL, '2023-12-12 16:41:33', NULL),
(326, '87.209.202.146', NULL, '2023-12-12 18:41:09', NULL),
(327, '87.209.202.146', NULL, '2023-12-12 21:34:20', NULL),
(328, '87.209.202.146', NULL, '2023-12-12 22:30:11', NULL),
(329, '87.209.202.146', NULL, '2023-12-12 22:39:48', NULL),
(330, '87.209.202.146', NULL, '2023-12-13 00:45:09', NULL),
(331, '31.223.41.247', NULL, '2023-12-13 01:04:50', NULL),
(332, '87.209.202.146', NULL, '2023-12-13 02:50:24', NULL),
(333, '87.209.202.146', NULL, '2023-12-13 02:51:57', NULL),
(334, '87.209.202.146', NULL, '2023-12-13 05:23:24', NULL),
(335, '2a02:4780:a:c0de::84', NULL, '2023-12-13 08:49:14', NULL),
(336, '81.213.110.164', NULL, '2023-12-13 16:42:22', NULL),
(337, '81.213.110.164', NULL, '2023-12-13 17:12:06', NULL),
(338, '81.213.110.164', NULL, '2023-12-13 18:56:43', NULL),
(339, '87.209.202.146', NULL, '2023-12-13 22:38:57', NULL),
(340, '87.209.202.146', NULL, '2023-12-13 22:42:04', NULL),
(341, '87.209.202.146', NULL, '2023-12-14 00:25:46', NULL),
(342, '87.209.202.146', NULL, '2023-12-14 03:15:07', NULL),
(343, '2a02:4780:a:c0de::84', NULL, '2023-12-14 08:49:14', NULL),
(344, '81.213.110.164', NULL, '2023-12-14 11:41:48', NULL),
(345, '81.213.110.164', NULL, '2023-12-14 12:18:17', NULL),
(346, '159.146.21.106', NULL, '2023-12-14 12:26:31', NULL),
(347, '87.209.202.146', NULL, '2023-12-14 15:02:39', NULL),
(348, '87.209.202.146', NULL, '2023-12-14 20:53:20', NULL),
(349, '87.209.202.146', NULL, '2023-12-14 21:35:34', NULL),
(350, '87.209.202.146', NULL, '2023-12-15 00:27:52', NULL),
(351, '87.209.202.146', NULL, '2023-12-15 00:53:26', NULL),
(352, '87.209.202.146', NULL, '2023-12-15 01:33:27', NULL),
(353, '87.209.202.146', NULL, '2023-12-15 02:04:53', NULL),
(354, '87.209.202.146', NULL, '2023-12-15 05:12:10', NULL),
(355, '2a02:4780:a:c0de::84', NULL, '2023-12-15 08:49:14', NULL),
(356, '87.209.202.146', NULL, '2023-12-15 14:47:09', NULL),
(357, '87.209.202.146', NULL, '2023-12-15 22:37:04', NULL),
(358, '87.209.202.146', NULL, '2023-12-16 00:49:37', NULL),
(359, '31.223.41.247', NULL, '2023-12-16 01:04:32', NULL),
(360, '87.209.202.146', NULL, '2023-12-16 02:55:12', NULL),
(361, '87.209.202.146', NULL, '2023-12-16 04:11:53', NULL),
(362, '2a02:4780:a:c0de::84', NULL, '2023-12-16 08:49:14', NULL),
(363, '87.209.202.146', NULL, '2023-12-16 20:52:58', NULL),
(364, '45.128.163.132', NULL, '2023-12-16 21:34:14', NULL),
(365, '87.209.202.146', NULL, '2023-12-17 03:19:12', NULL),
(366, '87.209.202.146', NULL, '2023-12-17 04:08:00', NULL),
(367, '2a02:4780:a:c0de::84', NULL, '2023-12-17 05:22:45', NULL),
(368, '87.209.202.146', NULL, '2023-12-17 16:48:30', NULL),
(369, '31.223.41.89', NULL, '2023-12-17 18:42:08', NULL),
(370, '87.209.202.146', NULL, '2023-12-17 19:11:42', NULL),
(371, '87.209.202.146', NULL, '2023-12-17 19:14:05', NULL),
(372, '87.209.202.146', NULL, '2023-12-17 22:06:17', NULL),
(373, '87.209.202.146', NULL, '2023-12-18 03:31:09', NULL),
(374, '2a02:4780:a:c0de::84', NULL, '2023-12-18 05:22:44', NULL),
(375, '87.209.202.146', NULL, '2023-12-18 14:20:23', NULL),
(376, '31.223.41.89', NULL, '2023-12-18 17:06:22', NULL),
(377, '2600:1900:4120:e3fb:0:80::', NULL, '2023-12-18 18:27:00', NULL),
(378, '2a02:4780:a:c0de::84', NULL, '2023-12-18 19:13:35', NULL),
(379, '87.209.202.146', NULL, '2023-12-18 21:39:52', NULL),
(380, '87.209.202.146', NULL, '2023-12-18 22:30:48', NULL),
(381, '31.223.41.89', NULL, '2023-12-19 00:22:48', NULL),
(382, '31.223.41.89', NULL, '2023-12-19 02:47:09', NULL),
(383, '31.223.41.89', NULL, '2023-12-19 04:22:40', NULL),
(384, '87.209.202.146', NULL, '2023-12-19 04:32:56', NULL),
(385, '87.209.202.146', NULL, '2023-12-19 05:02:02', NULL),
(386, '87.209.202.146', NULL, '2023-12-19 14:04:45', NULL),
(387, '31.223.41.89', NULL, '2023-12-19 14:28:23', NULL),
(388, '2a02:4780:a:c0de::84', NULL, '2023-12-19 19:13:31', NULL),
(389, '87.209.202.146', NULL, '2023-12-19 20:36:16', NULL),
(390, '87.209.202.146', NULL, '2023-12-19 22:23:33', NULL),
(391, '87.209.202.146', NULL, '2023-12-19 22:41:29', NULL),
(392, '87.209.202.146', NULL, '2023-12-19 22:51:26', NULL),
(393, '87.209.202.146', NULL, '2023-12-19 23:18:01', NULL),
(394, '87.209.202.146', NULL, '2023-12-19 23:23:44', NULL),
(395, '87.209.202.146', NULL, '2023-12-20 03:13:50', NULL),
(396, '87.209.202.146', NULL, '2023-12-20 03:24:39', NULL),
(397, '87.209.202.146', NULL, '2023-12-20 03:34:46', NULL),
(398, '81.213.110.164', NULL, '2023-12-20 17:19:08', NULL),
(399, '66.249.70.197', NULL, '2023-12-20 18:36:51', NULL),
(400, '66.249.70.198', NULL, '2023-12-20 18:36:54', NULL),
(401, '87.209.202.146', NULL, '2023-12-20 18:43:47', NULL),
(402, '2a02:4780:a:c0de::84', NULL, '2023-12-20 19:13:31', NULL),
(403, '87.209.202.146', NULL, '2023-12-20 21:00:56', NULL),
(404, '87.209.202.146', NULL, '2023-12-20 21:05:13', NULL),
(405, '87.209.202.146', NULL, '2023-12-20 21:06:32', NULL),
(406, '87.209.202.146', NULL, '2023-12-20 21:18:55', NULL),
(407, '87.209.202.146', NULL, '2023-12-20 22:14:46', NULL),
(408, '31.223.41.89', NULL, '2023-12-20 22:46:55', NULL),
(409, '87.209.202.146', NULL, '2023-12-21 00:30:27', NULL),
(410, '87.209.202.146', NULL, '2023-12-21 01:38:49', NULL),
(411, '87.209.202.146', NULL, '2023-12-21 01:38:51', NULL),
(412, '81.213.110.164', NULL, '2023-12-21 11:53:27', NULL),
(413, '87.209.202.146', NULL, '2023-12-21 14:46:14', NULL),
(414, '81.213.110.164', NULL, '2023-12-21 17:04:29', NULL),
(415, '81.213.110.164', NULL, '2023-12-21 18:55:13', NULL),
(416, '2a02:4780:a:c0de::84', NULL, '2023-12-21 19:13:31', NULL),
(417, '87.209.202.146', NULL, '2023-12-21 19:31:10', NULL),
(418, '87.209.202.146', NULL, '2023-12-21 19:55:42', NULL),
(419, '31.223.41.89', NULL, '2023-12-21 22:09:04', NULL),
(420, '31.223.41.89', NULL, '2023-12-21 22:09:05', NULL),
(421, '31.223.41.89', NULL, '2023-12-21 22:10:58', NULL),
(422, '87.209.202.146', NULL, '2023-12-22 00:10:24', NULL),
(423, '87.209.202.146', NULL, '2023-12-22 00:28:54', NULL),
(424, '87.209.202.146', NULL, '2023-12-22 00:52:00', NULL),
(425, '87.209.202.146', NULL, '2023-12-22 02:02:23', NULL),
(426, '87.209.202.146', NULL, '2023-12-22 02:59:13', NULL),
(427, '87.209.202.146', NULL, '2023-12-22 04:24:46', NULL),
(428, '87.209.202.146', NULL, '2023-12-22 06:01:00', NULL),
(429, '87.209.202.146', NULL, '2023-12-22 14:21:40', NULL),
(430, '81.213.110.164', NULL, '2023-12-22 15:39:28', NULL),
(431, '81.213.110.164', NULL, '2023-12-22 15:48:20', NULL),
(432, '81.213.110.164', NULL, '2023-12-22 15:49:03', NULL),
(433, '2a02:4780:a:c0de::84', NULL, '2023-12-22 19:13:31', NULL),
(434, '87.209.202.146', NULL, '2023-12-22 19:21:14', NULL),
(435, '87.209.202.146', NULL, '2023-12-22 20:36:24', NULL),
(436, '87.209.202.146', NULL, '2023-12-22 22:29:33', NULL),
(437, '87.209.202.146', NULL, '2023-12-22 22:44:03', NULL),
(438, '31.223.41.89', NULL, '2023-12-22 22:48:04', NULL),
(439, '31.223.41.89', NULL, '2023-12-22 22:51:47', NULL),
(440, '31.223.41.89', NULL, '2023-12-23 00:01:52', NULL),
(441, '87.209.202.146', NULL, '2023-12-23 00:07:35', NULL),
(442, '31.223.41.89', NULL, '2023-12-23 00:12:45', NULL),
(443, '87.209.202.146', NULL, '2023-12-23 02:42:31', NULL),
(444, '87.209.202.146', NULL, '2023-12-23 04:59:41', NULL),
(445, '2a02:4780:a:c0de::84', NULL, '2023-12-23 19:13:31', NULL),
(446, '87.209.202.146', NULL, '2023-12-23 19:47:02', NULL),
(447, '45.128.163.132', NULL, '2023-12-23 21:45:31', NULL),
(448, '87.209.202.146', NULL, '2023-12-23 22:23:44', NULL),
(449, '87.209.202.146', NULL, '2023-12-24 00:26:19', NULL),
(450, '87.209.202.146', NULL, '2023-12-24 01:06:11', NULL),
(451, '2a02:4780:a:c0de::84', NULL, '2023-12-24 06:29:11', NULL),
(452, '87.209.202.146', NULL, '2023-12-24 06:54:05', NULL),
(453, '87.209.202.146', NULL, '2023-12-24 07:02:52', NULL),
(454, '87.209.202.146', NULL, '2023-12-24 20:09:58', NULL),
(455, '87.209.202.146', NULL, '2023-12-24 20:21:53', NULL),
(456, '87.209.202.146', NULL, '2023-12-25 02:58:22', NULL),
(457, '2a02:4780:a:c0de::84', NULL, '2023-12-25 06:29:11', NULL),
(458, '87.209.202.146', NULL, '2023-12-25 16:15:54', NULL),
(459, '87.209.202.146', NULL, '2023-12-25 17:12:42', NULL),
(460, '87.209.202.146', NULL, '2023-12-25 21:43:08', NULL),
(461, '31.223.41.107', NULL, '2023-12-25 22:03:53', NULL),
(462, '87.209.202.146', NULL, '2023-12-26 01:54:36', NULL),
(463, '87.209.202.146', NULL, '2023-12-26 02:22:56', NULL),
(464, '87.209.202.146', NULL, '2023-12-26 03:30:30', NULL),
(465, '87.209.202.146', NULL, '2023-12-26 03:47:19', NULL),
(466, '87.209.202.146', NULL, '2023-12-26 03:59:23', NULL),
(467, '2a02:4780:a:c0de::84', NULL, '2023-12-26 06:29:15', NULL),
(468, '81.213.110.164', NULL, '2023-12-26 12:35:48', NULL),
(469, '159.146.21.106', NULL, '2023-12-26 15:48:29', NULL),
(470, '81.213.110.164', NULL, '2023-12-26 16:16:05', NULL),
(471, '81.213.110.164', NULL, '2023-12-26 16:21:48', NULL),
(472, '87.209.202.146', NULL, '2023-12-26 17:24:33', NULL),
(473, '87.209.202.146', NULL, '2023-12-26 19:14:59', NULL),
(474, '87.209.202.146', NULL, '2023-12-26 19:16:16', NULL),
(475, '87.209.202.146', NULL, '2023-12-26 19:17:54', NULL),
(476, '87.209.202.146', NULL, '2023-12-26 21:57:39', NULL),
(477, '87.209.202.146', NULL, '2023-12-26 23:02:06', NULL),
(478, '87.209.202.146', NULL, '2023-12-27 00:08:58', NULL),
(479, '87.209.202.146', NULL, '2023-12-27 02:54:23', NULL),
(480, '87.209.202.146', NULL, '2023-12-27 03:02:47', NULL),
(481, '87.209.202.146', NULL, '2023-12-27 03:59:09', NULL),
(482, '2a02:4780:a:c0de::84', NULL, '2023-12-27 06:29:11', NULL),
(483, '87.209.202.146', NULL, '2023-12-27 18:02:49', NULL),
(484, '87.209.202.146', NULL, '2023-12-27 19:43:38', NULL),
(485, '87.209.202.146', NULL, '2023-12-27 20:19:44', NULL),
(486, '87.209.202.146', NULL, '2023-12-28 02:10:07', NULL),
(487, '2a02:4780:a:c0de::84', NULL, '2023-12-28 06:29:15', NULL),
(488, '87.209.202.146', NULL, '2023-12-28 17:01:23', NULL),
(489, '87.209.202.146', NULL, '2023-12-28 23:04:26', NULL),
(490, '31.223.41.215', NULL, '2023-12-28 23:29:52', NULL),
(491, '87.209.202.146', NULL, '2023-12-29 00:07:10', NULL),
(492, '87.209.202.146', NULL, '2023-12-29 05:11:09', NULL),
(493, '87.209.202.146', NULL, '2023-12-29 05:33:07', NULL),
(494, '2a02:4780:a:c0de::84', NULL, '2023-12-29 06:29:10', NULL),
(495, '2a06:4880:7000::75', NULL, '2023-12-29 12:56:08', NULL),
(496, '87.209.202.146', NULL, '2023-12-29 16:16:58', NULL),
(497, '87.209.202.146', NULL, '2023-12-29 17:21:15', NULL),
(498, '87.209.202.146', NULL, '2023-12-29 21:54:38', NULL),
(499, '87.209.202.146', NULL, '2023-12-29 21:58:45', NULL),
(500, '87.209.202.146', NULL, '2023-12-29 22:09:44', NULL),
(501, '87.209.202.146', NULL, '2023-12-29 22:52:52', NULL),
(502, '87.209.202.146', NULL, '2023-12-30 02:03:24', NULL),
(503, '87.209.202.146', NULL, '2023-12-30 03:26:46', NULL),
(504, '87.209.202.146', NULL, '2023-12-30 03:32:13', NULL),
(505, '2a02:4780:a:c0de::84', NULL, '2023-12-30 06:29:10', NULL),
(506, '87.209.202.146', NULL, '2023-12-30 22:37:07', NULL),
(507, '87.209.202.146', NULL, '2023-12-30 23:55:38', NULL),
(508, '87.209.202.146', NULL, '2023-12-31 01:43:46', NULL),
(509, '87.209.202.146', NULL, '2023-12-31 01:50:02', NULL),
(510, '87.209.202.146', NULL, '2023-12-31 01:50:20', NULL),
(511, '87.209.202.146', NULL, '2023-12-31 01:58:19', NULL),
(512, '87.209.202.146', NULL, '2023-12-31 02:22:37', NULL),
(513, '87.209.202.146', NULL, '2023-12-31 03:59:00', NULL),
(514, '2a02:4780:a:c0de::84', NULL, '2023-12-31 07:40:57', NULL),
(515, '87.209.202.146', NULL, '2023-12-31 16:01:27', NULL),
(516, '87.209.202.146', NULL, '2023-12-31 16:22:57', NULL),
(517, '87.209.202.146', NULL, '2023-12-31 23:56:14', NULL),
(518, '87.209.202.146', NULL, '2024-01-01 01:16:13', NULL),
(519, '87.209.202.146', NULL, '2024-01-01 04:54:45', NULL),
(520, '2a02:4780:a:c0de::84', NULL, '2024-01-01 07:41:01', NULL),
(521, '87.209.202.146', NULL, '2024-01-01 20:51:04', NULL),
(522, '3.254.189.63', NULL, '2024-01-01 22:18:11', NULL),
(523, '31.223.52.178', NULL, '2024-01-01 22:49:15', NULL),
(524, '31.223.52.178', NULL, '2024-01-01 22:49:22', NULL),
(525, '31.223.52.178', NULL, '2024-01-01 23:07:53', NULL),
(526, '87.209.202.146', NULL, '2024-01-02 00:02:10', NULL),
(527, '2a02:4780:a:c0de::84', NULL, '2024-01-02 07:41:01', NULL),
(528, '87.209.202.146', NULL, '2024-01-03 00:33:07', NULL),
(529, '87.209.202.146', NULL, '2024-01-03 05:10:48', NULL),
(530, '87.209.202.146', NULL, '2024-01-03 06:14:16', NULL),
(531, '87.209.202.146', NULL, '2024-01-03 06:19:44', NULL),
(532, '2a02:4780:a:c0de::84', NULL, '2024-01-03 07:40:57', NULL),
(533, '81.213.110.164', NULL, '2024-01-03 11:07:43', NULL),
(534, '81.213.110.164', NULL, '2024-01-03 11:07:43', NULL),
(535, '81.213.110.164', NULL, '2024-01-03 11:07:45', NULL),
(536, '87.209.202.146', NULL, '2024-01-03 14:50:26', NULL),
(537, '87.209.202.146', NULL, '2024-01-03 14:50:53', NULL),
(538, '87.209.202.146', NULL, '2024-01-03 19:51:41', NULL),
(539, '87.209.202.146', NULL, '2024-01-03 19:51:45', NULL),
(540, '87.209.202.146', NULL, '2024-01-03 23:06:25', NULL),
(541, '87.209.202.146', NULL, '2024-01-04 00:05:36', NULL),
(542, '2a02:4780:a:c0de::84', NULL, '2024-01-04 07:41:01', NULL),
(543, '2a03:b0c0:1:d0::2d0:a001', NULL, '2024-01-04 08:46:46', NULL),
(544, '2a03:b0c0:1:d0::2d0:a001', NULL, '2024-01-04 08:46:47', NULL),
(545, '65.154.226.170', NULL, '2024-01-04 08:46:55', NULL),
(546, '205.169.39.85', NULL, '2024-01-04 08:47:02', NULL),
(547, '146.70.197.235', NULL, '2024-01-04 08:47:41', NULL),
(548, '205.169.39.85', NULL, '2024-01-04 08:47:59', NULL),
(549, '80.94.92.37', NULL, '2024-01-04 08:48:01', NULL),
(550, '80.94.92.37', NULL, '2024-01-04 08:50:37', NULL),
(551, '133.242.174.119', NULL, '2024-01-04 11:45:57', NULL),
(552, '65.21.65.198', NULL, '2024-01-04 13:49:58', NULL),
(553, '87.209.202.146', NULL, '2024-01-04 19:56:55', NULL),
(554, '87.209.202.146', NULL, '2024-01-04 20:25:03', NULL),
(555, '87.209.202.146', NULL, '2024-01-04 20:25:31', NULL),
(556, '47.88.87.97', NULL, '2024-01-04 20:51:53', NULL),
(557, '104.164.173.200', NULL, '2024-01-04 21:16:47', NULL),
(558, '154.28.229.145', NULL, '2024-01-04 21:16:52', NULL),
(559, '87.209.202.146', NULL, '2024-01-04 22:20:24', NULL),
(560, '31.223.52.76', NULL, '2024-01-04 23:33:53', NULL),
(561, '87.209.202.146', NULL, '2024-01-05 00:36:02', NULL),
(562, '87.209.202.146', NULL, '2024-01-05 00:36:04', NULL),
(563, '87.209.202.146', NULL, '2024-01-05 04:04:11', NULL),
(564, '87.209.202.146', NULL, '2024-01-05 04:10:27', NULL),
(565, '2a02:4780:a:c0de::84', NULL, '2024-01-05 07:41:01', NULL),
(566, '81.213.110.164', NULL, '2024-01-05 15:21:33', NULL),
(567, '81.213.110.164', NULL, '2024-01-05 15:21:35', NULL),
(568, '81.213.110.164', NULL, '2024-01-05 15:22:59', NULL),
(569, '87.209.202.146', NULL, '2024-01-05 16:04:26', NULL),
(570, '159.223.6.21', NULL, '2024-01-05 18:16:34', NULL),
(571, '50.18.103.201', NULL, '2024-01-05 20:08:25', NULL),
(572, '87.209.202.146', NULL, '2024-01-05 20:55:23', NULL),
(573, '87.209.202.146', NULL, '2024-01-05 22:53:52', NULL),
(574, '87.209.202.146', NULL, '2024-01-05 23:53:48', NULL),
(575, '87.209.202.146', NULL, '2024-01-06 00:22:03', NULL),
(576, '87.209.202.146', NULL, '2024-01-06 03:24:50', NULL),
(577, '2a02:4780:a:c0de::84', NULL, '2024-01-06 07:41:01', NULL),
(578, '104.234.204.32', NULL, '2024-01-06 15:15:02', NULL),
(579, '3.252.221.24', NULL, '2024-01-06 15:44:58', NULL),
(580, '87.209.202.146', NULL, '2024-01-06 20:46:43', NULL),
(581, '87.209.202.146', NULL, '2024-01-06 20:51:30', NULL),
(582, '87.209.202.146', NULL, '2024-01-06 21:07:42', NULL),
(583, '176.235.75.4', NULL, '2024-01-06 23:30:04', NULL),
(584, '87.209.202.146', NULL, '2024-01-06 23:50:39', NULL),
(585, '87.209.202.146', NULL, '2024-01-07 01:42:03', NULL),
(586, '87.209.202.146', NULL, '2024-01-07 02:09:51', NULL),
(587, '2a02:4780:a:c0de::84', NULL, '2024-01-07 03:49:36', NULL),
(588, '87.209.202.146', NULL, '2024-01-07 04:37:33', NULL),
(589, '3.248.181.4', NULL, '2024-01-07 14:56:47', NULL),
(590, '87.209.202.146', NULL, '2024-01-07 20:50:02', NULL),
(591, '87.209.202.146', NULL, '2024-01-07 20:50:10', NULL),
(592, '45.128.163.132', NULL, '2024-01-07 21:58:03', NULL),
(593, '87.209.202.146', NULL, '2024-01-08 00:12:50', NULL),
(594, '2a02:4780:a:c0de::84', NULL, '2024-01-08 03:49:35', NULL),
(595, '95.142.107.4', NULL, '2024-01-08 15:03:16', NULL),
(596, '31.223.41.57', NULL, '2024-01-08 22:41:52', NULL),
(597, '31.223.41.57', NULL, '2024-01-09 00:41:26', NULL),
(598, '2a02:4780:a:c0de::84', NULL, '2024-01-09 03:49:32', NULL),
(599, '87.209.202.146', NULL, '2024-01-09 04:58:16', NULL),
(600, '87.209.202.146', NULL, '2024-01-09 14:20:08', NULL),
(601, '87.209.202.146', NULL, '2024-01-09 23:47:41', NULL),
(602, '31.223.41.57', NULL, '2024-01-09 23:53:23', NULL),
(603, '87.209.202.146', NULL, '2024-01-10 00:50:25', NULL),
(604, '31.223.41.57', NULL, '2024-01-10 01:43:23', NULL),
(605, '31.223.41.57', NULL, '2024-01-10 01:43:25', NULL),
(606, '87.209.202.146', NULL, '2024-01-10 02:33:16', NULL),
(607, '2a02:4780:a:c0de::84', NULL, '2024-01-10 03:49:34', NULL),
(608, '81.213.110.164', NULL, '2024-01-10 17:03:03', NULL),
(609, '87.209.202.146', NULL, '2024-01-10 20:44:43', NULL),
(610, '31.223.41.57', NULL, '2024-01-10 21:26:42', NULL),
(611, '31.223.56.27', NULL, '2024-01-10 23:42:05', NULL),
(612, '87.209.202.146', NULL, '2024-01-11 00:10:58', NULL),
(613, '87.209.202.146', NULL, '2024-01-11 00:15:08', NULL),
(614, '87.209.202.146', NULL, '2024-01-11 03:37:15', NULL),
(615, '2a02:4780:a:c0de::84', NULL, '2024-01-11 03:49:31', NULL),
(616, '87.209.202.146', NULL, '2024-01-11 04:00:24', NULL),
(617, '87.209.202.146', NULL, '2024-01-11 14:46:01', NULL),
(618, '87.209.202.146', NULL, '2024-01-11 21:29:44', NULL),
(619, '31.223.56.27', NULL, '2024-01-11 23:26:45', NULL),
(620, '87.209.202.146', NULL, '2024-01-12 02:35:39', NULL),
(621, '44.228.80.90', NULL, '2024-01-12 03:24:03', NULL),
(622, '2a02:4780:a:c0de::84', NULL, '2024-01-12 03:49:31', NULL),
(623, '31.223.56.27', NULL, '2024-01-12 04:23:47', NULL),
(624, '64.23.166.15', NULL, '2024-01-12 06:18:34', NULL),
(625, '87.209.202.146', NULL, '2024-01-12 16:03:31', NULL),
(626, '81.213.110.164', NULL, '2024-01-12 18:02:34', NULL),
(627, '87.209.202.146', NULL, '2024-01-12 20:32:37', NULL),
(628, '31.223.56.27', NULL, '2024-01-12 22:22:14', NULL),
(629, '87.209.202.146', NULL, '2024-01-12 23:12:27', NULL),
(630, '87.209.202.146', NULL, '2024-01-13 00:49:30', NULL),
(631, '2a02:4780:a:c0de::84', NULL, '2024-01-13 03:49:32', NULL),
(632, '87.209.202.146', NULL, '2024-01-13 03:53:19', NULL),
(633, '87.209.202.146', NULL, '2024-01-13 20:51:31', NULL),
(634, '31.223.56.27', NULL, '2024-01-13 20:53:15', NULL),
(635, '45.128.163.132', NULL, '2024-01-13 22:38:35', NULL),
(636, '87.209.202.146', NULL, '2024-01-14 03:18:09', NULL),
(637, '87.209.202.146', NULL, '2024-01-14 05:05:59', NULL),
(638, '18.200.206.23', NULL, '2024-01-14 05:30:22', NULL),
(639, '199.115.100.128', NULL, '2024-01-14 05:30:33', NULL),
(640, '85.239.39.110', NULL, '2024-01-14 05:30:33', NULL),
(641, '85.239.50.138', NULL, '2024-01-14 05:31:01', NULL),
(642, '23.20.233.179', NULL, '2024-01-14 05:35:05', NULL),
(643, '2a02:4780:a:c0de::84', NULL, '2024-01-14 09:23:07', NULL),
(644, '31.223.56.27', NULL, '2024-01-14 13:32:04', NULL),
(645, '87.209.202.146', NULL, '2024-01-14 15:41:29', NULL),
(646, '87.209.202.146', NULL, '2024-01-14 20:26:05', NULL),
(647, '195.211.77.142', NULL, '2024-01-14 22:29:33', NULL),
(648, '87.209.202.146', NULL, '2024-01-15 03:54:26', NULL),
(649, '87.209.202.146', NULL, '2024-01-15 03:54:33', NULL),
(650, '2a02:4780:a:c0de::84', NULL, '2024-01-15 09:23:07', NULL),
(651, '89.205.227.243', NULL, '2024-01-15 13:10:44', NULL),
(652, '87.209.202.146', NULL, '2024-01-16 00:09:35', NULL),
(653, '31.223.52.129', NULL, '2024-01-16 00:11:52', NULL),
(654, '31.223.52.129', NULL, '2024-01-16 01:43:29', NULL),
(655, '87.209.202.146', NULL, '2024-01-16 02:36:07', NULL),
(656, '2a02:4780:a:c0de::84', NULL, '2024-01-16 09:23:07', NULL),
(657, '87.209.202.146', NULL, '2024-01-16 17:34:57', NULL),
(658, '78.191.169.1', NULL, '2024-01-16 21:13:12', NULL),
(659, '78.191.169.1', NULL, '2024-01-16 21:13:13', NULL),
(660, '78.191.169.1', NULL, '2024-01-16 21:26:58', NULL),
(661, '2a02:4780:a:c0de::84', NULL, '2024-01-17 09:23:03', NULL),
(662, '81.213.110.164', NULL, '2024-01-17 15:58:02', NULL),
(663, '81.213.110.164', NULL, '2024-01-17 18:33:47', NULL),
(664, '87.209.202.146', NULL, '2024-01-17 19:15:39', NULL),
(665, '167.94.138.51', NULL, '2024-01-17 22:14:54', NULL),
(666, '85.101.52.85', NULL, '2024-01-17 22:54:38', NULL),
(667, '31.223.42.128', NULL, '2024-01-17 22:54:40', NULL),
(668, '31.223.42.128', NULL, '2024-01-17 22:54:43', NULL),
(669, '31.223.42.128', NULL, '2024-01-17 22:54:46', NULL),
(670, '87.209.202.146', NULL, '2024-01-18 02:07:30', NULL),
(671, '2a02:4780:a:c0de::84', NULL, '2024-01-18 09:23:10', NULL),
(672, '81.213.110.164', NULL, '2024-01-18 17:53:09', NULL),
(673, '81.213.110.164', NULL, '2024-01-18 18:19:49', NULL),
(674, '31.223.42.128', NULL, '2024-01-18 22:38:09', NULL),
(675, '31.223.42.128', NULL, '2024-01-18 22:38:36', NULL),
(676, '31.223.42.128', NULL, '2024-01-18 22:39:56', NULL),
(677, '87.209.202.146', NULL, '2024-01-18 23:30:55', NULL),
(678, '31.223.42.128', NULL, '2024-01-18 23:44:44', NULL),
(679, '31.223.42.128', NULL, '2024-01-18 23:53:31', NULL),
(680, '87.209.202.146', NULL, '2024-01-19 02:36:39', NULL),
(681, '2a02:4780:a:c0de::84', NULL, '2024-01-19 09:23:07', NULL),
(682, '87.209.202.146', NULL, '2024-01-19 11:42:30', NULL),
(683, '87.209.202.146', NULL, '2024-01-19 19:11:46', NULL),
(684, '31.223.42.128', NULL, '2024-01-19 23:27:47', NULL),
(685, '31.223.42.128', NULL, '2024-01-20 01:10:32', NULL),
(686, '87.209.202.146', NULL, '2024-01-20 01:23:42', NULL),
(687, '31.223.42.128', NULL, '2024-01-20 01:24:17', NULL),
(688, '87.209.202.146', NULL, '2024-01-20 01:25:10', NULL),
(689, '31.223.42.128', NULL, '2024-01-20 02:01:13', NULL),
(690, '31.223.42.128', NULL, '2024-01-20 02:21:14', NULL),
(691, '2a02:4780:a:c0de::84', NULL, '2024-01-20 09:23:08', NULL),
(692, '87.209.202.146', NULL, '2024-01-20 16:15:51', NULL),
(693, '31.223.42.128', NULL, '2024-01-21 00:27:04', NULL),
(694, '31.223.42.128', NULL, '2024-01-21 00:31:32', NULL),
(695, '31.223.42.128', NULL, '2024-01-21 00:37:02', NULL),
(696, '45.128.163.132', NULL, '2024-01-21 02:27:44', NULL),
(697, '31.223.42.128', NULL, '2024-01-21 02:28:05', NULL),
(698, '31.223.42.128', NULL, '2024-01-21 02:49:05', NULL),
(699, '87.209.202.146', NULL, '2024-01-21 02:52:20', NULL),
(700, '87.209.202.146', NULL, '2024-01-21 02:59:55', NULL),
(701, '31.223.42.128', NULL, '2024-01-21 03:27:23', NULL),
(702, '31.223.42.128', NULL, '2024-01-21 03:53:26', NULL),
(703, '31.223.42.128', NULL, '2024-01-21 04:34:47', NULL),
(704, '31.223.42.128', NULL, '2024-01-21 05:17:36', NULL),
(705, '2a02:4780:a:c0de::84', NULL, '2024-01-21 10:46:45', NULL),
(706, '45.128.160.157', NULL, '2024-01-21 17:25:15', NULL),
(707, '31.223.42.128', NULL, '2024-01-21 19:22:39', NULL),
(708, '87.209.202.146', NULL, '2024-01-22 00:25:23', NULL),
(709, '87.209.202.146', NULL, '2024-01-22 03:40:13', NULL),
(710, '87.209.202.146', NULL, '2024-01-22 03:40:25', NULL),
(711, '31.223.42.128', NULL, '2024-01-22 08:08:08', NULL),
(712, '31.223.42.128', NULL, '2024-01-22 08:11:35', NULL),
(713, '2a02:4780:a:c0de::84', NULL, '2024-01-22 10:46:45', NULL),
(714, '81.213.110.164', NULL, '2024-01-22 14:16:44', NULL),
(715, '87.209.202.146', NULL, '2024-01-23 02:11:49', NULL),
(716, '2a02:4780:a:c0de::84', NULL, '2024-01-23 10:46:47', NULL),
(717, '87.209.202.146', NULL, '2024-01-23 12:22:12', NULL),
(718, '87.209.202.146', NULL, '2024-01-23 22:27:22', NULL),
(719, '87.209.202.146', NULL, '2024-01-23 22:27:57', NULL),
(720, '2a02:4780:a:c0de::84', NULL, '2024-01-24 10:46:49', NULL),
(721, '87.209.202.146', NULL, '2024-01-24 21:25:18', NULL),
(722, '87.209.202.146', NULL, '2024-01-25 01:09:01', NULL),
(723, '2a02:4780:a:c0de::84', NULL, '2024-01-25 10:46:58', NULL),
(724, '81.213.110.164', NULL, '2024-01-25 12:13:04', NULL),
(725, '87.209.202.146', NULL, '2024-01-25 13:18:47', NULL),
(726, '87.209.202.146', NULL, '2024-01-25 19:42:39', NULL),
(727, '65.154.226.169', NULL, '2024-01-25 21:15:17', NULL),
(728, '87.209.202.146', NULL, '2024-01-26 00:31:41', NULL),
(729, '87.209.202.146', NULL, '2024-01-26 00:45:01', NULL),
(730, '87.209.202.146', NULL, '2024-01-26 02:21:04', NULL),
(731, '87.209.202.146', NULL, '2024-01-26 02:51:16', NULL),
(732, '207.154.254.252', NULL, '2024-01-26 05:05:00', NULL),
(733, '2a02:4780:a:c0de::84', NULL, '2024-01-26 10:47:03', NULL),
(734, '31.223.42.128', NULL, '2024-01-26 18:05:11', NULL),
(735, '31.223.42.128', NULL, '2024-01-26 18:09:44', NULL),
(736, '31.223.42.128', NULL, '2024-01-26 20:51:42', NULL),
(737, '87.209.202.146', NULL, '2024-01-26 21:36:06', NULL),
(738, '31.223.42.128', NULL, '2024-01-26 22:16:53', NULL),
(739, '31.223.42.128', NULL, '2024-01-26 23:28:10', NULL),
(740, '87.209.202.146', NULL, '2024-01-26 23:30:21', NULL),
(741, '31.223.42.128', NULL, '2024-01-26 23:30:41', NULL),
(742, '31.223.42.128', NULL, '2024-01-26 23:36:52', NULL),
(743, '87.209.202.146', NULL, '2024-01-27 00:02:42', NULL),
(744, '31.223.42.128', NULL, '2024-01-27 00:28:24', NULL),
(745, '31.223.42.128', NULL, '2024-01-27 00:29:17', NULL),
(746, '74.125.215.71', NULL, '2024-01-27 00:42:02', NULL),
(747, '74.125.215.70', NULL, '2024-01-27 00:42:29', NULL),
(748, '74.125.215.69', NULL, '2024-01-27 00:42:45', NULL),
(749, '74.125.215.70', NULL, '2024-01-27 00:43:07', NULL),
(750, '74.125.215.69', NULL, '2024-01-27 00:44:14', NULL),
(751, '74.125.210.199', NULL, '2024-01-27 00:51:14', NULL),
(752, '87.209.202.146', NULL, '2024-01-27 01:08:09', NULL),
(753, '66.249.66.88', NULL, '2024-01-27 01:38:19', NULL),
(754, '87.209.202.146', NULL, '2024-01-27 01:56:43', NULL),
(755, '87.209.202.146', NULL, '2024-01-27 00:10:15', NULL),
(756, '2a02:4780:a:c0de::84', NULL, '2024-01-27 08:46:56', NULL),
(757, '87.209.202.146', NULL, '2024-01-27 11:31:55', NULL),
(758, '87.209.202.146', NULL, '2024-01-27 11:36:46', NULL),
(759, '77.131.42.252', NULL, '2024-01-27 12:08:53', NULL),
(760, '2a01:cb11:83b:1000:f9cc:bbec:f3af:fed3', NULL, '2024-01-27 12:17:45', NULL),
(761, '2a01:cb11:83b:1000:f9cc:bbec:f3af:fed3', NULL, '2024-01-27 12:17:46', NULL),
(762, '87.209.202.146', NULL, '2024-01-27 13:31:46', NULL),
(763, '87.209.202.146', NULL, '2024-01-27 16:51:04', NULL),
(764, '87.209.202.146', NULL, '2024-01-27 18:03:38', NULL),
(765, '45.128.163.132', NULL, '2024-01-27 23:58:42', NULL),
(766, '2a02:4780:a:c0de::84', NULL, '2024-01-28 02:30:12', NULL),
(767, '87.209.202.146', NULL, '2024-01-28 13:28:12', NULL),
(768, '87.209.202.146', NULL, '2024-01-28 17:54:40', NULL),
(769, '87.209.202.146', NULL, '2024-01-28 20:43:57', NULL),
(770, '87.209.202.146', NULL, '2024-01-28 20:48:54', NULL),
(771, '31.223.42.128', NULL, '2024-01-28 21:56:05', NULL),
(772, '2a02:4780:a:c0de::84', NULL, '2024-01-29 02:30:10', NULL),
(773, '87.209.202.146', NULL, '2024-01-29 22:59:17', NULL),
(774, '54.167.36.155', NULL, '2024-01-30 02:06:40', NULL),
(775, '2a02:4780:a:c0de::84', NULL, '2024-01-30 02:30:11', NULL),
(776, '87.209.202.146', NULL, '2024-01-30 02:45:35', NULL),
(777, '87.209.202.146', NULL, '2024-01-30 02:57:02', NULL),
(778, '87.209.202.146', NULL, '2024-01-30 02:57:19', NULL),
(779, '196.153.200.56', NULL, '2024-01-30 02:58:52', NULL),
(780, '87.209.202.146', NULL, '2024-01-30 03:08:00', NULL),
(781, '196.153.55.50', NULL, '2024-01-30 10:47:25', NULL),
(782, '81.213.110.164', NULL, '2024-01-30 15:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `help_topics`
--

CREATE TABLE `help_topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `ranking` int(11) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `help_topics`
--

INSERT INTO `help_topics` (`id`, `question`, `answer`, `ranking`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Does Euromarketn.com offer wholesale services?', 'Yes, we provide wholesale services. You can find details about the minimum order quantity and shipping terms on the product pages.', 1, 1, '2023-12-28 23:38:38', '2023-12-28 23:38:38'),
(2, 'How can I cancel my order?', 'You can cancel your order within [number of hours or days, e.g., 24 hours] of placing it. Please contact customer service at info@euromarketn.com or 0031613005511.', 2, 1, '2023-12-28 23:39:05', '2023-12-28 23:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_point_transactions`
--

CREATE TABLE `loyalty_point_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` char(36) NOT NULL,
  `credit` decimal(24,3) NOT NULL DEFAULT 0.000,
  `debit` decimal(24,3) NOT NULL DEFAULT 0.000,
  `balance` decimal(24,3) NOT NULL DEFAULT 0.000,
  `reference` varchar(191) DEFAULT NULL,
  `transaction_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_09_08_105159_create_admins_table', 1),
(5, '2020_09_08_111837_create_admin_roles_table', 1),
(6, '2020_09_16_142451_create_categories_table', 2),
(7, '2020_09_16_181753_create_categories_table', 3),
(8, '2020_09_17_134238_create_brands_table', 4),
(9, '2020_09_17_203054_create_attributes_table', 5),
(10, '2020_09_19_112509_create_coupons_table', 6),
(11, '2020_09_19_161802_create_curriencies_table', 7),
(12, '2020_09_20_114509_create_sellers_table', 8),
(13, '2020_09_23_113454_create_shops_table', 9),
(14, '2020_09_23_115615_create_shops_table', 10),
(15, '2020_09_23_153822_create_shops_table', 11),
(16, '2020_09_21_122817_create_products_table', 12),
(17, '2020_09_22_140800_create_colors_table', 12),
(18, '2020_09_28_175020_create_products_table', 13),
(19, '2020_09_28_180311_create_products_table', 14),
(20, '2020_10_04_105041_create_search_functions_table', 15),
(21, '2020_10_05_150730_create_customers_table', 15),
(22, '2020_10_08_133548_create_wishlists_table', 16),
(23, '2016_06_01_000001_create_oauth_auth_codes_table', 17),
(24, '2016_06_01_000002_create_oauth_access_tokens_table', 17),
(25, '2016_06_01_000003_create_oauth_refresh_tokens_table', 17),
(26, '2016_06_01_000004_create_oauth_clients_table', 17),
(27, '2016_06_01_000005_create_oauth_personal_access_clients_table', 17),
(28, '2020_10_06_133710_create_product_stocks_table', 17),
(29, '2020_10_06_134636_create_flash_deals_table', 17),
(30, '2020_10_06_134719_create_flash_deal_products_table', 17),
(31, '2020_10_08_115439_create_orders_table', 17),
(32, '2020_10_08_115453_create_order_details_table', 17),
(33, '2020_10_08_121135_create_shipping_addresses_table', 17),
(34, '2020_10_10_171722_create_business_settings_table', 17),
(35, '2020_09_19_161802_create_currencies_table', 18),
(36, '2020_10_12_152350_create_reviews_table', 18),
(37, '2020_10_12_161834_create_reviews_table', 19),
(38, '2020_10_12_180510_create_support_tickets_table', 20),
(39, '2020_10_14_140130_create_transactions_table', 21),
(40, '2020_10_14_143553_create_customer_wallets_table', 21),
(41, '2020_10_14_143607_create_customer_wallet_histories_table', 21),
(42, '2020_10_22_142212_create_support_ticket_convs_table', 21),
(43, '2020_10_24_234813_create_banners_table', 22),
(44, '2020_10_27_111557_create_shipping_methods_table', 23),
(45, '2020_10_27_114154_add_url_to_banners_table', 24),
(46, '2020_10_28_170308_add_shipping_id_to_order_details', 25),
(47, '2020_11_02_140528_add_discount_to_order_table', 26),
(48, '2020_11_03_162723_add_column_to_order_details', 27),
(49, '2020_11_08_202351_add_url_to_banners_table', 28),
(50, '2020_11_10_112713_create_help_topic', 29),
(51, '2020_11_10_141513_create_contacts_table', 29),
(52, '2020_11_15_180036_add_address_column_user_table', 30),
(53, '2020_11_18_170209_add_status_column_to_product_table', 31),
(54, '2020_11_19_115453_add_featured_status_product', 32),
(55, '2020_11_21_133302_create_deal_of_the_days_table', 33),
(56, '2020_11_20_172332_add_product_id_to_products', 34),
(57, '2020_11_27_234439_add__state_to_shipping_addresses', 34),
(58, '2020_11_28_091929_create_chattings_table', 35),
(59, '2020_12_02_011815_add_bank_info_to_sellers', 36),
(60, '2020_12_08_193234_create_social_medias_table', 37),
(61, '2020_12_13_122649_shop_id_to_chattings', 37),
(62, '2020_12_14_145116_create_seller_wallet_histories_table', 38),
(63, '2020_12_14_145127_create_seller_wallets_table', 38),
(64, '2020_12_15_174804_create_admin_wallets_table', 39),
(65, '2020_12_15_174821_create_admin_wallet_histories_table', 39),
(66, '2020_12_15_214312_create_feature_deals_table', 40),
(67, '2020_12_17_205712_create_withdraw_requests_table', 41),
(68, '2021_02_22_161510_create_notifications_table', 42),
(69, '2021_02_24_154706_add_deal_type_to_flash_deals', 43),
(70, '2021_03_03_204349_add_cm_firebase_token_to_users', 44),
(71, '2021_04_17_134848_add_column_to_order_details_stock', 45),
(72, '2021_05_12_155401_add_auth_token_seller', 46),
(73, '2021_06_03_104531_ex_rate_update', 47),
(74, '2021_06_03_222413_amount_withdraw_req', 48),
(75, '2021_06_04_154501_seller_wallet_withdraw_bal', 49),
(76, '2021_06_04_195853_product_dis_tax', 50),
(77, '2021_05_27_103505_create_product_translations_table', 51),
(78, '2021_06_17_054551_create_soft_credentials_table', 51),
(79, '2021_06_29_212549_add_active_col_user_table', 52),
(80, '2021_06_30_212619_add_col_to_contact', 53),
(81, '2021_07_01_160828_add_col_daily_needs_products', 54),
(82, '2021_07_04_182331_add_col_seller_sales_commission', 55),
(83, '2021_08_07_190655_add_seo_columns_to_products', 56),
(84, '2021_08_07_205913_add_col_to_category_table', 56),
(85, '2021_08_07_210808_add_col_to_shops_table', 56),
(86, '2021_08_14_205216_change_product_price_col_type', 56),
(87, '2021_08_16_201505_change_order_price_col', 56),
(88, '2021_08_16_201552_change_order_details_price_col', 56),
(89, '2019_09_29_154000_create_payment_cards_table', 57),
(90, '2021_08_17_213934_change_col_type_seller_earning_history', 57),
(91, '2021_08_17_214109_change_col_type_admin_earning_history', 57),
(92, '2021_08_17_214232_change_col_type_admin_wallet', 57),
(93, '2021_08_17_214405_change_col_type_seller_wallet', 57),
(94, '2021_08_22_184834_add_publish_to_products_table', 57),
(95, '2021_09_08_211832_add_social_column_to_users_table', 57),
(96, '2021_09_13_165535_add_col_to_user', 57),
(97, '2021_09_19_061647_add_limit_to_coupons_table', 57),
(98, '2021_09_20_020716_add_coupon_code_to_orders_table', 57),
(99, '2021_09_23_003059_add_gst_to_sellers_table', 57),
(100, '2021_09_28_025411_create_order_transactions_table', 57),
(101, '2021_10_02_185124_create_carts_table', 57),
(102, '2021_10_02_190207_create_cart_shippings_table', 57),
(103, '2021_10_03_194334_add_col_order_table', 57),
(104, '2021_10_03_200536_add_shipping_cost', 57),
(105, '2021_10_04_153201_add_col_to_order_table', 57),
(106, '2021_10_07_172701_add_col_cart_shop_info', 57),
(107, '2021_10_07_184442_create_phone_or_email_verifications_table', 57),
(108, '2021_10_07_185416_add_user_table_email_verified', 57),
(109, '2021_10_11_192739_add_transaction_amount_table', 57),
(110, '2021_10_11_200850_add_order_verification_code', 57),
(111, '2021_10_12_083241_add_col_to_order_transaction', 57),
(112, '2021_10_12_084440_add_seller_id_to_order', 57),
(113, '2021_10_12_102853_change_col_type', 57),
(114, '2021_10_12_110434_add_col_to_admin_wallet', 57),
(115, '2021_10_12_110829_add_col_to_seller_wallet', 57),
(116, '2021_10_13_091801_add_col_to_admin_wallets', 57),
(117, '2021_10_13_092000_add_col_to_seller_wallets_tax', 57),
(118, '2021_10_13_165947_rename_and_remove_col_seller_wallet', 57),
(119, '2021_10_13_170258_rename_and_remove_col_admin_wallet', 57),
(120, '2021_10_14_061603_column_update_order_transaction', 57),
(121, '2021_10_15_103339_remove_col_from_seller_wallet', 57),
(122, '2021_10_15_104419_add_id_col_order_tran', 57),
(123, '2021_10_15_213454_update_string_limit', 57),
(124, '2021_10_16_234037_change_col_type_translation', 57),
(125, '2021_10_16_234329_change_col_type_translation_1', 57),
(126, '2021_10_27_091250_add_shipping_address_in_order', 58),
(127, '2021_01_24_205114_create_paytabs_invoices_table', 59),
(128, '2021_11_20_043814_change_pass_reset_email_col', 59),
(129, '2021_11_25_043109_create_delivery_men_table', 60),
(130, '2021_11_25_062242_add_auth_token_delivery_man', 60),
(131, '2021_11_27_043405_add_deliveryman_in_order_table', 60),
(132, '2021_11_27_051432_create_delivery_histories_table', 60),
(133, '2021_11_27_051512_add_fcm_col_for_delivery_man', 60),
(134, '2021_12_15_123216_add_columns_to_banner', 60),
(135, '2022_01_04_100543_add_order_note_to_orders_table', 60),
(136, '2022_01_10_034952_add_lat_long_to_shipping_addresses_table', 60),
(137, '2022_01_10_045517_create_billing_addresses_table', 60),
(138, '2022_01_11_040755_add_is_billing_to_shipping_addresses_table', 60),
(139, '2022_01_11_053404_add_billing_to_orders_table', 60),
(140, '2022_01_11_234310_add_firebase_toke_to_sellers_table', 60),
(141, '2022_01_16_121801_change_colu_type', 60),
(142, '2022_01_22_101601_change_cart_col_type', 61),
(143, '2022_01_23_031359_add_column_to_orders_table', 61),
(144, '2022_01_28_235054_add_status_to_admins_table', 61),
(145, '2022_02_01_214654_add_pos_status_to_sellers_table', 61),
(146, '2019_12_14_000001_create_personal_access_tokens_table', 62),
(147, '2022_02_11_225355_add_checked_to_orders_table', 62),
(148, '2022_02_14_114359_create_refund_requests_table', 62),
(149, '2022_02_14_115757_add_refund_request_to_order_details_table', 62),
(150, '2022_02_15_092604_add_order_details_id_to_transactions_table', 62),
(151, '2022_02_15_121410_create_refund_transactions_table', 62),
(152, '2022_02_24_091236_add_multiple_column_to_refund_requests_table', 62),
(153, '2022_02_24_103827_create_refund_statuses_table', 62),
(154, '2022_03_01_121420_add_refund_id_to_refund_transactions_table', 62),
(155, '2022_03_10_091943_add_priority_to_categories_table', 63),
(156, '2022_03_13_111914_create_shipping_types_table', 63),
(157, '2022_03_13_121514_create_category_shipping_costs_table', 63),
(158, '2022_03_14_074413_add_four_column_to_products_table', 63),
(159, '2022_03_15_105838_add_shipping_to_carts_table', 63),
(160, '2022_03_16_070327_add_shipping_type_to_orders_table', 63),
(161, '2022_03_17_070200_add_delivery_info_to_orders_table', 63),
(162, '2022_03_18_143339_add_shipping_type_to_carts_table', 63),
(163, '2022_04_06_020313_create_subscriptions_table', 64),
(164, '2022_04_12_233704_change_column_to_products_table', 64),
(165, '2022_04_19_095926_create_jobs_table', 64),
(166, '2022_05_12_104247_create_wallet_transactions_table', 65),
(167, '2022_05_12_104511_add_two_column_to_users_table', 65),
(168, '2022_05_14_063309_create_loyalty_point_transactions_table', 65),
(169, '2022_05_26_044016_add_user_type_to_password_resets_table', 65),
(170, '2022_04_15_235820_add_provider', 66),
(171, '2022_07_21_101659_add_code_to_products_table', 66),
(172, '2022_07_26_103744_add_notification_count_to_notifications_table', 66),
(173, '2022_07_31_031541_add_minimum_order_qty_to_products_table', 66),
(174, '2022_08_11_172839_add_product_type_and_digital_product_type_and_digital_file_ready_to_products', 67),
(175, '2022_08_11_173941_add_product_type_and_digital_product_type_and_digital_file_to_order_details', 67),
(176, '2022_08_20_094225_add_product_type_and_digital_product_type_and_digital_file_ready_to_carts_table', 67),
(177, '2022_10_04_160234_add_banking_columns_to_delivery_men_table', 68),
(178, '2022_10_04_161339_create_deliveryman_wallets_table', 68),
(179, '2022_10_04_184506_add_deliverymanid_column_to_withdraw_requests_table', 68),
(180, '2022_10_11_103011_add_deliverymans_columns_to_chattings_table', 68),
(181, '2022_10_11_144902_add_deliverman_id_cloumn_to_reviews_table', 68),
(182, '2022_10_17_114744_create_order_status_histories_table', 68),
(183, '2022_10_17_120840_create_order_expected_delivery_histories_table', 68),
(184, '2022_10_18_084245_add_deliveryman_charge_and_expected_delivery_date', 68),
(185, '2022_10_18_130938_create_delivery_zip_codes_table', 68),
(186, '2022_10_18_130956_create_delivery_country_codes_table', 68),
(187, '2022_10_20_164712_create_delivery_man_transactions_table', 68),
(188, '2022_10_27_145604_create_emergency_contacts_table', 68),
(189, '2022_10_29_182930_add_is_pause_cause_to_orders_table', 68),
(190, '2022_10_31_150604_add_address_phone_country_code_column_to_delivery_men_table', 68),
(191, '2022_11_05_185726_add_order_id_to_reviews_table', 68),
(192, '2022_11_07_190749_create_deliveryman_notifications_table', 68),
(193, '2022_11_08_132745_change_transaction_note_type_to_withdraw_requests_table', 68),
(194, '2022_11_10_193747_chenge_order_amount_seller_amount_admin_commission_delivery_charge_tax_toorder_transactions_table', 68),
(195, '2022_12_17_035723_few_field_add_to_coupons_table', 69),
(196, '2022_12_26_231606_add_coupon_discount_bearer_and_admin_commission_to_orders', 69),
(197, '2023_01_04_003034_alter_billing_addresses_change_zip', 69),
(198, '2023_01_05_121600_change_id_to_transactions_table', 69),
(199, '2023_02_02_113330_create_product_tag_table', 70),
(200, '2023_02_02_114518_create_tags_table', 70),
(201, '2023_02_02_152248_add_tax_model_to_products_table', 70),
(202, '2023_02_02_152718_add_tax_model_to_order_details_table', 70),
(203, '2023_02_02_171034_add_tax_type_to_carts', 70),
(204, '2023_02_06_124447_add_color_image_column_to_products_table', 70),
(205, '2023_02_07_120136_create_withdrawal_methods_table', 70),
(206, '2023_02_07_175939_add_withdrawal_method_id_and_withdrawal_method_fields_to_withdraw_requests_table', 70),
(207, '2023_02_08_143314_add_vacation_start_and_vacation_end_and_vacation_not_column_to_shops_table', 70),
(208, '2023_02_09_104656_add_payment_by_and_payment_not_to_orders_table', 70),
(209, '2023_03_27_150723_add_expires_at_to_phone_or_email_verifications', 71),
(210, '2023_04_17_095721_create_shop_followers_table', 71),
(211, '2023_04_17_111249_add_bottom_banner_to_shops_table', 71),
(212, '2023_04_20_125423_create_product_compares_table', 71),
(213, '2023_04_30_165642_add_category_sub_category_and_sub_sub_category_add_in_product_table', 71),
(214, '2023_05_16_131006_add_expires_at_to_password_resets', 71),
(215, '2023_05_17_044243_add_visit_count_to_tags_table', 71),
(216, '2023_05_18_000403_add_title_and_subtitle_and_background_color_and_button_text_to_banners_table', 71),
(217, '2023_05_21_111300_add_login_hit_count_and_is_temp_blocked_and_temp_block_time_to_users_table', 71),
(218, '2023_05_21_111600_add_login_hit_count_and_is_temp_blocked_and_temp_block_time_to_phone_or_email_verifications_table', 71),
(219, '2023_05_21_112215_add_login_hit_count_and_is_temp_blocked_and_temp_block_time_to_password_resets_table', 71),
(220, '2023_06_04_210726_attachment_lenght_change_to_reviews_table', 71),
(221, '2023_06_05_115153_add_referral_code_and_referred_by_to_users_table', 72),
(222, '2023_06_21_002658_add_offer_banner_to_shops_table', 72),
(223, '2023_07_08_210747_create_most_demandeds_table', 72),
(224, '2023_07_31_111419_add_minimum_order_amount_to_sellers_table', 72),
(225, '2023_08_03_105256_create_offline_payment_methods_table', 72),
(226, '2023_08_07_131013_add_is_guest_column_to_carts_table', 72),
(227, '2023_08_07_170601_create_offline_payments_table', 72),
(228, '2023_08_12_102355_create_add_fund_bonus_categories_table', 72),
(229, '2023_08_12_215346_create_guest_users_table', 72),
(230, '2023_08_12_215659_add_is_guest_column_to_orders_table', 72),
(231, '2023_08_12_215933_add_is_guest_column_to_shipping_addresses_table', 72),
(232, '2023_08_15_000957_add_email_column_toshipping_address_table', 72),
(233, '2023_08_17_222330_add_identify_related_columns_to_admins_table', 72),
(234, '2023_08_20_230624_add_sent_by_and_send_to_in_notifications_table', 72),
(235, '2023_08_20_230911_create_notification_seens_table', 72),
(236, '2023_08_21_042331_add_theme_to_banners_table', 72),
(237, '2023_08_24_150009_add_free_delivery_over_amount_and_status_to_seller_table', 72),
(238, '2023_08_26_161214_add_is_shipping_free_to_orders_table', 72),
(239, '2023_08_26_173523_add_payment_method_column_to_wallet_transactions_table', 72),
(240, '2023_08_26_204653_add_verification_status_column_to_orders_table', 72),
(241, '2023_08_26_225113_create_order_delivery_verifications_table', 72),
(242, '2023_09_03_212200_add_free_delivery_responsibility_column_to_orders_table', 72),
(243, '2023_09_23_153314_add_shipping_responsibility_column_to_orders_table', 72),
(244, '2023_09_25_152733_create_digital_product_otp_verifications_table', 72);

-- --------------------------------------------------------

--
-- Table structure for table `most_demandeds`
--

CREATE TABLE `most_demandeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner` varchar(255) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sent_by` varchar(255) NOT NULL DEFAULT 'system',
  `sent_to` varchar(255) NOT NULL DEFAULT 'customer',
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(191) DEFAULT NULL,
  `notification_count` int(11) NOT NULL DEFAULT 0,
  `image` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `sent_by`, `sent_to`, `title`, `description`, `notification_count`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'seller', 'Theme Changed to Theme Aster', 'Theme Changed Description, time - 2023-10-25 18:29:07', 1, 'null', 1, '2023-10-25 18:29:07', '2023-10-25 18:29:07'),
(2, 'admin', 'seller', 'Theme Changed to Default', 'Theme Changed Description, time - 2023-11-03 22:59:49', 1, 'null', 1, '2023-11-03 22:59:49', '2023-11-03 22:59:49'),
(3, 'admin', 'seller', 'Theme Changed to Theme Aster', 'Theme Changed Description, time - 2023-11-04 00:19:54', 1, 'null', 1, '2023-11-04 00:19:54', '2023-11-04 00:19:54'),
(4, 'admin', 'seller', 'Theme Changed to Default', 'Theme Changed Description, time - 2023-11-04 00:20:37', 1, 'null', 1, '2023-11-04 00:20:37', '2023-11-04 00:20:37'),
(5, 'admin', 'seller', 'Theme Changed to Theme Aster', 'Theme Changed Description, time - 2023-11-04 00:32:30', 1, 'null', 1, '2023-11-04 00:32:30', '2023-11-04 00:32:30'),
(6, 'system', 'customer', 'Functiedeal van de euromarkt', 'de euromarkt', 2, '2023-11-25-6561dbf9afcf2.webp', 1, '2023-11-25 14:35:21', '2023-11-25 14:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `notification_seens`
--

CREATE TABLE `notification_seens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_seens`
--

INSERT INTO `notification_seens` (`id`, `seller_id`, `user_id`, `notification_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 5, 6, '2024-01-18 23:57:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('07cad01f460c55ad3923a4cfce296e37f298f0e7a7c12473386eaed401fc11ba63e647d81c46256d', 5, 1, 'LaravelAuthApp', '[]', 1, '2024-01-22 08:08:08', '2024-01-22 08:08:08', '2025-01-22 08:08:08'),
('18afe432bc4165de382db98149b721695d6546f9006eeb47833bfbbb7f881bc9f10094c7c0e4bb53', 5, 1, 'LaravelAuthApp', '[]', 0, '2024-01-18 22:39:53', '2024-01-18 22:39:53', '2025-01-18 22:39:53'),
('1b2d38805c970d47f0775ac1d08f862093381988b5f28edac10b946bb44a92b0819158fb6dc3b899', 5, 1, 'LaravelAuthApp', '[]', 1, '2024-01-22 08:05:53', '2024-01-22 08:05:53', '2025-01-22 08:05:53'),
('4050dcca386700492da58c258a083f12a4480075e1dc94ee3d693cfa098cf19a2ff87d6eef4612de', 5, 1, 'LaravelAuthApp', '[]', 0, '2024-01-18 22:39:56', '2024-01-18 22:39:56', '2025-01-18 22:39:56'),
('6840b7d4ed685bf2e0dc593affa0bd3b968065f47cc226d39ab09f1422b5a1d9666601f3f60a79c1', 98, 1, 'LaravelAuthApp', '[]', 1, '2021-07-05 09:25:41', '2021-07-05 09:25:41', '2022-07-05 15:25:41'),
('8444953171dd24338c086d6df830f99ea9cecf415c9fd8b31318bbc5cf04bb9264359056f8b689a5', 5, 1, 'LaravelAuthApp', '[]', 0, '2024-01-18 23:53:31', '2024-01-18 23:53:31', '2025-01-18 23:53:31'),
('8ff43aee73bb142e15afbf094c4d4127b97474dddbf3408a32042bbc5027129cffc48a1a354af7aa', 5, 1, 'LaravelAuthApp', '[]', 0, '2024-01-20 02:01:13', '2024-01-20 02:01:13', '2025-01-20 02:01:13'),
('a17a58b3df307b3697d2efb38924d8d792935ef37b45f9867ffc3701362d431baf3f31352044181c', 5, 1, 'LaravelAuthApp', '[]', 0, '2024-01-20 01:10:32', '2024-01-20 01:10:32', '2025-01-20 01:10:32'),
('a8463f395178b824bfeb49bd12b5d308fbc20992070055f22c7d99cc30d8bff940f85f9e3cedee23', 5, 1, 'LaravelAuthApp', '[]', 0, '2024-01-21 03:56:58', '2024-01-21 03:56:58', '2025-01-21 03:56:58'),
('c42cdd5ae652b8b2cbac4f2f4b496e889e1a803b08672954c8bbe06722b54160e71dce3e02331544', 98, 1, 'LaravelAuthApp', '[]', 1, '2021-07-05 09:24:36', '2021-07-05 09:24:36', '2022-07-05 15:24:36'),
('d7d9e791b0d224206742e8f5f2b8257120dfeb575c6d0cb3ea3a31ea9200ed2989ec500916ff8092', 5, 1, 'LaravelAuthApp', '[]', 0, '2024-01-21 05:27:49', '2024-01-21 05:27:49', '2025-01-21 05:27:49'),
('ff690ee8cb420ad018e831a45020f7b36144aebb086905e9820b2f8089010150f7b1e14f2339828b', 5, 1, 'LaravelAuthApp', '[]', 1, '2024-01-22 14:25:24', '2024-01-22 14:25:24', '2025-01-22 14:25:24');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `secret` varchar(100) NOT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provider` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`, `provider`) VALUES
(1, NULL, '6amtech', 'GEUx5tqkviM6AAQcz4oi1dcm1KtRdJPgw41lj0eI', 'http://localhost', 1, 0, 0, '2020-10-21 18:27:22', '2020-10-21 18:27:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-10-21 18:27:23', '2020-10-21 18:27:23');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_payments`
--

CREATE TABLE `offline_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `payment_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_info`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offline_payment_methods`
--

CREATE TABLE `offline_payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_name` varchar(255) NOT NULL,
  `method_fields` text NOT NULL,
  `method_informations` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(15) DEFAULT NULL,
  `is_guest` tinyint(4) NOT NULL DEFAULT 0,
  `customer_type` varchar(10) DEFAULT NULL,
  `payment_status` varchar(15) NOT NULL DEFAULT 'unpaid',
  `order_status` varchar(50) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(100) DEFAULT NULL,
  `transaction_ref` varchar(30) DEFAULT NULL,
  `payment_by` varchar(191) DEFAULT NULL,
  `payment_note` text DEFAULT NULL,
  `order_amount` double NOT NULL DEFAULT 0,
  `admin_commission` decimal(8,2) NOT NULL DEFAULT 0.00,
  `is_pause` varchar(20) NOT NULL DEFAULT '0',
  `cause` varchar(191) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `discount_amount` double NOT NULL DEFAULT 0,
  `discount_type` varchar(30) DEFAULT NULL,
  `coupon_code` varchar(191) DEFAULT NULL,
  `coupon_discount_bearer` varchar(191) NOT NULL DEFAULT 'inhouse',
  `shipping_responsibility` varchar(255) DEFAULT NULL,
  `shipping_method_id` bigint(20) NOT NULL DEFAULT 0,
  `shipping_cost` double(8,2) NOT NULL DEFAULT 0.00,
  `is_shipping_free` tinyint(1) NOT NULL DEFAULT 0,
  `order_group_id` varchar(191) NOT NULL DEFAULT 'def-order-group',
  `verification_code` varchar(191) NOT NULL DEFAULT '0',
  `verification_status` tinyint(4) NOT NULL DEFAULT 0,
  `seller_id` bigint(20) DEFAULT NULL,
  `seller_is` varchar(191) DEFAULT NULL,
  `shipping_address_data` text DEFAULT NULL,
  `delivery_man_id` bigint(20) DEFAULT NULL,
  `deliveryman_charge` double NOT NULL DEFAULT 0,
  `expected_delivery_date` date DEFAULT NULL,
  `order_note` text DEFAULT NULL,
  `billing_address` bigint(20) UNSIGNED DEFAULT NULL,
  `billing_address_data` text DEFAULT NULL,
  `order_type` varchar(191) NOT NULL DEFAULT 'default_type',
  `extra_discount` double(8,2) NOT NULL DEFAULT 0.00,
  `extra_discount_type` varchar(191) DEFAULT NULL,
  `free_delivery_bearer` varchar(255) DEFAULT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 0,
  `shipping_type` varchar(191) DEFAULT NULL,
  `delivery_type` varchar(191) DEFAULT NULL,
  `delivery_service_name` varchar(191) DEFAULT NULL,
  `third_party_delivery_tracking_id` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `is_guest`, `customer_type`, `payment_status`, `order_status`, `payment_method`, `transaction_ref`, `payment_by`, `payment_note`, `order_amount`, `admin_commission`, `is_pause`, `cause`, `shipping_address`, `created_at`, `updated_at`, `discount_amount`, `discount_type`, `coupon_code`, `coupon_discount_bearer`, `shipping_responsibility`, `shipping_method_id`, `shipping_cost`, `is_shipping_free`, `order_group_id`, `verification_code`, `verification_status`, `seller_id`, `seller_is`, `shipping_address_data`, `delivery_man_id`, `deliveryman_charge`, `expected_delivery_date`, `order_note`, `billing_address`, `billing_address_data`, `order_type`, `extra_discount`, `extra_discount_type`, `free_delivery_bearer`, `checked`, `shipping_type`, `delivery_type`, `delivery_service_name`, `third_party_delivery_tracking_id`) VALUES
(100001, '46', 1, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 563, '0.00', '0', NULL, '1', '2023-11-07 02:29:27', '2023-11-22 00:23:36', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '2392-jrQNg-1699313367', '946404', 0, 1, 'admin', '{\"id\":1,\"customer_id\":46,\"is_guest\":1,\"contact_person_name\":\"sads\",\"email\":\"asdsad@sadda.com\",\"address_type\":\"home\",\"address\":\"awdewadasd asdas \",\"city\":\"sdadas\",\"zip\":\"3213\",\"phone\":\"2343123\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"British Indian Ocean Territory\",\"latitude\":\"\",\"longitude\":\"\",\"is_billing\":0}', NULL, 0, NULL, NULL, 1, '{\"id\":1,\"customer_id\":46,\"is_guest\":1,\"contact_person_name\":\"sads\",\"email\":\"asdsad@sadda.com\",\"address_type\":\"home\",\"address\":\"awdewadasd asdas \",\"city\":\"sdadas\",\"zip\":\"3213\",\"phone\":\"2343123\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"British Indian Ocean Territory\",\"latitude\":\"\",\"longitude\":\"\",\"is_billing\":0}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', 'third_party_delivery', 'dfsdf', '324324'),
(100002, '115', 1, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 33.5, '0.00', '0', NULL, '2', '2023-11-15 23:58:04', '2023-11-22 00:23:20', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '1334-1rNeI-1700081884', '195440', 0, 1, 'admin', '{\"id\":2,\"customer_id\":115,\"is_guest\":1,\"contact_person_name\":\"rtwer\",\"email\":\"tvsoso1994@gmail.com\",\"address_type\":\"home\",\"address\":\"Randenbroekerweg 81, 3816 BE Amersfoort, Netherlands\",\"city\":\"istanbuk\",\"zip\":\"3242\",\"phone\":\"3242423\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"Albania\",\"latitude\":\"52.15298801618823\",\"longitude\":\"5.404981980517571\",\"is_billing\":0}', NULL, 0, NULL, NULL, 2, '{\"id\":2,\"customer_id\":115,\"is_guest\":1,\"contact_person_name\":\"rtwer\",\"email\":\"tvsoso1994@gmail.com\",\"address_type\":\"home\",\"address\":\"Randenbroekerweg 81, 3816 BE Amersfoort, Netherlands\",\"city\":\"istanbuk\",\"zip\":\"3242\",\"phone\":\"3242423\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"Albania\",\"latitude\":\"52.15298801618823\",\"longitude\":\"5.404981980517571\",\"is_billing\":0}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', 'third_party_delivery', 'DHL', '23123'),
(100003, '143', 1, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 100.7, '20.00', '0', NULL, '3', '2023-11-22 00:20:57', '2023-11-22 00:22:42', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 9, 0.00, 0, '1179-W5mbr-1700601657', '887367', 0, 3, 'seller', '{\"id\":3,\"customer_id\":143,\"is_guest\":1,\"contact_person_name\":\"sadas\",\"email\":\"asdsad@dasd.com\",\"address_type\":\"home\",\"address\":\"Pauwstraat 20, 3816 AV Amersfoort, Netherlands\",\"city\":\"eqwa\",\"zip\":\"2321\",\"phone\":\"3432423\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"Algeria\",\"latitude\":\"52.15174550800625\",\"longitude\":\"5.398115525439446\",\"is_billing\":0}', NULL, 0, NULL, NULL, 3, '{\"id\":3,\"customer_id\":143,\"is_guest\":1,\"contact_person_name\":\"sadas\",\"email\":\"asdsad@dasd.com\",\"address_type\":\"home\",\"address\":\"Pauwstraat 20, 3816 AV Amersfoort, Netherlands\",\"city\":\"eqwa\",\"zip\":\"2321\",\"phone\":\"3432423\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"Algeria\",\"latitude\":\"52.15174550800625\",\"longitude\":\"5.398115525439446\",\"is_billing\":0}', 'default_type', 0.00, NULL, NULL, 1, 'order_wise', NULL, NULL, NULL),
(100004, '2', 0, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 12, '0.00', '0', NULL, '4', '2023-11-26 00:03:42', '2023-11-26 00:07:48', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 9, 0.00, 0, '1617-Esnm9-1700946222', '262089', 0, 1, 'admin', '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"Barchman Wuytierslaan 232, 3819 AC Amersfoort, Netherlands\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"0905565064\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"Algeria\",\"latitude\":\"52.15718995011475\",\"longitude\":\"5.341758728027344\",\"is_billing\":0}', NULL, 0, NULL, NULL, 4, '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"Barchman Wuytierslaan 232, 3819 AC Amersfoort, Netherlands\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"0905565064\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"Algeria\",\"latitude\":\"52.15718995011475\",\"longitude\":\"5.341758728027344\",\"is_billing\":0}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', 'third_party_delivery', 'DHL', '12312321'),
(100005, '2', 0, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 6.96, '0.00', '0', NULL, '4', '2023-11-26 00:09:42', '2023-11-26 00:46:27', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '1178-yOmNm-1700946581', '235544', 0, 1, 'seller', '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"\\u00dcniversite, Ba\\u011fc\\u0131 Soka\\u011f\\u0131 No:2, 34320 Avc\\u0131lar\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"00905537608834\",\"created_at\":null,\"updated_at\":\"2023-11-25T21:09:38.000000Z\",\"state\":null,\"country\":\"Turkey\",\"latitude\":\"40.99578990232887\",\"longitude\":\"28.720313008876357\",\"is_billing\":0}', NULL, 0, NULL, NULL, 4, '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"\\u00dcniversite, Ba\\u011fc\\u0131 Soka\\u011f\\u0131 No:2, 34320 Avc\\u0131lar\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"00905537608834\",\"created_at\":null,\"updated_at\":\"2023-11-25T21:09:38.000000Z\",\"state\":null,\"country\":\"Turkey\",\"latitude\":\"40.99578990232887\",\"longitude\":\"28.720313008876357\",\"is_billing\":0}', 'default_type', 0.00, NULL, NULL, 1, 'order_wise', NULL, NULL, NULL),
(100006, '2', 0, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 205.45, '40.00', '0', NULL, '4', '2023-11-26 00:11:18', '2023-11-26 00:11:41', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '4445-DuYSM-1700946678', '454716', 0, 3, 'seller', '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"\\u00dcniversite, Ba\\u011fc\\u0131 Soka\\u011f\\u0131 No:2, 34320 Avc\\u0131lar\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"00905537608834\",\"created_at\":null,\"updated_at\":\"2023-11-25T21:11:13.000000Z\",\"state\":null,\"country\":\"Turkey\",\"latitude\":\"52.1558004\",\"longitude\":\"5.3924507\",\"is_billing\":0}', NULL, 0, NULL, NULL, 4, '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"\\u00dcniversite, Ba\\u011fc\\u0131 Soka\\u011f\\u0131 No:2, 34320 Avc\\u0131lar\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"00905537608834\",\"created_at\":null,\"updated_at\":\"2023-11-25T21:11:13.000000Z\",\"state\":null,\"country\":\"Turkey\",\"latitude\":\"52.1558004\",\"longitude\":\"5.3924507\",\"is_billing\":0}', 'default_type', 0.00, NULL, NULL, 1, 'order_wise', NULL, NULL, NULL),
(100007, '2', 0, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 57, '11.00', '0', NULL, '4', '2023-11-26 00:13:13', '2023-11-26 00:14:02', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 9, 0.00, 0, '1832-cOhnX-1700946793', '418556', 0, 3, 'seller', '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"\\u00dcniversite, Ba\\u011fc\\u0131 Soka\\u011f\\u0131 No:2, 34320 Avc\\u0131lar\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"00905537608834\",\"created_at\":null,\"updated_at\":\"2023-11-25T21:11:13.000000Z\",\"state\":null,\"country\":\"Turkey\",\"latitude\":\"52.1558004\",\"longitude\":\"5.3924507\",\"is_billing\":0}', NULL, 0, NULL, NULL, 4, '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"\\u00dcniversite, Ba\\u011fc\\u0131 Soka\\u011f\\u0131 No:2, 34320 Avc\\u0131lar\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"00905537608834\",\"created_at\":null,\"updated_at\":\"2023-11-25T21:11:13.000000Z\",\"state\":null,\"country\":\"Turkey\",\"latitude\":\"52.1558004\",\"longitude\":\"5.3924507\",\"is_billing\":0}', 'default_type', 0.00, NULL, NULL, 1, 'order_wise', NULL, NULL, NULL),
(100008, '2', 0, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 20.3721, '0.00', '0', NULL, '4', '2023-11-26 00:13:17', '2023-11-26 00:14:18', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 9, 0.00, 0, '1832-cOhnX-1700946793', '784550', 0, 1, 'admin', '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"\\u00dcniversite, Ba\\u011fc\\u0131 Soka\\u011f\\u0131 No:2, 34320 Avc\\u0131lar\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"00905537608834\",\"created_at\":null,\"updated_at\":\"2023-11-25T21:11:13.000000Z\",\"state\":null,\"country\":\"Turkey\",\"latitude\":\"52.1558004\",\"longitude\":\"5.3924507\",\"is_billing\":0}', NULL, 0, NULL, NULL, 4, '{\"id\":4,\"customer_id\":2,\"is_guest\":0,\"contact_person_name\":\"abdulader\",\"email\":null,\"address_type\":\"home\",\"address\":\"\\u00dcniversite, Ba\\u011fc\\u0131 Soka\\u011f\\u0131 No:2, 34320 Avc\\u0131lar\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"istanbul\",\"zip\":\"3424\",\"phone\":\"00905537608834\",\"created_at\":null,\"updated_at\":\"2023-11-25T21:11:13.000000Z\",\"state\":null,\"country\":\"Turkey\",\"latitude\":\"52.1558004\",\"longitude\":\"5.3924507\",\"is_billing\":0}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', NULL, NULL, NULL),
(100009, '0', 0, 'customer', 'paid', 'delivered', 'cash', NULL, NULL, NULL, 87.4, '0.00', '0', NULL, NULL, '2023-11-27 00:43:48', '2023-11-27 00:43:48', 0, NULL, NULL, 'inhouse', NULL, 0, 0.00, 0, 'def-order-group', '0', 0, 1, 'admin', NULL, NULL, 0, NULL, NULL, NULL, NULL, 'POS', 0.00, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(100010, '0', 0, 'customer', 'paid', 'delivered', 'cash', NULL, NULL, NULL, 6.79, '0.00', '0', NULL, NULL, '2023-11-27 00:44:49', '2023-11-27 00:44:49', 0, NULL, NULL, 'inhouse', NULL, 0, 0.00, 0, 'def-order-group', '0', 0, 1, 'admin', NULL, NULL, 0, NULL, NULL, NULL, NULL, 'POS', 0.00, NULL, NULL, 1, NULL, NULL, NULL, NULL),
(100011, '490', 1, 'customer', 'unpaid', 'pending', 'cash_on_delivery', '', NULL, NULL, 171.25, '33.00', '0', NULL, '6', '2023-12-29 00:52:30', '2023-12-29 00:53:07', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '5272-tZuFL-1703800350', '478719', 0, 1, 'seller', '{\"id\":6,\"customer_id\":490,\"is_guest\":1,\"contact_person_name\":\"Sas\",\"email\":\"aadll4app@gmail.com\",\"address_type\":\"home\",\"address\":\"Johannes Bosboomstraat 4, 3817 DR Amersfoort, Netherlands\",\"city\":\"sdfsd\",\"zip\":\"144156\",\"phone\":\"00456465456\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"\\u00c5land Islands\",\"latitude\":\"52.14767452811479\",\"longitude\":\"5.392772518739091\",\"is_billing\":0}', NULL, 0, NULL, NULL, 6, '{\"id\":6,\"customer_id\":490,\"is_guest\":1,\"contact_person_name\":\"Sas\",\"email\":\"aadll4app@gmail.com\",\"address_type\":\"home\",\"address\":\"Johannes Bosboomstraat 4, 3817 DR Amersfoort, Netherlands\",\"city\":\"sdfsd\",\"zip\":\"144156\",\"phone\":\"00456465456\",\"created_at\":null,\"updated_at\":null,\"state\":null,\"country\":\"\\u00c5land Islands\",\"latitude\":\"52.14767452811479\",\"longitude\":\"5.392772518739091\",\"is_billing\":0}', 'default_type', 0.00, NULL, NULL, 1, 'order_wise', NULL, NULL, NULL),
(100012, '5', 0, 'customer', 'unpaid', 'canceled', 'cash_on_delivery', '', NULL, NULL, 110.45, '0.00', '0', NULL, '7', '2024-01-18 23:56:39', '2024-01-22 14:27:10', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '5524-z0n1g-1705611399', '845118', 0, 1, 'admin', '{\"id\":7,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"fxvcxcv\",\"zip\":\"44444\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:05.000000Z\",\"updated_at\":\"2024-01-18T20:56:05.000000Z\",\"state\":null,\"country\":\"Bosnia and Herzegovina\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":0}', NULL, 0, NULL, NULL, 8, '{\"id\":8,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"tretre\",\"zip\":\"5555\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:19.000000Z\",\"updated_at\":\"2024-01-18T20:56:19.000000Z\",\"state\":null,\"country\":\"BD\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":1}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', NULL, NULL, NULL),
(100013, '714', 1, 'customer', 'unpaid', 'pending', 'cash_on_delivery', '', NULL, NULL, 17, '0.00', '0', NULL, '9', '2024-01-22 14:24:20', '2024-01-25 12:13:24', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '5951-kKfel-1705922660', '585149', 0, 1, 'admin', '{\"id\":9,\"customer_id\":714,\"is_guest\":1,\"contact_person_name\":\"Bdbdbb\",\"email\":\"abdulkadertarrabrefaee@gmail.com\",\"address_type\":\"home\",\"address\":\"hddbbdbd\",\"city\":\"bsbsbs\",\"zip\":\"63663\",\"phone\":\"+88058805585\",\"created_at\":\"2024-01-22T11:23:32.000000Z\",\"updated_at\":\"2024-01-22T11:23:32.000000Z\",\"state\":null,\"country\":\"Denmark\",\"latitude\":\"0.0000016763806300685275\",\"longitude\":\"-0.0000016763806343078613\",\"is_billing\":0}', NULL, 0, NULL, 'dhhdhd tesstt', 10, '{\"id\":10,\"customer_id\":714,\"is_guest\":1,\"contact_person_name\":\"Vdvdbxb\",\"email\":\"abdulkadertarrabrefaee@gmail.com\",\"address_type\":\"home\",\"address\":\"G\\u00fcrsel Mh., Namzet Sk No:15, 34400 K\\u00e2\\u011f\\u0131thane\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"hdhdhs\",\"zip\":\"63663\",\"phone\":\"+88096464686\",\"created_at\":\"2024-01-22T11:24:04.000000Z\",\"updated_at\":\"2024-01-22T11:24:04.000000Z\",\"state\":null,\"country\":\"de\",\"latitude\":\"41.0653903103795\",\"longitude\":\"28.97137340158224\",\"is_billing\":1}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', NULL, NULL, NULL),
(100014, '714', 1, 'customer', 'unpaid', 'pending', 'cash_on_delivery', '', NULL, NULL, 34.1, '0.00', '0', NULL, '9', '2024-01-22 14:25:01', '2024-01-25 12:13:24', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '1772-ZBcbm-1705922701', '890464', 0, 1, 'admin', '{\"id\":9,\"customer_id\":714,\"is_guest\":1,\"contact_person_name\":\"Bdbdbb\",\"email\":\"abdulkadertarrabrefaee@gmail.com\",\"address_type\":\"home\",\"address\":\"hddbbdbd\",\"city\":\"bsbsbs\",\"zip\":\"63663\",\"phone\":\"+88058805585\",\"created_at\":\"2024-01-22T11:23:32.000000Z\",\"updated_at\":\"2024-01-22T11:23:32.000000Z\",\"state\":null,\"country\":\"Denmark\",\"latitude\":\"0.0000016763806300685275\",\"longitude\":\"-0.0000016763806343078613\",\"is_billing\":0}', NULL, 0, NULL, 'dhhdhd tessttvvvv', 10, '{\"id\":10,\"customer_id\":714,\"is_guest\":1,\"contact_person_name\":\"Vdvdbxb\",\"email\":\"abdulkadertarrabrefaee@gmail.com\",\"address_type\":\"home\",\"address\":\"G\\u00fcrsel Mh., Namzet Sk No:15, 34400 K\\u00e2\\u011f\\u0131thane\\/\\u0130stanbul, T\\u00fcrkiye\",\"city\":\"hdhdhs\",\"zip\":\"63663\",\"phone\":\"+88096464686\",\"created_at\":\"2024-01-22T11:24:04.000000Z\",\"updated_at\":\"2024-01-22T11:24:04.000000Z\",\"state\":null,\"country\":\"de\",\"latitude\":\"41.0653903103795\",\"longitude\":\"28.97137340158224\",\"is_billing\":1}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', NULL, NULL, NULL),
(100015, '5', 0, 'customer', 'unpaid', 'canceled', 'cash_on_delivery', '', NULL, NULL, 20.2, '3.00', '0', NULL, '7', '2024-01-22 14:29:06', '2024-01-25 12:13:24', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '4338-xfsmu-1705922946', '732545', 0, 3, 'seller', '{\"id\":7,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"fxvcxcv\",\"zip\":\"44444\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:05.000000Z\",\"updated_at\":\"2024-01-18T20:56:05.000000Z\",\"state\":null,\"country\":\"Bosnia and Herzegovina\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":0}', NULL, 0, NULL, 'trrtgg', 8, '{\"id\":8,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"tretre\",\"zip\":\"5555\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:19.000000Z\",\"updated_at\":\"2024-01-18T20:56:19.000000Z\",\"state\":null,\"country\":\"BD\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":1}', 'default_type', 0.00, NULL, NULL, 1, 'order_wise', NULL, NULL, NULL),
(100016, '5', 0, 'customer', 'unpaid', 'canceled', 'cash_on_delivery', '', NULL, NULL, 171.25, '33.00', '0', NULL, '7', '2024-01-22 14:29:09', '2024-01-25 12:13:24', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '4338-xfsmu-1705922946', '402834', 0, 1, 'seller', '{\"id\":7,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"fxvcxcv\",\"zip\":\"44444\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:05.000000Z\",\"updated_at\":\"2024-01-18T20:56:05.000000Z\",\"state\":null,\"country\":\"Bosnia and Herzegovina\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":0}', NULL, 0, NULL, 'trrtgg', 8, '{\"id\":8,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"tretre\",\"zip\":\"5555\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:19.000000Z\",\"updated_at\":\"2024-01-18T20:56:19.000000Z\",\"state\":null,\"country\":\"BD\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":1}', 'default_type', 0.00, NULL, NULL, 1, 'order_wise', NULL, NULL, NULL),
(100017, '5', 0, 'customer', 'unpaid', 'canceled', 'cash_on_delivery', '', NULL, NULL, 29, '0.00', '0', NULL, '7', '2024-01-22 14:29:13', '2024-01-25 12:13:24', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 2, 5.00, 0, '4338-xfsmu-1705922946', '170600', 0, 1, 'admin', '{\"id\":7,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"fxvcxcv\",\"zip\":\"44444\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:05.000000Z\",\"updated_at\":\"2024-01-18T20:56:05.000000Z\",\"state\":null,\"country\":\"Bosnia and Herzegovina\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":0}', NULL, 0, NULL, 'trrtgg', 8, '{\"id\":8,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"tretre\",\"zip\":\"5555\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:19.000000Z\",\"updated_at\":\"2024-01-18T20:56:19.000000Z\",\"state\":null,\"country\":\"BD\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":1}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', NULL, NULL, NULL),
(100018, '712', 1, 'customer', 'unpaid', 'pending', 'cash_on_delivery', '', NULL, NULL, 232.5, '0.00', '0', NULL, '12', '2024-01-25 02:03:23', '2024-01-25 12:13:24', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 9, 0.00, 0, '3215-japUa-1706137403', '471735', 0, 1, 'admin', '{\"id\":12,\"customer_id\":712,\"is_guest\":1,\"contact_person_name\":\"Ffffvv\",\"email\":\"Rwdgg@fdrh.Com\",\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"racc\",\"zip\":\"5433\",\"phone\":\"+244554555\",\"created_at\":\"2024-01-24T23:03:15.000000Z\",\"updated_at\":\"2024-01-24T23:03:15.000000Z\",\"state\":null,\"country\":\"de\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":0}', NULL, 0, NULL, NULL, 11, '{\"id\":11,\"customer_id\":712,\"is_guest\":1,\"contact_person_name\":\"Gffjj\",\"email\":\"Dssgh@ggrr.Com\",\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"rsgg\",\"zip\":\"54444\",\"phone\":\"+88052255555\",\"created_at\":\"2024-01-24T23:02:38.000000Z\",\"updated_at\":\"2024-01-24T23:02:38.000000Z\",\"state\":null,\"country\":\"de\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":1}', 'default_type', 0.00, NULL, 'admin', 1, 'order_wise', NULL, NULL, NULL),
(100019, '5', 0, 'customer', 'paid', 'delivered', 'cash_on_delivery', '', NULL, NULL, 15.2, '3.00', '0', NULL, '7', '2024-01-25 12:12:49', '2024-01-25 12:13:42', 0, NULL, '0', 'inhouse', 'inhouse_shipping', 9, 0.00, 0, '9125-wmgJK-1706173969', '598819', 0, 3, 'seller', '{\"id\":7,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"fxvcxcv\",\"zip\":\"44444\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:05.000000Z\",\"updated_at\":\"2024-01-18T20:56:05.000000Z\",\"state\":null,\"country\":\"Bosnia and Herzegovina\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":0}', NULL, 0, NULL, NULL, 8, '{\"id\":8,\"customer_id\":5,\"is_guest\":0,\"contact_person_name\":\"abd tarab\",\"email\":null,\"address_type\":\"home\",\"address\":\"P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA\",\"city\":\"tretre\",\"zip\":\"5555\",\"phone\":\"+880054154646\",\"created_at\":\"2024-01-18T20:56:19.000000Z\",\"updated_at\":\"2024-01-18T20:56:19.000000Z\",\"state\":null,\"country\":\"BD\",\"latitude\":\"37.42199952052943\",\"longitude\":\"-122.08400152623655\",\"is_billing\":1}', 'default_type', 0.00, NULL, NULL, 1, 'order_wise', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_delivery_verifications`
--

CREATE TABLE `order_delivery_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `digital_file_after_sell` varchar(191) DEFAULT NULL,
  `product_details` text DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `tax` double NOT NULL DEFAULT 0,
  `discount` double NOT NULL DEFAULT 0,
  `tax_model` varchar(20) NOT NULL DEFAULT 'exclude',
  `delivery_status` varchar(15) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(15) NOT NULL DEFAULT 'unpaid',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shipping_method_id` bigint(20) DEFAULT NULL,
  `variant` varchar(255) DEFAULT NULL,
  `variation` varchar(255) DEFAULT NULL,
  `discount_type` varchar(30) DEFAULT NULL,
  `is_stock_decreased` tinyint(1) NOT NULL DEFAULT 1,
  `refund_request` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `seller_id`, `digital_file_after_sell`, `product_details`, `qty`, `price`, `tax`, `discount`, `tax_model`, `delivery_status`, `payment_status`, `created_at`, `updated_at`, `shipping_method_id`, `variant`, `variation`, `discount_type`, `is_stock_decreased`, `refund_request`) VALUES
(1, 100001, 111, 1, NULL, '{\"id\":111,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"Graceful Off The Shoulder Long Sleeve Bride Robe Sparkly Crystal Beads Wedding D\",\"slug\":\"graceful-off-the-shoulder-long-sleeve-bride-robe-sparkly-crystal-beads-wedding-dress-luxury-long-bridal-gown-robe-de-mar\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"2\\\",\\\"position\\\":1},{\\\"id\\\":\\\"16\\\",\\\"position\\\":2}]\",\"category_id\":\"2\",\"sub_category_id\":\"16\",\"sub_sub_category_id\":null,\"brand_id\":1,\"unit\":\"kg\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-04-65464a763f294.png\\\",\\\"2023-11-04-65464a76404c3.png\\\",\\\"2023-11-04-65464a764082f.png\\\",\\\"2023-11-04-65464a764c128.png\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"0000FF\\\",\\\"image_name\\\":\\\"2023-11-04-65464a763f294.png\\\"},{\\\"color\\\":\\\"FF1493\\\",\\\"image_name\\\":\\\"2023-11-04-65464a76404c3.png\\\"},{\\\"color\\\":\\\"FFFFFF\\\",\\\"image_name\\\":\\\"2023-11-04-65464a764082f.png\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-04-65464a764c128.png\\\"}]\",\"thumbnail\":\"2023-11-04-65464a764c5df.png\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#0000FF\\\",\\\"#FF1493\\\",\\\"#FFFFFF\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"M\\\",\\\"L\\\",\\\"S\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Blue-M\\\",\\\"price\\\":350,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-M\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Blue-L\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Blue-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-S\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"DeepPink-M\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-M\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"DeepPink-L\\\",\\\"price\\\":150,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"DeepPink-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-S\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-M\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-M\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-L\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-S\\\",\\\"qty\\\":50}]\",\"published\":0,\"unit_price\":250,\"purchase_price\":270,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":7,\"discount_type\":\"percent\",\"current_stock\":450,\"minimum_order_qty\":1,\"details\":\"<p>Welcome to DMDRS Wedding Party Store<\\/p>\\r\\n\\r\\n<p>Warm Tips:<br \\/>\\r\\n1: The dress is made to order. We suggest customers order at least 2 months earlier to leave more time for production and the shipping.<br \\/>\\r\\n2.Shipping time depends on the shipping ways you chosen.<br \\/>\\r\\n3.Please message me your deadline in advance or detail any time-sensitive requests in the order&#39;s note box at checkout.<br \\/>\\r\\n4.!!!After placing your order, there is still ONE DAY to change your mind or Please confirm well before placing the order. Once the tailoring process has begun, the materials cannot be reused. Canceling orders halfway will cause us a lot of losses, since all our dresses are not in stock, but brand new and custom made for each order.<br \\/>\\r\\n5.!!!We provide rush order service for all products. If there is a rush order, we strongly suggest you contact us before place order to avoid error estimates.<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-04T10:43:18.000000Z\",\"updated_at\":\"2023-11-04T10:43:18.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.png\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"133736\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 250, 0, 17.5, 'include', 'delivered', 'unpaid', '2023-11-07 02:29:27', '2023-11-22 00:23:36', NULL, 'DeepPink-M', '{\"color\":\"DeepPink\",\"Size\":\"M\"}', 'discount_on_product', 1, 0),
(2, 100001, 111, 1, NULL, '{\"id\":111,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"Graceful Off The Shoulder Long Sleeve Bride Robe Sparkly Crystal Beads Wedding D\",\"slug\":\"graceful-off-the-shoulder-long-sleeve-bride-robe-sparkly-crystal-beads-wedding-dress-luxury-long-bridal-gown-robe-de-mar\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"2\\\",\\\"position\\\":1},{\\\"id\\\":\\\"16\\\",\\\"position\\\":2}]\",\"category_id\":\"2\",\"sub_category_id\":\"16\",\"sub_sub_category_id\":null,\"brand_id\":1,\"unit\":\"kg\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-04-65464a763f294.png\\\",\\\"2023-11-04-65464a76404c3.png\\\",\\\"2023-11-04-65464a764082f.png\\\",\\\"2023-11-04-65464a764c128.png\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"0000FF\\\",\\\"image_name\\\":\\\"2023-11-04-65464a763f294.png\\\"},{\\\"color\\\":\\\"FF1493\\\",\\\"image_name\\\":\\\"2023-11-04-65464a76404c3.png\\\"},{\\\"color\\\":\\\"FFFFFF\\\",\\\"image_name\\\":\\\"2023-11-04-65464a764082f.png\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-04-65464a764c128.png\\\"}]\",\"thumbnail\":\"2023-11-04-65464a764c5df.png\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#0000FF\\\",\\\"#FF1493\\\",\\\"#FFFFFF\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"M\\\",\\\"L\\\",\\\"S\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Blue-M\\\",\\\"price\\\":350,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-M\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Blue-L\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Blue-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-S\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"DeepPink-M\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-M\\\",\\\"qty\\\":49},{\\\"type\\\":\\\"DeepPink-L\\\",\\\"price\\\":150,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"DeepPink-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-S\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-M\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-M\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-L\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-S\\\",\\\"qty\\\":50}]\",\"published\":0,\"unit_price\":250,\"purchase_price\":270,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":7,\"discount_type\":\"percent\",\"current_stock\":449,\"minimum_order_qty\":1,\"details\":\"<p>Welcome to DMDRS Wedding Party Store<\\/p>\\r\\n\\r\\n<p>Warm Tips:<br \\/>\\r\\n1: The dress is made to order. We suggest customers order at least 2 months earlier to leave more time for production and the shipping.<br \\/>\\r\\n2.Shipping time depends on the shipping ways you chosen.<br \\/>\\r\\n3.Please message me your deadline in advance or detail any time-sensitive requests in the order&#39;s note box at checkout.<br \\/>\\r\\n4.!!!After placing your order, there is still ONE DAY to change your mind or Please confirm well before placing the order. Once the tailoring process has begun, the materials cannot be reused. Canceling orders halfway will cause us a lot of losses, since all our dresses are not in stock, but brand new and custom made for each order.<br \\/>\\r\\n5.!!!We provide rush order service for all products. If there is a rush order, we strongly suggest you contact us before place order to avoid error estimates.<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-04T10:43:18.000000Z\",\"updated_at\":\"2023-11-06T23:29:27.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.png\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"133736\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 350, 0, 24.5, 'include', 'delivered', 'unpaid', '2023-11-07 02:29:27', '2023-11-22 00:23:36', NULL, 'Blue-M', '{\"color\":\"Blue\",\"Size\":\"M\"}', 'discount_on_product', 1, 0),
(3, 100002, 136, 1, NULL, '{\"id\":136,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"INSMART Oral Irrigator Dental Water Flosser Teeth Whitening Waterproof Portable \",\"slug\":\"insmart-oral-irrigator-dental-water-flosser-teeth-whitening-waterproof-portable-dental-water-jet-floss-300ml-teeth-clean\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"5\\\",\\\"position\\\":1},{\\\"id\\\":\\\"95\\\",\\\"position\\\":2},{\\\"id\\\":\\\"102\\\",\\\"position\\\":3}]\",\"category_id\":\"5\",\"sub_category_id\":\"95\",\"sub_sub_category_id\":\"102\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-10-654e32b271f94.webp\\\",\\\"2023-11-10-654e32b29b362.webp\\\",\\\"2023-11-10-654e32b2bec7f.webp\\\",\\\"2023-11-10-654e32b2e084c.webp\\\",\\\"2023-11-10-654e32b308b68.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-10-654e32b271f94.webp\\\"},{\\\"color\\\":\\\"ADD8E6\\\",\\\"image_name\\\":\\\"2023-11-10-654e32b29b362.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-10-654e32b2bec7f.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-10-654e32b2e084c.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-10-654e32b308b68.webp\\\"}]\",\"thumbnail\":\"2023-11-10-654e32b3264b0.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#ADD8E6\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":32,\\\"sku\\\":\\\"IOIDWFTWWPDWJF3TC-Black\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"LightBlue\\\",\\\"price\\\":30,\\\"sku\\\":\\\"IOIDWFTWWPDWJF3TC-LightBlue\\\",\\\"qty\\\":1}]\",\"published\":0,\"unit_price\":30,\"purchase_price\":35,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":2,\"minimum_order_qty\":1,\"details\":\"<p>INSMART Oral Irrigator Dental Water Flosser Teeth Whitening Waterproof Portable Dental Water Jet Floss 300ML Teeth Cleaner<\\/p>\\r\\n\\r\\n<p>4 or more operating modes: The INSMART Oral Irrigator has 4 or more operating modes, allowing you to customize your teeth cleaning experience. Up to 1199 pulses\\/min: With up to 1199 pulses per minute, the INSMART Oral Irrigator provides powerful and efficient teeth cleaning. 5 or more nozzles: The INSMART Oral Irrigator comes with 5 or more nozzles, making it easy to share with family members or replace when needed.<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-10T13:40:03.000000Z\",\"updated_at\":\"2023-11-10T13:40:03.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"188496\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 30, 0, 1.5, 'include', 'delivered', 'unpaid', '2023-11-15 23:58:04', '2023-11-22 00:23:20', NULL, 'LightBlue', '{\"color\":\"LightBlue\"}', 'discount_on_product', 1, 0),
(4, 100003, 177, 3, NULL, '{\"id\":177,\"added_by\":\"seller\",\"user_id\":3,\"name\":\"New Men\'s Genuine Leather Jacket Male Cowhide Overcoat Autumn Winter Business Co\",\"slug\":\"new-mens-genuine-leather-jacket-male-cowhide-overcoat-autumn-winter-business-coat-trench-style-double-breasted-clothes-c\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"3\\\",\\\"position\\\":1},{\\\"id\\\":\\\"43\\\",\\\"position\\\":2},{\\\"id\\\":\\\"56\\\",\\\"position\\\":3}]\",\"category_id\":\"3\",\"sub_category_id\":\"43\",\"sub_sub_category_id\":\"56\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-20-655b4a1f05778.webp\\\",\\\"2023-11-20-655b4a1f241a8.webp\\\",\\\"2023-11-20-655b4a1f3c0f0.webp\\\",\\\"2023-11-20-655b4a1f504fc.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-20-655b4a1f05778.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f241a8.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f3c0f0.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f504fc.webp\\\"}]\",\"thumbnail\":\"2023-11-20-655b4a1f62f01.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"M\\\",\\\"L\\\",\\\"XL\\\",\\\"2XL\\\",\\\"3XL\\\",\\\"4XL\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Black-M\\\",\\\"price\\\":106,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-M\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-L\\\",\\\"price\\\":100,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-L\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-XL\\\",\\\"price\\\":105,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-2XL\\\",\\\"price\\\":108,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-2XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-3XL\\\",\\\"price\\\":110,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-3XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-4XL\\\",\\\"price\\\":110,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-4XL\\\",\\\"qty\\\":100}]\",\"published\":0,\"unit_price\":110,\"purchase_price\":115,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":600,\"minimum_order_qty\":1,\"details\":\"<p>New Men&#39;s Genuine Leather Jacket Male Cowhide Overcoat Autumn Winter Business Coat Trench Style Double Breasted Clothes Calfskin<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-20T11:59:27.000000Z\",\"updated_at\":\"2023-11-20T15:41:05.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"111430\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 106, 0, 5.3, 'include', 'delivered', 'unpaid', '2023-11-22 00:20:57', '2023-11-22 00:22:42', NULL, 'Black-M', '{\"color\":\"Black\",\"Size\":\"M\"}', 'discount_on_product', 1, 0),
(5, 100004, 149, 1, NULL, '{\"id\":149,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watche\",\"slug\":\"lige-2023-smart-watch-for-men-women-gift-full-touch-screen-sports-fitness-watches-bluetooth-calls-digital-smartwatch-wri\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"9\\\",\\\"position\\\":1},{\\\"id\\\":\\\"136\\\",\\\"position\\\":2},{\\\"id\\\":\\\"143\\\",\\\"position\\\":3}]\",\"category_id\":\"9\",\"sub_category_id\":\"136\",\"sub_sub_category_id\":\"143\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-13-655248b45e7e3.webp\\\",\\\"2023-11-13-655248b47207f.webp\\\",\\\"2023-11-13-655248b487e48.webp\\\",\\\"2023-11-13-655248b4995af.webp\\\",\\\"2023-11-13-655248b4aea0f.webp\\\",\\\"2023-11-13-655248b4c9c47.webp\\\",\\\"2023-11-13-655248b4de60d.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-13-655248b45e7e3.webp\\\"},{\\\"color\\\":\\\"696969\\\",\\\"image_name\\\":\\\"2023-11-13-655248b47207f.webp\\\"},{\\\"color\\\":\\\"DAA520\\\",\\\"image_name\\\":\\\"2023-11-13-655248b487e48.webp\\\"},{\\\"color\\\":\\\"808080\\\",\\\"image_name\\\":\\\"2023-11-13-655248b4995af.webp\\\"},{\\\"color\\\":\\\"FFB6C1\\\",\\\"image_name\\\":\\\"2023-11-13-655248b4aea0f.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655248b4c9c47.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655248b4de60d.webp\\\"}]\",\"thumbnail\":\"2023-11-13-655248b50227d.webp\",\"featured\":1,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#696969\\\",\\\"#DAA520\\\",\\\"#808080\\\",\\\"#FFB6C1\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Black\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"DimGray\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-DimGray\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Goldenrod\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Goldenrod\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Gray\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Gray\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"LightPink\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-LightPink\\\",\\\"qty\\\":1}]\",\"published\":0,\"unit_price\":12,\"purchase_price\":15,\"tax\":5,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":0,\"discount_type\":\"percent\",\"current_stock\":5,\"minimum_order_qty\":1,\"details\":\"<p>LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watches Bluetooth Calls Digital Smartwatch Wristwatch<br \\/>\\r\\n&nbsp;<\\/p>\\r\\n\\r\\n<p>&bull; Full Touch Screen :The Lige 2023 smartwatch features a full touch screen that allows for easy and intuitive navigation.<\\/p>\\r\\n\\r\\n<p>&bull; Blood Pressure Monitor :With a built-in blood pressure monitor, this smartwatch can help you keep track of your health and fitness levels.<\\/p>\\r\\n\\r\\n<p>&bull; Multiple Dials :Choose from a variety of watch faces to customize your Lige 2023 smartwatch to your personal style.<\\/p>\\r\\n\\r\\n<p>&bull; Calorie Tracker :Keep track of your daily calorie burn with the Lige 2023 smartwatch&#39;s calorie tracker feature.<\\/p>\\r\\n\\r\\n<p>&bull; Full Touch Screen :The watch features a full touch screen that makes it easy to navigate and use all its functions.<\\/p>\\r\\n\\r\\n<p>&bull; Blood Pressure Monitor :The watch comes with a blood pressure monitor, allowing you to keep track of your health and fitness levels.<\\/p>\\r\\n\\r\\n<p>&bull; Multiple Dials :The watch has multiple dials, allowing you to customize the look and feel of your watch to suit your personal style.<br \\/>\\r\\n&bull; Calorie Tracker:The watch tracks your calorie intake and expenditure, helping you stay on track with your fitness goals.<br \\/>\\r\\nProduct parameters<br \\/>\\r\\nScreen:1.69-inch TFT 240*280<br \\/>\\r\\nTouch Panel:Full touch screen<br \\/>\\r\\nBattery\\uff1a180Mah<br \\/>\\r\\nApp:FitPro<br \\/>\\r\\nCharging method\\uff1aMagnetic charging<br \\/>\\r\\nWaterproof:IP67<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-13T16:03:01.000000Z\",\"updated_at\":\"2023-11-14T09:05:35.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"121615\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 11.4, 0.6, 0, 'include', 'delivered', 'unpaid', '2023-11-26 00:03:42', '2023-11-27 00:26:55', NULL, 'Black', '{\"color\":\"Black\"}', 'discount_on_product', 1, 2),
(6, 100005, 154, 1, NULL, '{\"id\":154,\"added_by\":\"seller\",\"user_id\":1,\"name\":\"EVA Baby Wet Wipes Bag Leaf Pattern Cleaning Wipes Carrying Case Reusable Eco-fr\",\"slug\":\"eva-baby-wet-wipes-bag-leaf-pattern-cleaning-wipes-carrying-case-reusable-eco-friendly-flip-cover-tissue-box-infant-supp\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"6\\\",\\\"position\\\":1},{\\\"id\\\":\\\"108\\\",\\\"position\\\":2},{\\\"id\\\":\\\"118\\\",\\\"position\\\":3}]\",\"category_id\":\"6\",\"sub_category_id\":\"108\",\"sub_sub_category_id\":\"118\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-14-6553d3bb57426.webp\\\",\\\"2023-11-14-6553d3bb6a407.webp\\\",\\\"2023-11-14-6553d3bb7bcee.webp\\\",\\\"2023-11-14-6553d3bb93d6f.webp\\\",\\\"2023-11-14-6553d3bba88c8.webp\\\",\\\"2023-11-14-6553d3bbbb0e2.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"A9A9A9\\\",\\\"image_name\\\":\\\"2023-11-14-6553d3bb57426.webp\\\"},{\\\"color\\\":\\\"ADD8E6\\\",\\\"image_name\\\":\\\"2023-11-14-6553d3bb6a407.webp\\\"},{\\\"color\\\":\\\"FFC0CB\\\",\\\"image_name\\\":\\\"2023-11-14-6553d3bb7bcee.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-14-6553d3bb93d6f.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-14-6553d3bba88c8.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-14-6553d3bbbb0e2.webp\\\"}]\",\"thumbnail\":\"2023-11-14-6553d3bbd043e.webp\",\"featured\":1,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#A9A9A9\\\",\\\"#ADD8E6\\\",\\\"#FFC0CB\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"DarkGray\\\",\\\"price\\\":2,\\\"sku\\\":\\\"EBWWBLPCWCCREFCTBIS-DarkGray\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"LightBlue\\\",\\\"price\\\":3,\\\"sku\\\":\\\"EBWWBLPCWCCREFCTBIS-LightBlue\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Pink\\\",\\\"price\\\":3,\\\"sku\\\":\\\"EBWWBLPCWCCREFCTBIS-Pink\\\",\\\"qty\\\":1}]\",\"published\":0,\"unit_price\":3,\"purchase_price\":4,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":2,\"discount_type\":\"percent\",\"current_stock\":3,\"minimum_order_qty\":1,\"details\":\"<p>\\u273f Premium Quality Bed Pad - highly absorbent soft lining keeps moisture away from baby&#39;s skin, breathable Leakproof EVA compartment on the bottom prevents liquid from seeping through.<\\/p>\\r\\n\\r\\n<p>\\u273f More Economical and Hygienic - Reusable &amp; Washable and Do Not Fade, each baby changing pad features a little built band for convenient hanging..<\\/p>\\r\\n\\r\\n<p>\\u273f Great for At Bed or On The Go - The portable changing pad can be used to protect the bed surfaces, should your baby sleep without a diaper. It can also folded so you can change your baby&rsquo;s diaper anywhere.<\\/p>\\r\\n\\r\\n<p>\\u273f Fluorescent Free - There is No Harmful Chemicals to irritate the baby&#39;s skin. This makes our liners a perfect partner for your infant with sensitive skin.<\\/p>\\r\\n\\r\\n<p>\\u3010Patterned Mat Size\\u3011Size of 70*50 CM, lovely patterned diaper changing pad protects your baby from dirty surfaces and your baby will love resting on this changing station.<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-14T20:08:27.000000Z\",\"updated_at\":\"2023-11-14T20:25:44.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"187256\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 2, 0, 0.04, 'include', 'delivered', 'unpaid', '2023-11-26 00:09:42', '2023-11-26 00:10:02', NULL, 'DarkGray', '{\"color\":\"DarkGray\"}', 'discount_on_product', 1, 0),
(7, 100006, 177, 3, NULL, '{\"id\":177,\"added_by\":\"seller\",\"user_id\":3,\"name\":\"New Men\'s Genuine Leather Jacket Male Cowhide Overcoat Autumn Winter Business Co\",\"slug\":\"new-mens-genuine-leather-jacket-male-cowhide-overcoat-autumn-winter-business-coat-trench-style-double-breasted-clothes-c\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"3\\\",\\\"position\\\":1},{\\\"id\\\":\\\"43\\\",\\\"position\\\":2},{\\\"id\\\":\\\"56\\\",\\\"position\\\":3}]\",\"category_id\":\"3\",\"sub_category_id\":\"43\",\"sub_sub_category_id\":\"56\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-20-655b4a1f05778.webp\\\",\\\"2023-11-20-655b4a1f241a8.webp\\\",\\\"2023-11-20-655b4a1f3c0f0.webp\\\",\\\"2023-11-20-655b4a1f504fc.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-20-655b4a1f05778.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f241a8.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f3c0f0.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f504fc.webp\\\"}]\",\"thumbnail\":\"2023-11-20-655b4a1f62f01.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"M\\\",\\\"L\\\",\\\"XL\\\",\\\"2XL\\\",\\\"3XL\\\",\\\"4XL\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Black-M\\\",\\\"price\\\":106,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-M\\\",\\\"qty\\\":99},{\\\"type\\\":\\\"Black-L\\\",\\\"price\\\":100,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-L\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-XL\\\",\\\"price\\\":105,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-2XL\\\",\\\"price\\\":108,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-2XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-3XL\\\",\\\"price\\\":110,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-3XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-4XL\\\",\\\"price\\\":110,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-4XL\\\",\\\"qty\\\":100}]\",\"published\":0,\"unit_price\":110,\"purchase_price\":115,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":599,\"minimum_order_qty\":1,\"details\":\"<p>New Men&#39;s Genuine Leather Jacket Male Cowhide Overcoat Autumn Winter Business Coat Trench Style Double Breasted Clothes Calfskin<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-20T11:59:27.000000Z\",\"updated_at\":\"2023-11-21T21:20:57.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"111430\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 106, 0, 5.3, 'include', 'delivered', 'unpaid', '2023-11-26 00:11:18', '2023-11-26 00:11:41', NULL, 'Black-M', '{\"color\":\"Black\",\"Size\":\"M\"}', 'discount_on_product', 1, 0),
(8, 100006, 177, 3, NULL, '{\"id\":177,\"added_by\":\"seller\",\"user_id\":3,\"name\":\"New Men\'s Genuine Leather Jacket Male Cowhide Overcoat Autumn Winter Business Co\",\"slug\":\"new-mens-genuine-leather-jacket-male-cowhide-overcoat-autumn-winter-business-coat-trench-style-double-breasted-clothes-c\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"3\\\",\\\"position\\\":1},{\\\"id\\\":\\\"43\\\",\\\"position\\\":2},{\\\"id\\\":\\\"56\\\",\\\"position\\\":3}]\",\"category_id\":\"3\",\"sub_category_id\":\"43\",\"sub_sub_category_id\":\"56\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-20-655b4a1f05778.webp\\\",\\\"2023-11-20-655b4a1f241a8.webp\\\",\\\"2023-11-20-655b4a1f3c0f0.webp\\\",\\\"2023-11-20-655b4a1f504fc.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-20-655b4a1f05778.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f241a8.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f3c0f0.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b4a1f504fc.webp\\\"}]\",\"thumbnail\":\"2023-11-20-655b4a1f62f01.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"M\\\",\\\"L\\\",\\\"XL\\\",\\\"2XL\\\",\\\"3XL\\\",\\\"4XL\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Black-M\\\",\\\"price\\\":106,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-M\\\",\\\"qty\\\":98},{\\\"type\\\":\\\"Black-L\\\",\\\"price\\\":100,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-L\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-XL\\\",\\\"price\\\":105,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-2XL\\\",\\\"price\\\":108,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-2XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-3XL\\\",\\\"price\\\":110,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-3XL\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-4XL\\\",\\\"price\\\":110,\\\"sku\\\":\\\"NMGLJMCOAWBCTSDBCC-Black-4XL\\\",\\\"qty\\\":100}]\",\"published\":0,\"unit_price\":110,\"purchase_price\":115,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":598,\"minimum_order_qty\":1,\"details\":\"<p>New Men&#39;s Genuine Leather Jacket Male Cowhide Overcoat Autumn Winter Business Coat Trench Style Double Breasted Clothes Calfskin<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-20T11:59:27.000000Z\",\"updated_at\":\"2023-11-25T21:11:18.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"111430\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 105, 0, 5.25, 'include', 'delivered', 'unpaid', '2023-11-26 00:11:18', '2023-11-26 00:11:41', NULL, 'Black-XL', '{\"color\":\"Black\",\"Size\":\"XL\"}', 'discount_on_product', 1, 0),
(9, 100007, 173, 3, NULL, '{\"id\":173,\"added_by\":\"seller\",\"user_id\":3,\"name\":\"Baby Shoe Boys\\/Girls Toddler Shoe 2023Summer New Boy Breathable Mesh Sports Shoe\",\"slug\":\"baby-shoe-boysgirls-toddler-shoe-2023summer-new-boy-breathable-mesh-sports-shoe-girls-shoe-soft-sole-casual-shoe-kids-sh\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"6\\\",\\\"position\\\":1},{\\\"id\\\":\\\"192\\\",\\\"position\\\":2},{\\\"id\\\":\\\"237\\\",\\\"position\\\":3}]\",\"category_id\":\"6\",\"sub_category_id\":\"192\",\"sub_sub_category_id\":\"237\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-17-6557bef598c8e.webp\\\",\\\"2023-11-17-6557bef5b2140.webp\\\",\\\"2023-11-17-6557bef5c8499.webp\\\",\\\"2023-11-17-6557bef5e82ae.webp\\\",\\\"2023-11-17-6557c72f8d6cf.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"808080\\\",\\\"image_name\\\":\\\"2023-11-17-6557bef598c8e.webp\\\"},{\\\"color\\\":\\\"FFC0CB\\\",\\\"image_name\\\":\\\"2023-11-17-6557bef5b2140.webp\\\"},{\\\"color\\\":\\\"FFFFFF\\\",\\\"image_name\\\":\\\"2023-11-17-6557bef5c8499.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-17-6557bef5e82ae.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-17-6557c72f8d6cf.webp\\\"}]\",\"thumbnail\":\"2023-11-17-6557bef60d4a3.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#808080\\\",\\\"#FFC0CB\\\",\\\"#FFFFFF\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"16\\\",\\\"      17\\\",\\\"      18\\\",\\\"      19\\\",\\\"      20\\\",\\\"      21\\\",\\\"      22\\\",\\\"      23\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Gray-16\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-Gray-16\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Gray-17\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Gray-17\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Gray-18\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Gray-18\\\",\\\"qty\\\":111},{\\\"type\\\":\\\"Gray-19\\\",\\\"price\\\":10,\\\"sku\\\":\\\"BSBTS2NBBMSS-Gray-19\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Gray-20\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Gray-20\\\",\\\"qty\\\":111},{\\\"type\\\":\\\"Gray-21\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-Gray-21\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Gray-22\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-Gray-22\\\",\\\"qty\\\":111},{\\\"type\\\":\\\"Gray-23\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Gray-23\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Pink-16\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Pink-16\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Pink-17\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-Pink-17\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Pink-18\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Pink-18\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Pink-19\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Pink-19\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Pink-20\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-Pink-20\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Pink-21\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Pink-21\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Pink-22\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-Pink-22\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Pink-23\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-Pink-23\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-16\\\",\\\"price\\\":10,\\\"sku\\\":\\\"BSBTS2NBBMSS-White-16\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-17\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-White-17\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-18\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-White-18\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-19\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-White-19\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-20\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-White-20\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-21\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-White-21\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-22\\\",\\\"price\\\":12,\\\"sku\\\":\\\"BSBTS2NBBMSS-White-22\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-23\\\",\\\"price\\\":11,\\\"sku\\\":\\\"BSBTS2NBBMSS-White-23\\\",\\\"qty\\\":100}]\",\"published\":0,\"unit_price\":12,\"purchase_price\":15,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":2433,\"minimum_order_qty\":1,\"details\":\"<p>Baby Shoe Boys\\/Girls Toddler Shoe 2023Summer New Boy Breathable Mesh Sports Shoe Girls shoe Soft Sole Casual Shoe Kids Shoe T&ecirc;nis<br \\/>\\r\\n&nbsp;<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-17T19:28:54.000000Z\",\"updated_at\":\"2023-11-20T15:40:59.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"120815\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 5, 12, 0, 3, 'include', 'delivered', 'unpaid', '2023-11-26 00:13:13', '2023-11-26 00:21:00', NULL, 'Gray-18', '{\"color\":\"Gray\",\"Size\":\"18\"}', 'discount_on_product', 1, 2),
(10, 100008, 123, 1, NULL, '{\"id\":123,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"Summer High Waist Slim Shorts Women Korean Tight Elastic Bag Hip Three-point Hot\",\"slug\":\"summer-high-waist-slim-shorts-women-korean-tight-elastic-bag-hip-three-point-hot-pants-casual-outer-wear-bottoms-female-\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"2\\\",\\\"position\\\":1},{\\\"id\\\":\\\"19\\\",\\\"position\\\":2},{\\\"id\\\":\\\"21\\\",\\\"position\\\":3}]\",\"category_id\":\"2\",\"sub_category_id\":\"19\",\"sub_sub_category_id\":\"21\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-08-654bd83e96d06.png\\\",\\\"2023-11-08-654bd83e97d29.png\\\",\\\"2023-11-08-654bd83e9bb08.png\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-08-654bd83e96d06.png\\\"},{\\\"color\\\":\\\"FFFFFF\\\",\\\"image_name\\\":\\\"2023-11-08-654bd83e97d29.png\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-08-654bd83e9bb08.png\\\"}]\",\"thumbnail\":\"2023-11-08-654bd83e9bdde.png\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#FFFFFF\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"S\\\",\\\"M\\\",\\\"L\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Black-S\\\",\\\"price\\\":6,\\\"sku\\\":\\\"SHWSSWKTEBHTHPCOWBFC-Black-S\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-M\\\",\\\"price\\\":6,\\\"sku\\\":\\\"SHWSSWKTEBHTHPCOWBFC-Black-M\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Black-L\\\",\\\"price\\\":7,\\\"sku\\\":\\\"SHWSSWKTEBHTHPCOWBFC-Black-L\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-S\\\",\\\"price\\\":7,\\\"sku\\\":\\\"SHWSSWKTEBHTHPCOWBFC-White-S\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-M\\\",\\\"price\\\":7,\\\"sku\\\":\\\"SHWSSWKTEBHTHPCOWBFC-White-M\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"White-L\\\",\\\"price\\\":8,\\\"sku\\\":\\\"SHWSSWKTEBHTHPCOWBFC-White-L\\\",\\\"qty\\\":100}]\",\"published\":0,\"unit_price\":6,\"purchase_price\":7,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":2.99,\"discount_type\":\"percent\",\"current_stock\":600,\"minimum_order_qty\":1,\"details\":\"<p>Summer High Waist Slim Shorts Women Korean Tight Elastic Bag Hip Three-point Hot Pants Casual Outer Wear Bottoms Female Clothes<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-08T18:49:34.000000Z\",\"updated_at\":\"2023-11-08T18:49:34.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.png\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"173934\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 3, 7, 0, 0.6279, 'include', 'delivered', 'unpaid', '2023-11-26 00:13:17', '2023-11-26 00:16:49', NULL, 'Black-L', '{\"color\":\"Black\",\"Size\":\"L\"}', 'discount_on_product', 1, 2),
(11, 100009, 151, 1, NULL, '{\"id\":151,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"2023 Global Version New PAD 6 PRO Tablet Android12 11 Inch 16GB 1T 5G Dual SIM P\",\"slug\":\"2023-global-version-new-pad-6-pro-tablet-android12-11-inch-16gb-1t-5g-dual-sim-phone-call-gps-bluetooth-wifi-google-tabl\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"11\\\",\\\"position\\\":1},{\\\"id\\\":\\\"165\\\",\\\"position\\\":2},{\\\"id\\\":\\\"172\\\",\\\"position\\\":3}]\",\"category_id\":\"11\",\"sub_category_id\":\"165\",\"sub_sub_category_id\":\"172\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-14-65528ef8ba5ba.webp\\\",\\\"2023-11-14-65528ef8cbe9e.webp\\\",\\\"2023-11-14-65528ef8e2fa2.webp\\\",\\\"2023-11-14-65528ef902d4d.webp\\\",\\\"2023-11-14-65528ef91d758.webp\\\",\\\"2023-11-14-65528ef93293a.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"0000FF\\\",\\\"image_name\\\":\\\"2023-11-14-65528ef8ba5ba.webp\\\"},{\\\"color\\\":\\\"808080\\\",\\\"image_name\\\":\\\"2023-11-14-65528ef8cbe9e.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-14-65528ef8e2fa2.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-14-65528ef902d4d.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-14-65528ef91d758.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-14-65528ef93293a.webp\\\"}]\",\"thumbnail\":\"2023-11-14-65528ef945c39.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#0000FF\\\",\\\"#808080\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Blue\\\",\\\"price\\\":92,\\\"sku\\\":\\\"2GVNP6PTA1I115DSPCGBWGTP-Blue\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"Gray\\\",\\\"price\\\":90,\\\"sku\\\":\\\"2GVNP6PTA1I115DSPCGBWGTP-Gray\\\",\\\"qty\\\":100}]\",\"published\":0,\"unit_price\":92,\"purchase_price\":100,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":200,\"minimum_order_qty\":1,\"details\":\"<p>2023 Global Version New PAD 6 PRO Tablet Android12 11 Inch 16GB 1T 5G Dual SIM Phone Call GPS Bluetooth WiFi Google Tablet PC<br \\/>\\r\\n<br \\/>\\r\\n<strong>Specification:<\\/strong><br \\/>\\r\\nModel No.: Pad 6 Pro<br \\/>\\r\\nCPU: Snapdragon870 Deca Core (Latest 10 Core)<br \\/>\\r\\nSIM\\/TF: 2 SIM Card Slots (Nano SIM) + 1 TF Card Slots (Maximum support extension 128GB)<br \\/>\\r\\nScreen: 11 Inch 4K Screen<br \\/>\\r\\nResolution :2560*1600<br \\/>\\r\\nCamera: Front Camera 16MP+ Rear Camera 32MP<br \\/>\\r\\nMemory: 16GB RAM+1T ROM\\/12GB RAM+512GB\\/ ROM 6GB RAM+128GB ROM<br \\/>\\r\\nSystem: Android 12 System<br \\/>\\r\\nBattery: 10000mAh High Density Lithium-ion battery<br \\/>\\r\\nUnique Back Cover: Hot Bend 3D Plating Gradient Glass Back Cover. It is art, it is also technology!<br \\/>\\r\\nNet-Work: GSM850\\/900\\/1800\\/1900MHz, 3G: WCDMA850\\/1900\\/2100MHz, 4G,5G<br \\/>\\r\\nVibration:Support<br \\/>\\r\\nMulti Media: MP3\\/MP4\\/3GP\\/FM Radio\\/Bluetooth<br \\/>\\r\\nMulti Function: Full screen, Face recognition,Screen finger print, Dual SIM, Wifi, GPS, Gravity Sensor, Alarm ,<br \\/>\\r\\nCalendar,Calculator,Audio recorder ,Video recorder, WAP\\/MMS\\/GPR, Image viewer,E-Book,World clock<br \\/>\\r\\nLanguages: Multi-language support<br \\/>\\r\\nThe Tablet support &nbsp;T-mobile,AT&amp;T,Straight Talk,Cricket Wireless,Google Project Fi,Lycamobile,MetroPCS ,MintMobile, does not support the Telecom CDMA network. (For example USA &nbsp;operators:Verizon,Sprint,U.S Cellular,Boost Mobile,FreedomPop,Ting)<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-13T21:02:49.000000Z\",\"updated_at\":\"2023-11-13T21:02:49.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"157210\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 92, 0, 4.6, 'include', 'delivered', 'paid', '2023-11-27 00:43:48', '2023-11-27 00:43:48', NULL, 'Blue', '{\"color\":\"Blue\"}', 'discount_on_product', 1, 0),
(12, 100010, 147, 1, NULL, '{\"id\":147,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"JJ Funny Doll Function Crawling Baby with Battery Operated Laughing Singing Acco\",\"slug\":\"jj-funny-doll-function-crawling-baby-with-battery-operated-laughing-singing-accompany-with-your-children-size-105-inches\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"7\\\",\\\"position\\\":1},{\\\"id\\\":\\\"123\\\",\\\"position\\\":2},{\\\"id\\\":\\\"131\\\",\\\"position\\\":3}]\",\"category_id\":\"7\",\"sub_category_id\":\"123\",\"sub_sub_category_id\":\"131\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-13-655240faad484.webp\\\",\\\"2023-11-13-655240fabee3a.webp\\\",\\\"2023-11-13-655240fadd5f1.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"FF69B4\\\",\\\"image_name\\\":\\\"2023-11-13-655240faad484.webp\\\"},{\\\"color\\\":\\\"ADD8E6\\\",\\\"image_name\\\":\\\"2023-11-13-655240fabee3a.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655240fadd5f1.webp\\\"}]\",\"thumbnail\":\"2023-11-13-655240faf3724.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#FF69B4\\\",\\\"#ADD8E6\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"HotPink\\\",\\\"price\\\":7,\\\"sku\\\":\\\"JFDFCBwBOLSAwYCS1I-HotPink\\\",\\\"qty\\\":100},{\\\"type\\\":\\\"LightBlue\\\",\\\"price\\\":6,\\\"sku\\\":\\\"JFDFCBwBOLSAwYCS1I-LightBlue\\\",\\\"qty\\\":100}]\",\"published\":0,\"unit_price\":7,\"purchase_price\":8,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":3,\"discount_type\":\"percent\",\"current_stock\":200,\"minimum_order_qty\":1,\"details\":\"<p>JJ Funny Doll Function Crawling Baby with Battery Operated Laughing Singing Accompany with Your Children Size 10.5 Inches<br \\/>\\r\\n&nbsp;<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-13T15:30:02.000000Z\",\"updated_at\":\"2023-11-13T15:30:02.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"174949\",\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 7, 0, 0.21, 'include', 'delivered', 'paid', '2023-11-27 00:44:49', '2023-11-27 00:44:49', NULL, 'HotPink', '{\"color\":\"HotPink\"}', 'discount_on_product', 1, 0);
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `seller_id`, `digital_file_after_sell`, `product_details`, `qty`, `price`, `tax`, `discount`, `tax_model`, `delivery_status`, `payment_status`, `created_at`, `updated_at`, `shipping_method_id`, `variant`, `variation`, `discount_type`, `is_stock_decreased`, `refund_request`) VALUES
(13, 100011, 160, 1, NULL, '{\"id\":160,\"added_by\":\"seller\",\"user_id\":1,\"name\":\"Original Samsung Galaxy A71 5G A716U\\/U1 Mobile CellPhone 6.7\\\" RAM 6GB ROM 128GB \",\"slug\":\"original-samsung-galaxy-a71-5g-a716uu1-mobile-cellphone-67-ram-6gb-rom-128gb-4-camera-fingerprint-android-unlocked-smart\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"11\\\",\\\"position\\\":1},{\\\"id\\\":\\\"166\\\",\\\"position\\\":2},{\\\"id\\\":\\\"176\\\",\\\"position\\\":3}]\",\"category_id\":\"11\",\"sub_category_id\":\"166\",\"sub_sub_category_id\":\"176\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-15-6554b7dde6c23.webp\\\",\\\"2023-11-15-6554b7de04eb9.webp\\\",\\\"2023-11-15-6554b7de1bf08.webp\\\",\\\"2023-11-15-6554b7de2c59e.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-15-6554b7dde6c23.webp\\\"},{\\\"color\\\":\\\"ADD8E6\\\",\\\"image_name\\\":\\\"2023-11-15-6554b7de04eb9.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-15-6554b7de1bf08.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-15-6554b7de2c59e.webp\\\"}]\",\"thumbnail\":\"2023-11-15-6554b7de3e5df.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#ADD8E6\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":175,\\\"sku\\\":\\\"OSGA5AMC6R6R14CFAUS-Black\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"LightBlue\\\",\\\"price\\\":175,\\\"sku\\\":\\\"OSGA5AMC6R6R14CFAUS-LightBlue\\\",\\\"qty\\\":1}]\",\"published\":0,\"unit_price\":175,\"purchase_price\":180,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":2,\"minimum_order_qty\":1,\"details\":\"<p>Original Samsung Galaxy A71 5G A716U\\/U1 Mobile CellPhone 6.7&quot; RAM 6GB ROM 128GB 4 Camera Fingerprint Android Unlocked Smartphone<br \\/>\\r\\n&nbsp;<\\/p>\\r\\n\\r\\n<p>1.About Version: U\\/U1 is the US version that does not support OTA update, but U1 supports OTA update, we send U1 version to customers. About Global version with full languages and supports OTA update.<\\/p>\\r\\n\\r\\n<p>2. About Language: For U\\/U1 version, when you turn on the phone, maybe there only be Deutsch\\/French\\/ Spanish\\/ Portuguese \\/ Italian \\/ Japanese \\/ Korean \\/ Vietnamese \\/ Chinese languages options, but you can add your languages by yourself easily. If you don&#39;t know how to do it, please contact us to get a video of the setting.<\\/p>\\r\\n\\r\\n<p>For U\\/U1 version, some languages (such as Russian, Arabic, Hebrew, Polish, etc.) are only partial in this phone. That means even if you set the default language to Russian \\/ Arabic \\/ Hebrew \\/ Polish, there still are about 50% menus showing in English. But the other languages are completed.<br \\/>\\r\\n3.About Memory: The internal storage will be less than the specification since part of it will be occupied by built-in systems and apps. For example, ROM is 128GB, but only 110-123GB can be used, it is normal.<br \\/>\\r\\n4. About Battery: The battery efficiency of the phone will be less than the standard. Normally Battery capacity is about 80%-90%. We do not accept any tests from the third-party application.<br \\/>\\r\\n5. About Phone: TestThis is a used phone, not brand new, we will test the phone to make sure it&rsquo;s working fine and in good condition too.<\\/p>\\r\\n\\r\\n<p>6.About Waterproof: The phones do NOT support waterproofing anymore, as the phone is exchanging the new housing from the USED phone.<br \\/>\\r\\n7.About accessories: All accessories are not original, but of good quality, any dispute for &quot;Fake accessories&quot; will not be accepted, we don&#39;t offer a warranty for the accessories<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-15T12:21:50.000000Z\",\"updated_at\":\"2023-11-15T20:54:27.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"115128\",\"shipping_country\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 175, 0, 8.75, 'include', 'pending', 'unpaid', '2023-12-29 00:52:30', '2023-12-29 00:52:30', NULL, 'Black', '{\"color\":\"Black\"}', 'discount_on_product', 1, 0),
(14, 100012, 114, 1, NULL, '{\"id\":114,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"Bespoke V-neck A-line Wedding Dress with Spaghetti Straps Chapel Train Abito Da \",\"slug\":\"bespoke-v-neck-a-line-wedding-dress-with-spaghetti-straps-chapel-train-abito-da-sposa-completamente-in-pizzo-macrame-bac\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"2\\\",\\\"position\\\":1},{\\\"id\\\":\\\"16\\\",\\\"position\\\":2},{\\\"id\\\":\\\"27\\\",\\\"position\\\":3}]\",\"category_id\":\"2\",\"sub_category_id\":\"16\",\"sub_sub_category_id\":\"27\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-07-654a3d1704f10.png\\\",\\\"2023-11-07-654a3d1705f47.png\\\",\\\"2023-11-07-654a3d170613c.png\\\"]\",\"color_image\":\"[]\",\"thumbnail\":\"2023-11-07-654a3d170636e.png\",\"featured\":1,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"2\\\",\\\"4\\\",\\\"6\\\",\\\"8\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"2\\\",\\\"price\\\":111,\\\"sku\\\":\\\"BVAWDwSSCTADSCiPMB-2\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"4\\\",\\\"price\\\":110,\\\"sku\\\":\\\"BVAWDwSSCTADSCiPMB-4\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"6\\\",\\\"price\\\":112,\\\"sku\\\":\\\"BVAWDwSSCTADSCiPMB-6\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"8\\\",\\\"price\\\":115,\\\"sku\\\":\\\"BVAWDwSSCTADSCiPMB-8\\\",\\\"qty\\\":50}]\",\"published\":0,\"unit_price\":110,\"purchase_price\":120,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":200,\"minimum_order_qty\":1,\"details\":\"<p>Bespoke V-neck A-line Wedding Dress with Spaghetti Straps Chapel Train Abito Da Sposa Completamente in Pizzo Macram&egrave; Backless<br \\/>\\r\\n&nbsp;<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-07T13:35:19.000000Z\",\"updated_at\":\"2023-11-14T09:06:12.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.png\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"180433\",\"shipping_country\":null,\"origin\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 111, 0, 5.55, 'include', 'canceled', 'unpaid', '2024-01-18 23:56:39', '2024-01-22 14:27:10', NULL, '2', '{\"Size\":\"2\"}', 'discount_on_product', 0, 0),
(15, 100013, 149, 1, NULL, '{\"id\":149,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watche\",\"slug\":\"lige-2023-smart-watch-for-men-women-gift-full-touch-screen-sports-fitness-watches-bluetooth-calls-digital-smartwatch-wri\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"9\\\",\\\"position\\\":1},{\\\"id\\\":\\\"136\\\",\\\"position\\\":2},{\\\"id\\\":\\\"143\\\",\\\"position\\\":3}]\",\"category_id\":\"9\",\"sub_category_id\":\"136\",\"sub_sub_category_id\":\"143\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-13-655248b45e7e3.webp\\\",\\\"2023-11-13-655248b47207f.webp\\\",\\\"2023-11-13-655248b487e48.webp\\\",\\\"2023-11-13-655248b4995af.webp\\\",\\\"2023-11-13-655248b4aea0f.webp\\\",\\\"2023-11-13-655248b4c9c47.webp\\\",\\\"2023-11-13-655248b4de60d.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-13-655248b45e7e3.webp\\\"},{\\\"color\\\":\\\"696969\\\",\\\"image_name\\\":\\\"2023-11-13-655248b47207f.webp\\\"},{\\\"color\\\":\\\"DAA520\\\",\\\"image_name\\\":\\\"2023-11-13-655248b487e48.webp\\\"},{\\\"color\\\":\\\"808080\\\",\\\"image_name\\\":\\\"2023-11-13-655248b4995af.webp\\\"},{\\\"color\\\":\\\"FFB6C1\\\",\\\"image_name\\\":\\\"2023-11-13-655248b4aea0f.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655248b4c9c47.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655248b4de60d.webp\\\"}]\",\"thumbnail\":\"2023-11-13-655248b50227d.webp\",\"featured\":1,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#696969\\\",\\\"#DAA520\\\",\\\"#808080\\\",\\\"#FFB6C1\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Black\\\",\\\"qty\\\":0},{\\\"type\\\":\\\"DimGray\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-DimGray\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Goldenrod\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Goldenrod\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Gray\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Gray\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"LightPink\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-LightPink\\\",\\\"qty\\\":1}]\",\"published\":0,\"unit_price\":12,\"purchase_price\":15,\"tax\":5,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":0,\"discount_type\":\"percent\",\"current_stock\":4,\"minimum_order_qty\":1,\"details\":\"<p>LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watches Bluetooth Calls Digital Smartwatch Wristwatch<br \\/>\\r\\n&nbsp;<\\/p>\\r\\n\\r\\n<p>&bull; Full Touch Screen :The Lige 2023 smartwatch features a full touch screen that allows for easy and intuitive navigation.<\\/p>\\r\\n\\r\\n<p>&bull; Blood Pressure Monitor :With a built-in blood pressure monitor, this smartwatch can help you keep track of your health and fitness levels.<\\/p>\\r\\n\\r\\n<p>&bull; Multiple Dials :Choose from a variety of watch faces to customize your Lige 2023 smartwatch to your personal style.<\\/p>\\r\\n\\r\\n<p>&bull; Calorie Tracker :Keep track of your daily calorie burn with the Lige 2023 smartwatch&#39;s calorie tracker feature.<\\/p>\\r\\n\\r\\n<p>&bull; Full Touch Screen :The watch features a full touch screen that makes it easy to navigate and use all its functions.<\\/p>\\r\\n\\r\\n<p>&bull; Blood Pressure Monitor :The watch comes with a blood pressure monitor, allowing you to keep track of your health and fitness levels.<\\/p>\\r\\n\\r\\n<p>&bull; Multiple Dials :The watch has multiple dials, allowing you to customize the look and feel of your watch to suit your personal style.<br \\/>\\r\\n&bull; Calorie Tracker:The watch tracks your calorie intake and expenditure, helping you stay on track with your fitness goals.<br \\/>\\r\\nProduct parameters<br \\/>\\r\\nScreen:1.69-inch TFT 240*280<br \\/>\\r\\nTouch Panel:Full touch screen<br \\/>\\r\\nBattery\\uff1a180Mah<br \\/>\\r\\nApp:FitPro<br \\/>\\r\\nCharging method\\uff1aMagnetic charging<br \\/>\\r\\nWaterproof:IP67<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-13T16:03:01.000000Z\",\"updated_at\":\"2023-12-02T08:56:42.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"121615\",\"shipping_country\":\"[\\\"AF\\\",\\\"AX\\\",\\\"AL\\\",\\\"DZ\\\",\\\"AS\\\",\\\"AD\\\",\\\"AO\\\",\\\"AI\\\",\\\"AQ\\\",\\\"AG\\\",\\\"AR\\\",\\\"AM\\\",\\\"AW\\\",\\\"AU\\\",\\\"AT\\\",\\\"AZ\\\",\\\"BS\\\",\\\"BH\\\",\\\"BD\\\",\\\"BB\\\",\\\"BY\\\",\\\"BE\\\",\\\"BZ\\\",\\\"BJ\\\",\\\"BM\\\",\\\"BT\\\",\\\"BO\\\",\\\"BA\\\",\\\"BW\\\",\\\"BV\\\",\\\"BR\\\",\\\"IO\\\",\\\"BN\\\",\\\"BG\\\",\\\"BF\\\",\\\"BI\\\",\\\"KH\\\",\\\"CM\\\",\\\"CA\\\",\\\"CV\\\",\\\"KY\\\",\\\"CF\\\",\\\"TD\\\",\\\"CL\\\",\\\"CN\\\",\\\"CX\\\",\\\"CC\\\",\\\"CO\\\",\\\"KM\\\",\\\"CG\\\",\\\"CD\\\",\\\"CK\\\",\\\"CR\\\",\\\"CI\\\",\\\"HR\\\",\\\"CU\\\",\\\"CY\\\",\\\"CZ\\\",\\\"DK\\\",\\\"DJ\\\",\\\"DM\\\",\\\"DO\\\",\\\"EC\\\",\\\"EG\\\",\\\"SV\\\",\\\"GQ\\\",\\\"ER\\\",\\\"EE\\\",\\\"ET\\\",\\\"FK\\\",\\\"FO\\\",\\\"FJ\\\",\\\"FI\\\",\\\"FR\\\",\\\"GF\\\",\\\"PF\\\",\\\"TF\\\",\\\"GA\\\",\\\"GM\\\",\\\"GE\\\",\\\"DE\\\",\\\"GH\\\",\\\"GI\\\",\\\"GR\\\",\\\"GL\\\",\\\"GD\\\",\\\"GP\\\",\\\"GU\\\",\\\"GT\\\",\\\"GG\\\",\\\"GN\\\",\\\"GW\\\",\\\"GY\\\",\\\"HT\\\",\\\"HM\\\",\\\"VA\\\",\\\"HN\\\",\\\"HK\\\",\\\"HU\\\",\\\"IS\\\",\\\"IN\\\",\\\"ID\\\",\\\"IR\\\",\\\"IQ\\\",\\\"IE\\\",\\\"IM\\\",\\\"IL\\\",\\\"IT\\\",\\\"JM\\\",\\\"JP\\\",\\\"JE\\\",\\\"JO\\\",\\\"KZ\\\",\\\"KE\\\",\\\"KI\\\",\\\"KP\\\",\\\"KR\\\",\\\"KW\\\",\\\"KG\\\",\\\"LA\\\",\\\"LV\\\",\\\"LB\\\",\\\"LS\\\",\\\"LR\\\",\\\"LY\\\",\\\"LI\\\",\\\"LT\\\",\\\"LU\\\",\\\"MO\\\",\\\"MK\\\",\\\"MG\\\",\\\"MW\\\",\\\"MY\\\",\\\"MV\\\",\\\"ML\\\",\\\"MT\\\",\\\"MH\\\",\\\"MQ\\\",\\\"MR\\\",\\\"MU\\\",\\\"YT\\\",\\\"MX\\\",\\\"FM\\\",\\\"MD\\\",\\\"MC\\\",\\\"MN\\\",\\\"MS\\\",\\\"MA\\\",\\\"MZ\\\",\\\"MM\\\",\\\"NA\\\",\\\"NR\\\",\\\"NP\\\",\\\"NL\\\",\\\"AN\\\",\\\"NC\\\",\\\"NZ\\\",\\\"NI\\\",\\\"NE\\\",\\\"NG\\\",\\\"NU\\\",\\\"NF\\\",\\\"MP\\\",\\\"NO\\\",\\\"OM\\\",\\\"PK\\\",\\\"PW\\\",\\\"PS\\\",\\\"PA\\\",\\\"PG\\\",\\\"PY\\\",\\\"PE\\\",\\\"PH\\\",\\\"PN\\\",\\\"PL\\\",\\\"PT\\\",\\\"PR\\\",\\\"QA\\\",\\\"RE\\\",\\\"RO\\\",\\\"RU\\\",\\\"RW\\\",\\\"SH\\\",\\\"KN\\\",\\\"LC\\\",\\\"PM\\\",\\\"VC\\\",\\\"WS\\\",\\\"SM\\\",\\\"ST\\\",\\\"SA\\\",\\\"SN\\\",\\\"CS\\\",\\\"SC\\\",\\\"SL\\\",\\\"SG\\\",\\\"SK\\\",\\\"SI\\\",\\\"SB\\\",\\\"SO\\\",\\\"ZA\\\",\\\"GS\\\",\\\"ES\\\",\\\"LK\\\",\\\"SD\\\",\\\"SR\\\",\\\"SJ\\\",\\\"SZ\\\",\\\"SE\\\",\\\"CH\\\",\\\"SY\\\",\\\"TW\\\",\\\"TJ\\\",\\\"TZ\\\",\\\"TH\\\",\\\"TL\\\",\\\"TG\\\",\\\"TK\\\",\\\"TO\\\",\\\"TT\\\",\\\"TN\\\",\\\"TR\\\",\\\"TM\\\",\\\"TC\\\",\\\"TV\\\",\\\"UG\\\",\\\"UA\\\",\\\"AE\\\",\\\"GB\\\",\\\"US\\\",\\\"UM\\\",\\\"UY\\\",\\\"UZ\\\",\\\"VU\\\",\\\"VE\\\",\\\"VN\\\",\\\"VG\\\",\\\"VI\\\",\\\"WF\\\",\\\"EH\\\",\\\"YE\\\",\\\"ZM\\\",\\\"ZW\\\"]\",\"origin\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 11.4, 0.6, 0, 'include', 'pending', 'unpaid', '2024-01-22 14:24:20', '2024-01-22 14:24:20', NULL, 'LightPink', '{\"color\":\"LightPink\"}', 'discount_on_product', 1, 0),
(16, 100014, 143, 1, NULL, '{\"id\":143,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"Leather Pants Mens Stretch Slim-Fit Winter Fleece-Lined Thickened Riding Tight F\",\"slug\":\"leather-pants-mens-stretch-slim-fit-winter-fleece-lined-thickened-riding-tight-feet-warm-man-leather-motorcycle-pants-wa\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"3\\\",\\\"position\\\":1},{\\\"id\\\":\\\"42\\\",\\\"position\\\":2},{\\\"id\\\":\\\"52\\\",\\\"position\\\":3}]\",\"category_id\":\"3\",\"sub_category_id\":\"42\",\"sub_sub_category_id\":\"52\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-11-654f6aba8579f.webp\\\",\\\"2023-11-11-654f6aba9f422.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-11-654f6aba8579f.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-11-654f6aba9f422.webp\\\"}]\",\"thumbnail\":\"2023-11-11-654f6abab20c2.webp\",\"featured\":1,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"28\\\",\\\"  29\\\",\\\"  30\\\",\\\"  31\\\",\\\"  32\\\",\\\"  33\\\",\\\"  34\\\",\\\"  36\\\",\\\"  37\\\",\\\"  38\\\",\\\"  39\\\",\\\"  40\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Black-28\\\",\\\"price\\\":30,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-28\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-29\\\",\\\"price\\\":31,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-29\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-30\\\",\\\"price\\\":29,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-30\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-31\\\",\\\"price\\\":30,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-31\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-32\\\",\\\"price\\\":30,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-32\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-33\\\",\\\"price\\\":29,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-33\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-34\\\",\\\"price\\\":28,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-34\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-36\\\",\\\"price\\\":30,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-36\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-37\\\",\\\"price\\\":31,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-37\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-38\\\",\\\"price\\\":30,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-38\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-39\\\",\\\"price\\\":29,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-39\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Black-40\\\",\\\"price\\\":30,\\\"sku\\\":\\\"LPMSSWFTRTFWMLMPW-Black-40\\\",\\\"qty\\\":50}]\",\"published\":0,\"unit_price\":30,\"purchase_price\":35,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":3,\"discount_type\":\"percent\",\"current_stock\":600,\"minimum_order_qty\":1,\"details\":\"<p>Leather Pants Mens Stretch Slim-Fit Winter Fleece-Lined Thickened Riding Tight Feet Warm Man Leather Motorcycle Pants Waterproof<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-11T11:51:22.000000Z\",\"updated_at\":\"2023-12-02T08:49:24.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"162297\",\"shipping_country\":\"[\\\"AF\\\",\\\"AX\\\",\\\"AL\\\",\\\"DZ\\\",\\\"AS\\\",\\\"AD\\\",\\\"AO\\\",\\\"AI\\\",\\\"AQ\\\",\\\"AG\\\",\\\"AR\\\",\\\"AM\\\",\\\"AW\\\",\\\"AU\\\",\\\"AT\\\",\\\"AZ\\\",\\\"BS\\\",\\\"BH\\\",\\\"BD\\\",\\\"BB\\\",\\\"BY\\\",\\\"BE\\\",\\\"BZ\\\",\\\"BJ\\\",\\\"BM\\\",\\\"BT\\\",\\\"BO\\\",\\\"BA\\\",\\\"BW\\\",\\\"BV\\\",\\\"BR\\\",\\\"IO\\\",\\\"BN\\\",\\\"BG\\\",\\\"BF\\\",\\\"BI\\\",\\\"KH\\\",\\\"CM\\\",\\\"CA\\\",\\\"CV\\\",\\\"KY\\\",\\\"CF\\\",\\\"TD\\\",\\\"CL\\\",\\\"CN\\\",\\\"CX\\\",\\\"CC\\\",\\\"CO\\\",\\\"KM\\\",\\\"CG\\\",\\\"CD\\\",\\\"CK\\\",\\\"CR\\\",\\\"CI\\\",\\\"HR\\\",\\\"CU\\\",\\\"CY\\\",\\\"CZ\\\",\\\"DK\\\",\\\"DJ\\\",\\\"DM\\\",\\\"DO\\\",\\\"EC\\\",\\\"EG\\\",\\\"SV\\\",\\\"GQ\\\",\\\"ER\\\",\\\"EE\\\",\\\"ET\\\",\\\"FK\\\",\\\"FO\\\",\\\"FJ\\\",\\\"FI\\\",\\\"FR\\\",\\\"GF\\\",\\\"PF\\\",\\\"TF\\\",\\\"GA\\\",\\\"GM\\\",\\\"GE\\\",\\\"DE\\\",\\\"GH\\\",\\\"GI\\\",\\\"GR\\\",\\\"GL\\\",\\\"GD\\\",\\\"GP\\\",\\\"GU\\\",\\\"GT\\\",\\\"GG\\\",\\\"GN\\\",\\\"GW\\\",\\\"GY\\\",\\\"HT\\\",\\\"HM\\\",\\\"VA\\\",\\\"HN\\\",\\\"HK\\\",\\\"HU\\\",\\\"IS\\\",\\\"IN\\\",\\\"ID\\\",\\\"IR\\\",\\\"IQ\\\",\\\"IE\\\",\\\"IM\\\",\\\"IL\\\",\\\"IT\\\",\\\"JM\\\",\\\"JP\\\",\\\"JE\\\",\\\"JO\\\",\\\"KZ\\\",\\\"KE\\\",\\\"KI\\\",\\\"KP\\\",\\\"KR\\\",\\\"KW\\\",\\\"KG\\\",\\\"LA\\\",\\\"LV\\\",\\\"LB\\\",\\\"LS\\\",\\\"LR\\\",\\\"LY\\\",\\\"LI\\\",\\\"LT\\\",\\\"LU\\\",\\\"MO\\\",\\\"MK\\\",\\\"MG\\\",\\\"MW\\\",\\\"MY\\\",\\\"MV\\\",\\\"ML\\\",\\\"MT\\\",\\\"MH\\\",\\\"MQ\\\",\\\"MR\\\",\\\"MU\\\",\\\"YT\\\",\\\"MX\\\",\\\"FM\\\",\\\"MD\\\",\\\"MC\\\",\\\"MN\\\",\\\"MS\\\",\\\"MA\\\",\\\"MZ\\\",\\\"MM\\\",\\\"NA\\\",\\\"NR\\\",\\\"NP\\\",\\\"NL\\\",\\\"AN\\\",\\\"NC\\\",\\\"NZ\\\",\\\"NI\\\",\\\"NE\\\",\\\"NG\\\",\\\"NU\\\",\\\"NF\\\",\\\"MP\\\",\\\"NO\\\",\\\"OM\\\",\\\"PK\\\",\\\"PW\\\",\\\"PS\\\",\\\"PA\\\",\\\"PG\\\",\\\"PY\\\",\\\"PE\\\",\\\"PH\\\",\\\"PN\\\",\\\"PL\\\",\\\"PT\\\",\\\"PR\\\",\\\"QA\\\",\\\"RE\\\",\\\"RO\\\",\\\"RU\\\",\\\"RW\\\",\\\"SH\\\",\\\"KN\\\",\\\"LC\\\",\\\"PM\\\",\\\"VC\\\",\\\"WS\\\",\\\"SM\\\",\\\"ST\\\",\\\"SA\\\",\\\"SN\\\",\\\"CS\\\",\\\"SC\\\",\\\"SL\\\",\\\"SG\\\",\\\"SK\\\",\\\"SI\\\",\\\"SB\\\",\\\"SO\\\",\\\"ZA\\\",\\\"GS\\\",\\\"ES\\\",\\\"LK\\\",\\\"SD\\\",\\\"SR\\\",\\\"SJ\\\",\\\"SZ\\\",\\\"SE\\\",\\\"CH\\\",\\\"SY\\\",\\\"TW\\\",\\\"TJ\\\",\\\"TZ\\\",\\\"TH\\\",\\\"TL\\\",\\\"TG\\\",\\\"TK\\\",\\\"TO\\\",\\\"TT\\\",\\\"TN\\\",\\\"TR\\\",\\\"TM\\\",\\\"TC\\\",\\\"TV\\\",\\\"UG\\\",\\\"UA\\\",\\\"AE\\\",\\\"GB\\\",\\\"US\\\",\\\"UM\\\",\\\"UY\\\",\\\"UZ\\\",\\\"VU\\\",\\\"VE\\\",\\\"VN\\\",\\\"VG\\\",\\\"VI\\\",\\\"WF\\\",\\\"EH\\\",\\\"YE\\\",\\\"ZM\\\",\\\"ZW\\\"]\",\"origin\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 30, 0, 0.9, 'include', 'pending', 'unpaid', '2024-01-22 14:25:01', '2024-01-22 14:25:01', NULL, 'Black-28', '{\"color\":\"Black\",\"Size\":\"28\"}', 'discount_on_product', 1, 0),
(17, 100015, 178, 3, NULL, '{\"id\":178,\"added_by\":\"seller\",\"user_id\":3,\"name\":\"Sell like hot Mini Portable Drive 3.0 Flash Drive 2TB USB PEN DRIVE 1tb External\",\"slug\":\"sell-like-hot-mini-portable-drive-30-flash-drive-2tb-usb-pen-drive-1tb-external-flash-memory-for-laptop-desktop-mechanic\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"11\\\",\\\"position\\\":1},{\\\"id\\\":\\\"164\\\",\\\"position\\\":2},{\\\"id\\\":\\\"169\\\",\\\"position\\\":3}]\",\"category_id\":\"11\",\"sub_category_id\":\"164\",\"sub_sub_category_id\":\"169\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-20-655b6a226af94.webp\\\",\\\"2023-11-20-655b6a228947b.webp\\\",\\\"2023-11-20-655b6a22af5a7.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-20-655b6a226af94.webp\\\"},{\\\"color\\\":\\\"C0C0C0\\\",\\\"image_name\\\":\\\"2023-11-20-655b6a228947b.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b6a22af5a7.webp\\\"}]\",\"thumbnail\":\"2023-11-20-655b6a22c9e10.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#C0C0C0\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":17,\\\"sku\\\":\\\"SlhMPD3FD2UPD1EFMFLDM-Black\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Silver\\\",\\\"price\\\":16,\\\"sku\\\":\\\"SlhMPD3FD2UPD1EFMFLDM-Silver\\\",\\\"qty\\\":1}]\",\"published\":0,\"unit_price\":17,\"purchase_price\":20,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":2,\"minimum_order_qty\":1,\"details\":\"<p>Sell like hot Mini Portable Drive 3.0 Flash Drive 2TB USB PEN DRIVE 1tb External Flash Memory For Laptop Desktop Mechanical<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-20T14:16:02.000000Z\",\"updated_at\":\"2023-11-20T15:41:07.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"169719\",\"shipping_country\":null,\"origin\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 16, 0, 0.8, 'include', 'canceled', 'unpaid', '2024-01-22 14:29:06', '2024-01-25 12:08:11', NULL, 'Silver', '{\"color\":\"Silver\"}', 'discount_on_product', 0, 0),
(18, 100016, 160, 1, NULL, '{\"id\":160,\"added_by\":\"seller\",\"user_id\":1,\"name\":\"Original Samsung Galaxy A71 5G A716U\\/U1 Mobile CellPhone 6.7\\\" RAM 6GB ROM 128GB \",\"slug\":\"original-samsung-galaxy-a71-5g-a716uu1-mobile-cellphone-67-ram-6gb-rom-128gb-4-camera-fingerprint-android-unlocked-smart\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"11\\\",\\\"position\\\":1},{\\\"id\\\":\\\"166\\\",\\\"position\\\":2},{\\\"id\\\":\\\"176\\\",\\\"position\\\":3}]\",\"category_id\":\"11\",\"sub_category_id\":\"166\",\"sub_sub_category_id\":\"176\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-15-6554b7dde6c23.webp\\\",\\\"2023-11-15-6554b7de04eb9.webp\\\",\\\"2023-11-15-6554b7de1bf08.webp\\\",\\\"2023-11-15-6554b7de2c59e.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-15-6554b7dde6c23.webp\\\"},{\\\"color\\\":\\\"ADD8E6\\\",\\\"image_name\\\":\\\"2023-11-15-6554b7de04eb9.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-15-6554b7de1bf08.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-15-6554b7de2c59e.webp\\\"}]\",\"thumbnail\":\"2023-11-15-6554b7de3e5df.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#ADD8E6\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":175,\\\"sku\\\":\\\"OSGA5AMC6R6R14CFAUS-Black\\\",\\\"qty\\\":0},{\\\"type\\\":\\\"LightBlue\\\",\\\"price\\\":175,\\\"sku\\\":\\\"OSGA5AMC6R6R14CFAUS-LightBlue\\\",\\\"qty\\\":1}]\",\"published\":0,\"unit_price\":175,\"purchase_price\":180,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":1,\"minimum_order_qty\":1,\"details\":\"<p>Original Samsung Galaxy A71 5G A716U\\/U1 Mobile CellPhone 6.7&quot; RAM 6GB ROM 128GB 4 Camera Fingerprint Android Unlocked Smartphone<br \\/>\\r\\n&nbsp;<\\/p>\\r\\n\\r\\n<p>1.About Version: U\\/U1 is the US version that does not support OTA update, but U1 supports OTA update, we send U1 version to customers. About Global version with full languages and supports OTA update.<\\/p>\\r\\n\\r\\n<p>2. About Language: For U\\/U1 version, when you turn on the phone, maybe there only be Deutsch\\/French\\/ Spanish\\/ Portuguese \\/ Italian \\/ Japanese \\/ Korean \\/ Vietnamese \\/ Chinese languages options, but you can add your languages by yourself easily. If you don&#39;t know how to do it, please contact us to get a video of the setting.<\\/p>\\r\\n\\r\\n<p>For U\\/U1 version, some languages (such as Russian, Arabic, Hebrew, Polish, etc.) are only partial in this phone. That means even if you set the default language to Russian \\/ Arabic \\/ Hebrew \\/ Polish, there still are about 50% menus showing in English. But the other languages are completed.<br \\/>\\r\\n3.About Memory: The internal storage will be less than the specification since part of it will be occupied by built-in systems and apps. For example, ROM is 128GB, but only 110-123GB can be used, it is normal.<br \\/>\\r\\n4. About Battery: The battery efficiency of the phone will be less than the standard. Normally Battery capacity is about 80%-90%. We do not accept any tests from the third-party application.<br \\/>\\r\\n5. About Phone: TestThis is a used phone, not brand new, we will test the phone to make sure it&rsquo;s working fine and in good condition too.<\\/p>\\r\\n\\r\\n<p>6.About Waterproof: The phones do NOT support waterproofing anymore, as the phone is exchanging the new housing from the USED phone.<br \\/>\\r\\n7.About accessories: All accessories are not original, but of good quality, any dispute for &quot;Fake accessories&quot; will not be accepted, we don&#39;t offer a warranty for the accessories<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-15T12:21:50.000000Z\",\"updated_at\":\"2023-12-28T21:52:30.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"115128\",\"shipping_country\":null,\"origin\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 175, 0, 8.75, 'include', 'canceled', 'unpaid', '2024-01-22 14:29:09', '2024-01-25 12:10:31', NULL, 'LightBlue', '{\"color\":\"LightBlue\"}', 'discount_on_product', 0, 0),
(19, 100017, 149, 1, NULL, '{\"id\":149,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watche\",\"slug\":\"lige-2023-smart-watch-for-men-women-gift-full-touch-screen-sports-fitness-watches-bluetooth-calls-digital-smartwatch-wri\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"9\\\",\\\"position\\\":1},{\\\"id\\\":\\\"136\\\",\\\"position\\\":2},{\\\"id\\\":\\\"143\\\",\\\"position\\\":3}]\",\"category_id\":\"9\",\"sub_category_id\":\"136\",\"sub_sub_category_id\":\"143\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-13-655248b45e7e3.webp\\\",\\\"2023-11-13-655248b47207f.webp\\\",\\\"2023-11-13-655248b487e48.webp\\\",\\\"2023-11-13-655248b4995af.webp\\\",\\\"2023-11-13-655248b4aea0f.webp\\\",\\\"2023-11-13-655248b4c9c47.webp\\\",\\\"2023-11-13-655248b4de60d.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-13-655248b45e7e3.webp\\\"},{\\\"color\\\":\\\"696969\\\",\\\"image_name\\\":\\\"2023-11-13-655248b47207f.webp\\\"},{\\\"color\\\":\\\"DAA520\\\",\\\"image_name\\\":\\\"2023-11-13-655248b487e48.webp\\\"},{\\\"color\\\":\\\"808080\\\",\\\"image_name\\\":\\\"2023-11-13-655248b4995af.webp\\\"},{\\\"color\\\":\\\"FFB6C1\\\",\\\"image_name\\\":\\\"2023-11-13-655248b4aea0f.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655248b4c9c47.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655248b4de60d.webp\\\"}]\",\"thumbnail\":\"2023-11-13-655248b50227d.webp\",\"featured\":1,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#696969\\\",\\\"#DAA520\\\",\\\"#808080\\\",\\\"#FFB6C1\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Black\\\",\\\"qty\\\":0},{\\\"type\\\":\\\"DimGray\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-DimGray\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Goldenrod\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Goldenrod\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Gray\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Gray\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"LightPink\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-LightPink\\\",\\\"qty\\\":0}]\",\"published\":0,\"unit_price\":12,\"purchase_price\":15,\"tax\":5,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":0,\"discount_type\":\"percent\",\"current_stock\":3,\"minimum_order_qty\":1,\"details\":\"<p>LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watches Bluetooth Calls Digital Smartwatch Wristwatch<br \\/>\\r\\n&nbsp;<\\/p>\\r\\n\\r\\n<p>&bull; Full Touch Screen :The Lige 2023 smartwatch features a full touch screen that allows for easy and intuitive navigation.<\\/p>\\r\\n\\r\\n<p>&bull; Blood Pressure Monitor :With a built-in blood pressure monitor, this smartwatch can help you keep track of your health and fitness levels.<\\/p>\\r\\n\\r\\n<p>&bull; Multiple Dials :Choose from a variety of watch faces to customize your Lige 2023 smartwatch to your personal style.<\\/p>\\r\\n\\r\\n<p>&bull; Calorie Tracker :Keep track of your daily calorie burn with the Lige 2023 smartwatch&#39;s calorie tracker feature.<\\/p>\\r\\n\\r\\n<p>&bull; Full Touch Screen :The watch features a full touch screen that makes it easy to navigate and use all its functions.<\\/p>\\r\\n\\r\\n<p>&bull; Blood Pressure Monitor :The watch comes with a blood pressure monitor, allowing you to keep track of your health and fitness levels.<\\/p>\\r\\n\\r\\n<p>&bull; Multiple Dials :The watch has multiple dials, allowing you to customize the look and feel of your watch to suit your personal style.<br \\/>\\r\\n&bull; Calorie Tracker:The watch tracks your calorie intake and expenditure, helping you stay on track with your fitness goals.<br \\/>\\r\\nProduct parameters<br \\/>\\r\\nScreen:1.69-inch TFT 240*280<br \\/>\\r\\nTouch Panel:Full touch screen<br \\/>\\r\\nBattery\\uff1a180Mah<br \\/>\\r\\nApp:FitPro<br \\/>\\r\\nCharging method\\uff1aMagnetic charging<br \\/>\\r\\nWaterproof:IP67<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-13T16:03:01.000000Z\",\"updated_at\":\"2024-01-22T11:24:20.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"121615\",\"shipping_country\":\"[\\\"AF\\\",\\\"AX\\\",\\\"AL\\\",\\\"DZ\\\",\\\"AS\\\",\\\"AD\\\",\\\"AO\\\",\\\"AI\\\",\\\"AQ\\\",\\\"AG\\\",\\\"AR\\\",\\\"AM\\\",\\\"AW\\\",\\\"AU\\\",\\\"AT\\\",\\\"AZ\\\",\\\"BS\\\",\\\"BH\\\",\\\"BD\\\",\\\"BB\\\",\\\"BY\\\",\\\"BE\\\",\\\"BZ\\\",\\\"BJ\\\",\\\"BM\\\",\\\"BT\\\",\\\"BO\\\",\\\"BA\\\",\\\"BW\\\",\\\"BV\\\",\\\"BR\\\",\\\"IO\\\",\\\"BN\\\",\\\"BG\\\",\\\"BF\\\",\\\"BI\\\",\\\"KH\\\",\\\"CM\\\",\\\"CA\\\",\\\"CV\\\",\\\"KY\\\",\\\"CF\\\",\\\"TD\\\",\\\"CL\\\",\\\"CN\\\",\\\"CX\\\",\\\"CC\\\",\\\"CO\\\",\\\"KM\\\",\\\"CG\\\",\\\"CD\\\",\\\"CK\\\",\\\"CR\\\",\\\"CI\\\",\\\"HR\\\",\\\"CU\\\",\\\"CY\\\",\\\"CZ\\\",\\\"DK\\\",\\\"DJ\\\",\\\"DM\\\",\\\"DO\\\",\\\"EC\\\",\\\"EG\\\",\\\"SV\\\",\\\"GQ\\\",\\\"ER\\\",\\\"EE\\\",\\\"ET\\\",\\\"FK\\\",\\\"FO\\\",\\\"FJ\\\",\\\"FI\\\",\\\"FR\\\",\\\"GF\\\",\\\"PF\\\",\\\"TF\\\",\\\"GA\\\",\\\"GM\\\",\\\"GE\\\",\\\"DE\\\",\\\"GH\\\",\\\"GI\\\",\\\"GR\\\",\\\"GL\\\",\\\"GD\\\",\\\"GP\\\",\\\"GU\\\",\\\"GT\\\",\\\"GG\\\",\\\"GN\\\",\\\"GW\\\",\\\"GY\\\",\\\"HT\\\",\\\"HM\\\",\\\"VA\\\",\\\"HN\\\",\\\"HK\\\",\\\"HU\\\",\\\"IS\\\",\\\"IN\\\",\\\"ID\\\",\\\"IR\\\",\\\"IQ\\\",\\\"IE\\\",\\\"IM\\\",\\\"IL\\\",\\\"IT\\\",\\\"JM\\\",\\\"JP\\\",\\\"JE\\\",\\\"JO\\\",\\\"KZ\\\",\\\"KE\\\",\\\"KI\\\",\\\"KP\\\",\\\"KR\\\",\\\"KW\\\",\\\"KG\\\",\\\"LA\\\",\\\"LV\\\",\\\"LB\\\",\\\"LS\\\",\\\"LR\\\",\\\"LY\\\",\\\"LI\\\",\\\"LT\\\",\\\"LU\\\",\\\"MO\\\",\\\"MK\\\",\\\"MG\\\",\\\"MW\\\",\\\"MY\\\",\\\"MV\\\",\\\"ML\\\",\\\"MT\\\",\\\"MH\\\",\\\"MQ\\\",\\\"MR\\\",\\\"MU\\\",\\\"YT\\\",\\\"MX\\\",\\\"FM\\\",\\\"MD\\\",\\\"MC\\\",\\\"MN\\\",\\\"MS\\\",\\\"MA\\\",\\\"MZ\\\",\\\"MM\\\",\\\"NA\\\",\\\"NR\\\",\\\"NP\\\",\\\"NL\\\",\\\"AN\\\",\\\"NC\\\",\\\"NZ\\\",\\\"NI\\\",\\\"NE\\\",\\\"NG\\\",\\\"NU\\\",\\\"NF\\\",\\\"MP\\\",\\\"NO\\\",\\\"OM\\\",\\\"PK\\\",\\\"PW\\\",\\\"PS\\\",\\\"PA\\\",\\\"PG\\\",\\\"PY\\\",\\\"PE\\\",\\\"PH\\\",\\\"PN\\\",\\\"PL\\\",\\\"PT\\\",\\\"PR\\\",\\\"QA\\\",\\\"RE\\\",\\\"RO\\\",\\\"RU\\\",\\\"RW\\\",\\\"SH\\\",\\\"KN\\\",\\\"LC\\\",\\\"PM\\\",\\\"VC\\\",\\\"WS\\\",\\\"SM\\\",\\\"ST\\\",\\\"SA\\\",\\\"SN\\\",\\\"CS\\\",\\\"SC\\\",\\\"SL\\\",\\\"SG\\\",\\\"SK\\\",\\\"SI\\\",\\\"SB\\\",\\\"SO\\\",\\\"ZA\\\",\\\"GS\\\",\\\"ES\\\",\\\"LK\\\",\\\"SD\\\",\\\"SR\\\",\\\"SJ\\\",\\\"SZ\\\",\\\"SE\\\",\\\"CH\\\",\\\"SY\\\",\\\"TW\\\",\\\"TJ\\\",\\\"TZ\\\",\\\"TH\\\",\\\"TL\\\",\\\"TG\\\",\\\"TK\\\",\\\"TO\\\",\\\"TT\\\",\\\"TN\\\",\\\"TR\\\",\\\"TM\\\",\\\"TC\\\",\\\"TV\\\",\\\"UG\\\",\\\"UA\\\",\\\"AE\\\",\\\"GB\\\",\\\"US\\\",\\\"UM\\\",\\\"UY\\\",\\\"UZ\\\",\\\"VU\\\",\\\"VE\\\",\\\"VN\\\",\\\"VG\\\",\\\"VI\\\",\\\"WF\\\",\\\"EH\\\",\\\"YE\\\",\\\"ZM\\\",\\\"ZW\\\"]\",\"origin\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 11.4, 0.6, 0, 'include', 'canceled', 'unpaid', '2024-01-22 14:29:13', '2024-01-25 11:45:02', NULL, 'DimGray', '{\"color\":\"DimGray\"}', 'discount_on_product', 0, 0),
(20, 100017, 149, 1, NULL, '{\"id\":149,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watche\",\"slug\":\"lige-2023-smart-watch-for-men-women-gift-full-touch-screen-sports-fitness-watches-bluetooth-calls-digital-smartwatch-wri\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"9\\\",\\\"position\\\":1},{\\\"id\\\":\\\"136\\\",\\\"position\\\":2},{\\\"id\\\":\\\"143\\\",\\\"position\\\":3}]\",\"category_id\":\"9\",\"sub_category_id\":\"136\",\"sub_sub_category_id\":\"143\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-13-655248b45e7e3.webp\\\",\\\"2023-11-13-655248b47207f.webp\\\",\\\"2023-11-13-655248b487e48.webp\\\",\\\"2023-11-13-655248b4995af.webp\\\",\\\"2023-11-13-655248b4aea0f.webp\\\",\\\"2023-11-13-655248b4c9c47.webp\\\",\\\"2023-11-13-655248b4de60d.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-13-655248b45e7e3.webp\\\"},{\\\"color\\\":\\\"696969\\\",\\\"image_name\\\":\\\"2023-11-13-655248b47207f.webp\\\"},{\\\"color\\\":\\\"DAA520\\\",\\\"image_name\\\":\\\"2023-11-13-655248b487e48.webp\\\"},{\\\"color\\\":\\\"808080\\\",\\\"image_name\\\":\\\"2023-11-13-655248b4995af.webp\\\"},{\\\"color\\\":\\\"FFB6C1\\\",\\\"image_name\\\":\\\"2023-11-13-655248b4aea0f.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655248b4c9c47.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-13-655248b4de60d.webp\\\"}]\",\"thumbnail\":\"2023-11-13-655248b50227d.webp\",\"featured\":1,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#696969\\\",\\\"#DAA520\\\",\\\"#808080\\\",\\\"#FFB6C1\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Black\\\",\\\"qty\\\":0},{\\\"type\\\":\\\"DimGray\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-DimGray\\\",\\\"qty\\\":0},{\\\"type\\\":\\\"Goldenrod\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Goldenrod\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Gray\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-Gray\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"LightPink\\\",\\\"price\\\":12,\\\"sku\\\":\\\"L2SWFMWGFTSSFWBCDSW-LightPink\\\",\\\"qty\\\":0}]\",\"published\":0,\"unit_price\":12,\"purchase_price\":15,\"tax\":5,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":0,\"discount_type\":\"percent\",\"current_stock\":2,\"minimum_order_qty\":1,\"details\":\"<p>LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watches Bluetooth Calls Digital Smartwatch Wristwatch<br \\/>\\r\\n&nbsp;<\\/p>\\r\\n\\r\\n<p>&bull; Full Touch Screen :The Lige 2023 smartwatch features a full touch screen that allows for easy and intuitive navigation.<\\/p>\\r\\n\\r\\n<p>&bull; Blood Pressure Monitor :With a built-in blood pressure monitor, this smartwatch can help you keep track of your health and fitness levels.<\\/p>\\r\\n\\r\\n<p>&bull; Multiple Dials :Choose from a variety of watch faces to customize your Lige 2023 smartwatch to your personal style.<\\/p>\\r\\n\\r\\n<p>&bull; Calorie Tracker :Keep track of your daily calorie burn with the Lige 2023 smartwatch&#39;s calorie tracker feature.<\\/p>\\r\\n\\r\\n<p>&bull; Full Touch Screen :The watch features a full touch screen that makes it easy to navigate and use all its functions.<\\/p>\\r\\n\\r\\n<p>&bull; Blood Pressure Monitor :The watch comes with a blood pressure monitor, allowing you to keep track of your health and fitness levels.<\\/p>\\r\\n\\r\\n<p>&bull; Multiple Dials :The watch has multiple dials, allowing you to customize the look and feel of your watch to suit your personal style.<br \\/>\\r\\n&bull; Calorie Tracker:The watch tracks your calorie intake and expenditure, helping you stay on track with your fitness goals.<br \\/>\\r\\nProduct parameters<br \\/>\\r\\nScreen:1.69-inch TFT 240*280<br \\/>\\r\\nTouch Panel:Full touch screen<br \\/>\\r\\nBattery\\uff1a180Mah<br \\/>\\r\\nApp:FitPro<br \\/>\\r\\nCharging method\\uff1aMagnetic charging<br \\/>\\r\\nWaterproof:IP67<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-13T16:03:01.000000Z\",\"updated_at\":\"2024-01-22T11:29:13.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"121615\",\"shipping_country\":\"[\\\"AF\\\",\\\"AX\\\",\\\"AL\\\",\\\"DZ\\\",\\\"AS\\\",\\\"AD\\\",\\\"AO\\\",\\\"AI\\\",\\\"AQ\\\",\\\"AG\\\",\\\"AR\\\",\\\"AM\\\",\\\"AW\\\",\\\"AU\\\",\\\"AT\\\",\\\"AZ\\\",\\\"BS\\\",\\\"BH\\\",\\\"BD\\\",\\\"BB\\\",\\\"BY\\\",\\\"BE\\\",\\\"BZ\\\",\\\"BJ\\\",\\\"BM\\\",\\\"BT\\\",\\\"BO\\\",\\\"BA\\\",\\\"BW\\\",\\\"BV\\\",\\\"BR\\\",\\\"IO\\\",\\\"BN\\\",\\\"BG\\\",\\\"BF\\\",\\\"BI\\\",\\\"KH\\\",\\\"CM\\\",\\\"CA\\\",\\\"CV\\\",\\\"KY\\\",\\\"CF\\\",\\\"TD\\\",\\\"CL\\\",\\\"CN\\\",\\\"CX\\\",\\\"CC\\\",\\\"CO\\\",\\\"KM\\\",\\\"CG\\\",\\\"CD\\\",\\\"CK\\\",\\\"CR\\\",\\\"CI\\\",\\\"HR\\\",\\\"CU\\\",\\\"CY\\\",\\\"CZ\\\",\\\"DK\\\",\\\"DJ\\\",\\\"DM\\\",\\\"DO\\\",\\\"EC\\\",\\\"EG\\\",\\\"SV\\\",\\\"GQ\\\",\\\"ER\\\",\\\"EE\\\",\\\"ET\\\",\\\"FK\\\",\\\"FO\\\",\\\"FJ\\\",\\\"FI\\\",\\\"FR\\\",\\\"GF\\\",\\\"PF\\\",\\\"TF\\\",\\\"GA\\\",\\\"GM\\\",\\\"GE\\\",\\\"DE\\\",\\\"GH\\\",\\\"GI\\\",\\\"GR\\\",\\\"GL\\\",\\\"GD\\\",\\\"GP\\\",\\\"GU\\\",\\\"GT\\\",\\\"GG\\\",\\\"GN\\\",\\\"GW\\\",\\\"GY\\\",\\\"HT\\\",\\\"HM\\\",\\\"VA\\\",\\\"HN\\\",\\\"HK\\\",\\\"HU\\\",\\\"IS\\\",\\\"IN\\\",\\\"ID\\\",\\\"IR\\\",\\\"IQ\\\",\\\"IE\\\",\\\"IM\\\",\\\"IL\\\",\\\"IT\\\",\\\"JM\\\",\\\"JP\\\",\\\"JE\\\",\\\"JO\\\",\\\"KZ\\\",\\\"KE\\\",\\\"KI\\\",\\\"KP\\\",\\\"KR\\\",\\\"KW\\\",\\\"KG\\\",\\\"LA\\\",\\\"LV\\\",\\\"LB\\\",\\\"LS\\\",\\\"LR\\\",\\\"LY\\\",\\\"LI\\\",\\\"LT\\\",\\\"LU\\\",\\\"MO\\\",\\\"MK\\\",\\\"MG\\\",\\\"MW\\\",\\\"MY\\\",\\\"MV\\\",\\\"ML\\\",\\\"MT\\\",\\\"MH\\\",\\\"MQ\\\",\\\"MR\\\",\\\"MU\\\",\\\"YT\\\",\\\"MX\\\",\\\"FM\\\",\\\"MD\\\",\\\"MC\\\",\\\"MN\\\",\\\"MS\\\",\\\"MA\\\",\\\"MZ\\\",\\\"MM\\\",\\\"NA\\\",\\\"NR\\\",\\\"NP\\\",\\\"NL\\\",\\\"AN\\\",\\\"NC\\\",\\\"NZ\\\",\\\"NI\\\",\\\"NE\\\",\\\"NG\\\",\\\"NU\\\",\\\"NF\\\",\\\"MP\\\",\\\"NO\\\",\\\"OM\\\",\\\"PK\\\",\\\"PW\\\",\\\"PS\\\",\\\"PA\\\",\\\"PG\\\",\\\"PY\\\",\\\"PE\\\",\\\"PH\\\",\\\"PN\\\",\\\"PL\\\",\\\"PT\\\",\\\"PR\\\",\\\"QA\\\",\\\"RE\\\",\\\"RO\\\",\\\"RU\\\",\\\"RW\\\",\\\"SH\\\",\\\"KN\\\",\\\"LC\\\",\\\"PM\\\",\\\"VC\\\",\\\"WS\\\",\\\"SM\\\",\\\"ST\\\",\\\"SA\\\",\\\"SN\\\",\\\"CS\\\",\\\"SC\\\",\\\"SL\\\",\\\"SG\\\",\\\"SK\\\",\\\"SI\\\",\\\"SB\\\",\\\"SO\\\",\\\"ZA\\\",\\\"GS\\\",\\\"ES\\\",\\\"LK\\\",\\\"SD\\\",\\\"SR\\\",\\\"SJ\\\",\\\"SZ\\\",\\\"SE\\\",\\\"CH\\\",\\\"SY\\\",\\\"TW\\\",\\\"TJ\\\",\\\"TZ\\\",\\\"TH\\\",\\\"TL\\\",\\\"TG\\\",\\\"TK\\\",\\\"TO\\\",\\\"TT\\\",\\\"TN\\\",\\\"TR\\\",\\\"TM\\\",\\\"TC\\\",\\\"TV\\\",\\\"UG\\\",\\\"UA\\\",\\\"AE\\\",\\\"GB\\\",\\\"US\\\",\\\"UM\\\",\\\"UY\\\",\\\"UZ\\\",\\\"VU\\\",\\\"VE\\\",\\\"VN\\\",\\\"VG\\\",\\\"VI\\\",\\\"WF\\\",\\\"EH\\\",\\\"YE\\\",\\\"ZM\\\",\\\"ZW\\\"]\",\"origin\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 11.4, 0.6, 0, 'include', 'canceled', 'unpaid', '2024-01-22 14:29:13', '2024-01-25 11:45:02', NULL, 'Goldenrod', '{\"color\":\"Goldenrod\"}', 'discount_on_product', 0, 0);
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `seller_id`, `digital_file_after_sell`, `product_details`, `qty`, `price`, `tax`, `discount`, `tax_model`, `delivery_status`, `payment_status`, `created_at`, `updated_at`, `shipping_method_id`, `variant`, `variation`, `discount_type`, `is_stock_decreased`, `refund_request`) VALUES
(21, 100018, 111, 1, NULL, '{\"id\":111,\"added_by\":\"admin\",\"user_id\":1,\"name\":\"Sierlijke off-the-shoulder bruidsjurk met lange mouwen en sprankelende kristallen kralen trouwjurk Luxe lange bruidsjurk Robe De Mari\\u00e9e\",\"slug\":\"graceful-off-the-shoulder-long-sleeve-bride-robe-sparkly-crystal-beads-wedding-dress-luxury-long-bridal-gown-robe-de-mar\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"2\\\",\\\"position\\\":1},{\\\"id\\\":\\\"16\\\",\\\"position\\\":2}]\",\"category_id\":\"2\",\"sub_category_id\":\"16\",\"sub_sub_category_id\":null,\"brand_id\":1,\"unit\":\"kg\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-04-65464a763f294.png\\\",\\\"2023-11-04-65464a76404c3.png\\\",\\\"2023-11-04-65464a764082f.png\\\",\\\"2023-11-04-65464a764c128.png\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"0000FF\\\",\\\"image_name\\\":\\\"2023-11-04-65464a763f294.png\\\"},{\\\"color\\\":\\\"FF1493\\\",\\\"image_name\\\":\\\"2023-11-04-65464a76404c3.png\\\"},{\\\"color\\\":\\\"FFFFFF\\\",\\\"image_name\\\":\\\"2023-11-04-65464a764082f.png\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-04-65464a764c128.png\\\"}]\",\"thumbnail\":\"2023-11-04-65464a764c5df.png\",\"featured\":1,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#0000FF\\\",\\\"#FF1493\\\",\\\"#FFFFFF\\\"]\",\"variant_product\":0,\"attributes\":\"[\\\"1\\\"]\",\"choice_options\":\"[{\\\"name\\\":\\\"choice_1\\\",\\\"title\\\":\\\"Size\\\",\\\"options\\\":[\\\"M\\\",\\\"L\\\",\\\"S\\\"]}]\",\"variation\":\"[{\\\"type\\\":\\\"Blue-M\\\",\\\"price\\\":350,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-M\\\",\\\"qty\\\":49},{\\\"type\\\":\\\"Blue-L\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"Blue-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-Blue-S\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"DeepPink-M\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-M\\\",\\\"qty\\\":49},{\\\"type\\\":\\\"DeepPink-L\\\",\\\"price\\\":150,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"DeepPink-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-DeepPink-S\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-M\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-M\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-L\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-L\\\",\\\"qty\\\":50},{\\\"type\\\":\\\"White-S\\\",\\\"price\\\":250,\\\"sku\\\":\\\"GOTSLSBRSCBWDLLBGRDM-White-S\\\",\\\"qty\\\":50}]\",\"published\":0,\"unit_price\":250,\"purchase_price\":270,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":7,\"discount_type\":\"percent\",\"current_stock\":448,\"minimum_order_qty\":1,\"details\":\"<p>Welkom bij DMDRS Bruiloftsfeestwinkel<\\/p>\\r\\n\\r\\n<p>Warme tips:<br \\/>\\r\\n1: De jurk wordt op bestelling gemaakt. We raden klanten aan om minimaal 2 maanden eerder te bestellen, zodat er meer tijd overblijft voor productie en verzending.<br \\/>\\r\\n2.De levertijd is afhankelijk van de door u gekozen verzendmethoden.<br \\/>\\r\\n3. Stuur mij van tevoren een bericht met uw deadline of vermeld eventuele tijdgevoelige verzoeken in het notitievak van de bestelling bij het afrekenen.<br \\/>\\r\\n4.!!!Na het plaatsen van uw bestelling heeft u nog EEN DAG om van gedachten te veranderen of bevestig dit ruim voordat u de bestelling plaatst. Zodra het maatwerkproces is begonnen, kunnen de materialen niet meer worden hergebruikt. Het halverwege annuleren van bestellingen levert ons veel verliezen op, aangezien al onze jurken niet op voorraad zijn, maar gloednieuw en op maat gemaakt voor elke bestelling.<br \\/>\\r\\n5.!!! Wij bieden spoedorderservice voor alle producten. Als er sprake is van een spoedbestelling, raden wij u ten zeerste aan contact met ons op te nemen voordat u de bestelling plaatst, om foutschattingen te voorkomen.<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-04T10:43:18.000000Z\",\"updated_at\":\"2023-11-14T09:06:18.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.png\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"133736\",\"shipping_country\":null,\"origin\":null,\"reviews_count\":0,\"translations\":[{\"translationable_type\":\"App\\\\Model\\\\Product\",\"translationable_id\":111,\"locale\":\"nl\",\"key\":\"name\",\"value\":\"Sierlijke off-the-shoulder bruidsjurk met lange mouwen en sprankelende kristallen kralen trouwjurk Luxe lange bruidsjurk Robe De Mari\\u00e9e\",\"id\":77},{\"translationable_type\":\"App\\\\Model\\\\Product\",\"translationable_id\":111,\"locale\":\"nl\",\"key\":\"description\",\"value\":\"<p>Welkom bij DMDRS Bruiloftsfeestwinkel<\\/p>\\r\\n\\r\\n<p>Warme tips:<br \\/>\\r\\n1: De jurk wordt op bestelling gemaakt. We raden klanten aan om minimaal 2 maanden eerder te bestellen, zodat er meer tijd overblijft voor productie en verzending.<br \\/>\\r\\n2.De levertijd is afhankelijk van de door u gekozen verzendmethoden.<br \\/>\\r\\n3. Stuur mij van tevoren een bericht met uw deadline of vermeld eventuele tijdgevoelige verzoeken in het notitievak van de bestelling bij het afrekenen.<br \\/>\\r\\n4.!!!Na het plaatsen van uw bestelling heeft u nog EEN DAG om van gedachten te veranderen of bevestig dit ruim voordat u de bestelling plaatst. Zodra het maatwerkproces is begonnen, kunnen de materialen niet meer worden hergebruikt. Het halverwege annuleren van bestellingen levert ons veel verliezen op, aangezien al onze jurken niet op voorraad zijn, maar gloednieuw en op maat gemaakt voor elke bestelling.<br \\/>\\r\\n5.!!! Wij bieden spoedorderservice voor alle producten. Als er sprake is van een spoedbestelling, raden wij u ten zeerste aan contact met ons op te nemen voordat u de bestelling plaatst, om foutschattingen te voorkomen.<\\/p>\",\"id\":78}],\"reviews\":[]}', 1, 250, 0, 17.5, 'include', 'pending', 'unpaid', '2024-01-25 02:03:24', '2024-01-25 02:03:24', NULL, 'DeepPink-M', '{\"color\":\"DeepPink\",\"Size\":\"M\"}', 'discount_on_product', 1, 0),
(22, 100019, 178, 3, NULL, '{\"id\":178,\"added_by\":\"seller\",\"user_id\":3,\"name\":\"Sell like hot Mini Portable Drive 3.0 Flash Drive 2TB USB PEN DRIVE 1tb External\",\"slug\":\"sell-like-hot-mini-portable-drive-30-flash-drive-2tb-usb-pen-drive-1tb-external-flash-memory-for-laptop-desktop-mechanic\",\"product_type\":\"physical\",\"category_ids\":\"[{\\\"id\\\":\\\"11\\\",\\\"position\\\":1},{\\\"id\\\":\\\"164\\\",\\\"position\\\":2},{\\\"id\\\":\\\"169\\\",\\\"position\\\":3}]\",\"category_id\":\"11\",\"sub_category_id\":\"164\",\"sub_sub_category_id\":\"169\",\"brand_id\":1,\"unit\":\"pc\",\"min_qty\":1,\"refundable\":1,\"digital_product_type\":null,\"digital_file_ready\":null,\"images\":\"[\\\"2023-11-20-655b6a226af94.webp\\\",\\\"2023-11-20-655b6a228947b.webp\\\",\\\"2023-11-20-655b6a22af5a7.webp\\\"]\",\"color_image\":\"[{\\\"color\\\":\\\"000000\\\",\\\"image_name\\\":\\\"2023-11-20-655b6a226af94.webp\\\"},{\\\"color\\\":\\\"C0C0C0\\\",\\\"image_name\\\":\\\"2023-11-20-655b6a228947b.webp\\\"},{\\\"color\\\":null,\\\"image_name\\\":\\\"2023-11-20-655b6a22af5a7.webp\\\"}]\",\"thumbnail\":\"2023-11-20-655b6a22c9e10.webp\",\"featured\":null,\"flash_deal\":null,\"video_provider\":\"youtube\",\"video_url\":null,\"colors\":\"[\\\"#000000\\\",\\\"#C0C0C0\\\"]\",\"variant_product\":0,\"attributes\":\"null\",\"choice_options\":\"[]\",\"variation\":\"[{\\\"type\\\":\\\"Black\\\",\\\"price\\\":17,\\\"sku\\\":\\\"SlhMPD3FD2UPD1EFMFLDM-Black\\\",\\\"qty\\\":1},{\\\"type\\\":\\\"Silver\\\",\\\"price\\\":16,\\\"sku\\\":\\\"SlhMPD3FD2UPD1EFMFLDM-Silver\\\",\\\"qty\\\":1}]\",\"published\":0,\"unit_price\":17,\"purchase_price\":20,\"tax\":0,\"tax_type\":\"percent\",\"tax_model\":\"include\",\"discount\":5,\"discount_type\":\"percent\",\"current_stock\":2,\"minimum_order_qty\":1,\"details\":\"<p>Sell like hot Mini Portable Drive 3.0 Flash Drive 2TB USB PEN DRIVE 1tb External Flash Memory For Laptop Desktop Mechanical<\\/p>\",\"free_shipping\":0,\"attachment\":null,\"created_at\":\"2023-11-20T14:16:02.000000Z\",\"updated_at\":\"2024-01-25T09:08:11.000000Z\",\"status\":1,\"featured_status\":1,\"meta_title\":null,\"meta_description\":null,\"meta_image\":\"def.webp\",\"request_status\":1,\"denied_note\":null,\"shipping_cost\":0,\"multiply_qty\":0,\"temp_shipping_cost\":null,\"is_shipping_cost_updated\":null,\"code\":\"169719\",\"shipping_country\":null,\"origin\":null,\"reviews_count\":0,\"translations\":[],\"reviews\":[]}', 1, 16, 0, 0.8, 'include', 'delivered', 'unpaid', '2024-01-25 12:12:50', '2024-01-25 12:17:26', NULL, 'Silver', '{\"color\":\"Silver\"}', 'discount_on_product', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_expected_delivery_histories`
--

CREATE TABLE `order_expected_delivery_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_type` varchar(191) NOT NULL,
  `expected_delivery_date` date NOT NULL,
  `cause` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_status_histories`
--

CREATE TABLE `order_status_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_type` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `cause` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_status_histories`
--

INSERT INTO `order_status_histories` (`id`, `order_id`, `user_id`, `user_type`, `status`, `cause`, `created_at`, `updated_at`) VALUES
(1, 100001, 46, 'customer', 'pending', NULL, '2023-11-07 02:29:27', '2023-11-07 02:29:27'),
(2, 100001, 0, 'admin', 'confirmed', NULL, '2023-11-07 02:30:13', '2023-11-07 02:30:13'),
(3, 100001, 0, 'admin', 'processing', NULL, '2023-11-07 02:30:43', '2023-11-07 02:30:43'),
(4, 100002, 115, 'customer', 'pending', NULL, '2023-11-15 23:58:04', '2023-11-15 23:58:04'),
(5, 100003, 143, 'customer', 'pending', NULL, '2023-11-22 00:20:57', '2023-11-22 00:20:57'),
(6, 100003, 0, 'admin', 'confirmed', NULL, '2023-11-22 00:22:31', '2023-11-22 00:22:31'),
(7, 100003, 0, 'admin', 'delivered', NULL, '2023-11-22 00:22:42', '2023-11-22 00:22:42'),
(8, 100002, 0, 'admin', 'delivered', NULL, '2023-11-22 00:23:20', '2023-11-22 00:23:20'),
(9, 100001, 0, 'admin', 'delivered', NULL, '2023-11-22 00:23:36', '2023-11-22 00:23:36'),
(10, 100004, 2, 'customer', 'pending', NULL, '2023-11-26 00:03:42', '2023-11-26 00:03:42'),
(11, 100004, 0, 'admin', 'confirmed', NULL, '2023-11-26 00:04:27', '2023-11-26 00:04:27'),
(12, 100004, 0, 'admin', 'processing', NULL, '2023-11-26 00:06:36', '2023-11-26 00:06:36'),
(13, 100004, 0, 'admin', 'delivered', NULL, '2023-11-26 00:07:48', '2023-11-26 00:07:48'),
(14, 100005, 2, 'customer', 'pending', NULL, '2023-11-26 00:09:42', '2023-11-26 00:09:42'),
(15, 100005, 0, 'admin', 'delivered', NULL, '2023-11-26 00:10:02', '2023-11-26 00:10:02'),
(16, 100006, 2, 'customer', 'pending', NULL, '2023-11-26 00:11:18', '2023-11-26 00:11:18'),
(17, 100006, 0, 'admin', 'delivered', NULL, '2023-11-26 00:11:41', '2023-11-26 00:11:41'),
(18, 100007, 2, 'customer', 'pending', NULL, '2023-11-26 00:13:13', '2023-11-26 00:13:13'),
(19, 100008, 2, 'customer', 'pending', NULL, '2023-11-26 00:13:17', '2023-11-26 00:13:17'),
(20, 100007, 0, 'admin', 'processing', NULL, '2023-11-26 00:13:53', '2023-11-26 00:13:53'),
(21, 100007, 0, 'admin', 'delivered', NULL, '2023-11-26 00:14:02', '2023-11-26 00:14:02'),
(22, 100008, 0, 'admin', 'delivered', NULL, '2023-11-26 00:14:18', '2023-11-26 00:14:18'),
(23, 100005, 0, 'admin', 'pending', NULL, '2023-11-26 00:45:29', '2023-11-26 00:45:29'),
(24, 100005, 1, 'seller', 'confirmed', NULL, '2023-11-26 00:45:37', '2023-11-26 00:45:37'),
(25, 100005, 1, 'seller', 'processing', NULL, '2023-11-26 00:45:45', '2023-11-26 00:45:45'),
(26, 100005, 1, 'seller', 'confirmed', NULL, '2023-11-26 00:46:11', '2023-11-26 00:46:11'),
(27, 100005, 0, 'admin', 'delivered', NULL, '2023-11-26 00:46:27', '2023-11-26 00:46:27'),
(28, 100011, 490, 'customer', 'pending', NULL, '2023-12-29 00:52:30', '2023-12-29 00:52:30'),
(29, 100012, 5, 'customer', 'pending', NULL, '2024-01-18 23:56:39', '2024-01-18 23:56:39'),
(30, 100013, 714, 'customer', 'pending', NULL, '2024-01-22 14:24:20', '2024-01-22 14:24:20'),
(31, 100014, 714, 'customer', 'pending', NULL, '2024-01-22 14:25:01', '2024-01-22 14:25:01'),
(32, 100015, 5, 'customer', 'pending', NULL, '2024-01-22 14:29:06', '2024-01-22 14:29:06'),
(33, 100016, 5, 'customer', 'pending', NULL, '2024-01-22 14:29:09', '2024-01-22 14:29:09'),
(34, 100017, 5, 'customer', 'pending', NULL, '2024-01-22 14:29:13', '2024-01-22 14:29:13'),
(35, 100018, 712, 'customer', 'pending', NULL, '2024-01-25 02:03:23', '2024-01-25 02:03:23'),
(36, 100019, 5, 'customer', 'pending', NULL, '2024-01-25 12:12:50', '2024-01-25 12:12:50'),
(37, 100019, 0, 'admin', 'delivered', NULL, '2024-01-25 12:13:42', '2024-01-25 12:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `order_transactions`
--

CREATE TABLE `order_transactions` (
  `seller_id` bigint(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `order_amount` decimal(50,2) NOT NULL DEFAULT 0.00,
  `seller_amount` decimal(50,2) NOT NULL DEFAULT 0.00,
  `admin_commission` decimal(50,2) NOT NULL DEFAULT 0.00,
  `received_by` varchar(191) NOT NULL,
  `status` varchar(191) DEFAULT NULL,
  `delivery_charge` decimal(50,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(50,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `seller_is` varchar(191) DEFAULT NULL,
  `delivered_by` varchar(191) NOT NULL DEFAULT 'admin',
  `payment_method` varchar(191) DEFAULT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_transactions`
--

INSERT INTO `order_transactions` (`seller_id`, `order_id`, `order_amount`, `seller_amount`, `admin_commission`, `received_by`, `status`, `delivery_charge`, `tax`, `created_at`, `updated_at`, `customer_id`, `seller_is`, `delivered_by`, `payment_method`, `transaction_id`, `id`) VALUES
(3, 100003, '100.70', '80.70', '20.00', 'admin', 'disburse', '0.00', '0.00', '2023-11-22 00:22:42', '2023-11-22 00:22:42', 143, 'seller', 'admin', 'cash_on_delivery', '5923-gGQgf-1700601762', 1),
(1, 100002, '28.50', '28.50', '0.00', 'admin', 'disburse', '5.00', '0.00', '2023-11-22 00:23:20', '2023-11-22 00:23:20', 115, 'admin', 'admin', 'cash_on_delivery', '1936-OvS5r-1700601800', 2),
(1, 100001, '558.00', '558.00', '0.00', 'admin', 'disburse', '5.00', '0.00', '2023-11-22 00:23:36', '2023-11-22 00:23:36', 46, 'admin', 'admin', 'cash_on_delivery', '2747-P2k4k-1700601816', 3),
(1, 100004, '11.40', '11.40', '0.00', 'admin', 'disburse', '0.00', '0.60', '2023-11-26 00:07:48', '2023-11-26 00:07:48', 2, 'admin', 'admin', 'cash_on_delivery', '2792-yrs3e-1700946468', 4),
(1, 100005, '1.96', '1.96', '0.00', 'admin', 'disburse', '5.00', '0.00', '2023-11-26 00:10:02', '2023-11-26 00:10:02', 2, 'seller', 'admin', 'cash_on_delivery', '9073-UiPw0-1700946602', 5),
(3, 100006, '200.45', '160.45', '40.00', 'admin', 'disburse', '5.00', '0.00', '2023-11-26 00:11:41', '2023-11-26 00:11:41', 2, 'seller', 'admin', 'cash_on_delivery', '9231-w9urh-1700946701', 6),
(3, 100007, '57.00', '46.00', '11.00', 'admin', 'disburse', '0.00', '0.00', '2023-11-26 00:14:02', '2023-11-26 00:14:02', 2, 'seller', 'admin', 'cash_on_delivery', '2164-YEq1n-1700946842', 7),
(1, 100008, '20.37', '20.37', '0.00', 'admin', 'disburse', '0.00', '0.00', '2023-11-26 00:14:18', '2023-11-26 00:14:18', 2, 'admin', 'admin', 'cash_on_delivery', '8001-Mowct-1700946858', 8),
(3, 100019, '15.20', '12.20', '3.00', 'admin', 'disburse', '0.00', '0.00', '2024-01-25 12:13:42', '2024-01-25 12:13:42', 5, 'seller', 'admin', 'cash_on_delivery', '5893-bROV2-1706174022', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `identity` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `otp_hit_count` tinyint(4) NOT NULL DEFAULT 0,
  `is_temp_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `temp_block_time` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_type` varchar(191) NOT NULL DEFAULT 'customer',
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_requests`
--

CREATE TABLE `payment_requests` (
  `id` char(36) NOT NULL,
  `payer_id` varchar(64) DEFAULT NULL,
  `receiver_id` varchar(64) DEFAULT NULL,
  `payment_amount` decimal(24,2) NOT NULL DEFAULT 0.00,
  `gateway_callback_url` varchar(191) DEFAULT NULL,
  `success_hook` varchar(100) DEFAULT NULL,
  `failure_hook` varchar(100) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `currency_code` varchar(20) NOT NULL DEFAULT 'USD',
  `payment_method` varchar(50) DEFAULT NULL,
  `additional_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payer_information` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `external_redirect_link` varchar(255) DEFAULT NULL,
  `receiver_information` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `attribute_id` varchar(64) DEFAULT NULL,
  `attribute` varchar(255) DEFAULT NULL,
  `payment_platform` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paytabs_invoices`
--

CREATE TABLE `paytabs_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `result` text NOT NULL,
  `response_code` int(10) UNSIGNED NOT NULL,
  `pt_invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `currency` varchar(191) DEFAULT NULL,
  `transaction_id` int(10) UNSIGNED DEFAULT NULL,
  `card_brand` varchar(191) DEFAULT NULL,
  `card_first_six_digits` int(10) UNSIGNED DEFAULT NULL,
  `card_last_four_digits` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phone_or_email_verifications`
--

CREATE TABLE `phone_or_email_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone_or_email` varchar(191) DEFAULT NULL,
  `token` varchar(191) DEFAULT NULL,
  `otp_hit_count` tinyint(4) NOT NULL DEFAULT 0,
  `is_temp_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `temp_block_time` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phone_or_email_verifications`
--

INSERT INTO `phone_or_email_verifications` (`id`, `phone_or_email`, `token`, `otp_hit_count`, `is_temp_blocked`, `temp_block_time`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'tvsoso1994@gmail.com', '7299', 0, 0, NULL, NULL, '2023-12-29 00:11:39', '2023-12-29 00:11:39'),
(2, 'aadll4app@gmail.com', '4414', 0, 0, NULL, NULL, '2023-12-29 00:55:00', '2023-12-29 00:55:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `added_by` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `slug` varchar(120) DEFAULT NULL,
  `product_type` varchar(20) NOT NULL DEFAULT 'physical',
  `category_ids` varchar(80) DEFAULT NULL,
  `category_id` varchar(191) DEFAULT NULL,
  `sub_category_id` varchar(191) DEFAULT NULL,
  `sub_sub_category_id` varchar(191) DEFAULT NULL,
  `brand_id` bigint(20) DEFAULT NULL,
  `unit` varchar(191) DEFAULT NULL,
  `min_qty` int(11) NOT NULL DEFAULT 1,
  `refundable` tinyint(1) NOT NULL DEFAULT 1,
  `digital_product_type` varchar(30) DEFAULT NULL,
  `digital_file_ready` varchar(191) DEFAULT NULL,
  `images` longtext DEFAULT NULL,
  `color_image` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `featured` varchar(255) DEFAULT NULL,
  `flash_deal` varchar(255) DEFAULT NULL,
  `video_provider` varchar(30) DEFAULT NULL,
  `video_url` varchar(150) DEFAULT NULL,
  `colors` varchar(150) DEFAULT NULL,
  `variant_product` tinyint(1) NOT NULL DEFAULT 0,
  `attributes` varchar(255) DEFAULT NULL,
  `choice_options` text DEFAULT NULL,
  `variation` text DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `purchase_price` double NOT NULL DEFAULT 0,
  `tax` varchar(191) NOT NULL DEFAULT '0.00',
  `tax_type` varchar(80) DEFAULT NULL,
  `tax_model` varchar(20) NOT NULL DEFAULT 'exclude',
  `discount` varchar(191) NOT NULL DEFAULT '0.00',
  `discount_type` varchar(80) DEFAULT NULL,
  `current_stock` int(11) DEFAULT NULL,
  `minimum_order_qty` int(11) NOT NULL DEFAULT 1,
  `details` text DEFAULT NULL,
  `free_shipping` tinyint(1) NOT NULL DEFAULT 0,
  `attachment` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `featured_status` tinyint(1) NOT NULL DEFAULT 1,
  `meta_title` varchar(191) DEFAULT NULL,
  `meta_description` varchar(191) DEFAULT NULL,
  `meta_image` varchar(191) DEFAULT NULL,
  `request_status` tinyint(1) NOT NULL DEFAULT 0,
  `denied_note` varchar(191) DEFAULT NULL,
  `shipping_cost` double(8,2) DEFAULT NULL,
  `multiply_qty` tinyint(1) DEFAULT NULL,
  `temp_shipping_cost` double(8,2) DEFAULT NULL,
  `is_shipping_cost_updated` tinyint(1) DEFAULT NULL,
  `code` varchar(191) DEFAULT NULL,
  `shipping_country` longtext DEFAULT NULL,
  `origin` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `added_by`, `user_id`, `name`, `slug`, `product_type`, `category_ids`, `category_id`, `sub_category_id`, `sub_sub_category_id`, `brand_id`, `unit`, `min_qty`, `refundable`, `digital_product_type`, `digital_file_ready`, `images`, `color_image`, `thumbnail`, `featured`, `flash_deal`, `video_provider`, `video_url`, `colors`, `variant_product`, `attributes`, `choice_options`, `variation`, `published`, `unit_price`, `purchase_price`, `tax`, `tax_type`, `tax_model`, `discount`, `discount_type`, `current_stock`, `minimum_order_qty`, `details`, `free_shipping`, `attachment`, `created_at`, `updated_at`, `status`, `featured_status`, `meta_title`, `meta_description`, `meta_image`, `request_status`, `denied_note`, `shipping_cost`, `multiply_qty`, `temp_shipping_cost`, `is_shipping_cost_updated`, `code`, `shipping_country`, `origin`) VALUES
(111, 'admin', 1, 'Graceful Off The Shoulder Long Sleeve Bride Robe Sparkly Crystal Beads Wedding D', 'graceful-off-the-shoulder-long-sleeve-bride-robe-sparkly-crystal-beads-wedding-dress-luxury-long-bridal-gown-robe-de-mar', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"16\",\"position\":2}]', '2', '16', NULL, 1, 'kg', 1, 1, NULL, NULL, '[\"2023-11-04-65464a763f294.png\",\"2023-11-04-65464a76404c3.png\",\"2023-11-04-65464a764082f.png\",\"2023-11-04-65464a764c128.png\"]', '[{\"color\":\"0000FF\",\"image_name\":\"2023-11-04-65464a763f294.png\"},{\"color\":\"FF1493\",\"image_name\":\"2023-11-04-65464a76404c3.png\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-04-65464a764082f.png\"},{\"color\":null,\"image_name\":\"2023-11-04-65464a764c128.png\"}]', '2023-11-04-65464a764c5df.png', '1', NULL, 'youtube', NULL, '[\"#0000FF\",\"#FF1493\",\"#FFFFFF\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"M\",\"L\",\"S\"]}]', '[{\"type\":\"Blue-M\",\"price\":350,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-Blue-M\",\"qty\":49},{\"type\":\"Blue-L\",\"price\":250,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-Blue-L\",\"qty\":50},{\"type\":\"Blue-S\",\"price\":250,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-Blue-S\",\"qty\":50},{\"type\":\"DeepPink-M\",\"price\":250,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-DeepPink-M\",\"qty\":48},{\"type\":\"DeepPink-L\",\"price\":150,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-DeepPink-L\",\"qty\":50},{\"type\":\"DeepPink-S\",\"price\":250,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-DeepPink-S\",\"qty\":50},{\"type\":\"White-M\",\"price\":250,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-White-M\",\"qty\":50},{\"type\":\"White-L\",\"price\":250,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-White-L\",\"qty\":50},{\"type\":\"White-S\",\"price\":250,\"sku\":\"GOTSLSBRSCBWDLLBGRDM-White-S\",\"qty\":50}]', 0, 250, 270, '0', 'percent', 'include', '7', 'percent', 447, 1, '<p>Welcome to DMDRS Wedding Party Store</p>\r\n\r\n<p>Warm Tips:<br />\r\n1: The dress is made to order. We suggest customers order at least 2 months earlier to leave more time for production and the shipping.<br />\r\n2.Shipping time depends on the shipping ways you chosen.<br />\r\n3.Please message me your deadline in advance or detail any time-sensitive requests in the order&#39;s note box at checkout.<br />\r\n4.!!!After placing your order, there is still ONE DAY to change your mind or Please confirm well before placing the order. Once the tailoring process has begun, the materials cannot be reused. Canceling orders halfway will cause us a lot of losses, since all our dresses are not in stock, but brand new and custom made for each order.<br />\r\n5.!!!We provide rush order service for all products. If there is a rush order, we strongly suggest you contact us before place order to avoid error estimates.</p>', 0, NULL, '2023-11-04 13:43:18', '2024-01-25 02:03:24', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '133736', NULL, NULL),
(112, 'admin', 1, 'XUIBOL Elegant Short Sleeve Gown V Neck Blue Sequin Evening Dress Tulle Wedding ', 'xuibol-elegant-short-sleeve-gown-v-neck-blue-sequin-evening-dress-tulle-wedding-party-prom-cocktail-dresses-for-women-ve', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"16\",\"position\":2},{\"id\":\"24\",\"position\":3}]', '2', '16', '24', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-06-6549556507c20.png\",\"2023-11-06-654955650e588.png\",\"2023-11-06-654955650e804.png\",\"2023-11-06-654955650e9e9.png\"]', '[{\"color\":\"483D8B\",\"image_name\":\"2023-11-06-6549556507c20.png\"},{\"color\":null,\"image_name\":\"2023-11-06-654955650e588.png\"},{\"color\":null,\"image_name\":\"2023-11-06-654955650e804.png\"},{\"color\":null,\"image_name\":\"2023-11-06-654955650e9e9.png\"}]', '2023-11-06-654955650ec1d.png', NULL, NULL, 'youtube', NULL, '[\"#483D8B\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\"]}]', '[{\"type\":\"DarkSlateBlue-S\",\"price\":40,\"sku\":\"XESSGVNBSEDTWPPCDFWV-DarkSlateBlue-S\",\"qty\":100},{\"type\":\"DarkSlateBlue-M\",\"price\":42,\"sku\":\"XESSGVNBSEDTWPPCDFWV-DarkSlateBlue-M\",\"qty\":100},{\"type\":\"DarkSlateBlue-L\",\"price\":41,\"sku\":\"XESSGVNBSEDTWPPCDFWV-DarkSlateBlue-L\",\"qty\":100}]', 0, 40, 45, '0', 'percent', 'include', '7', 'percent', 300, 1, '<p>XUIBOL Elegant Short Sleeve Gown V Neck Blue Sequin Evening Dress Tulle Wedding Party Prom Cocktail Dresses For Women Vestido</p>', 0, NULL, '2023-11-06 21:06:45', '2023-11-06 21:06:45', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '150420', NULL, NULL),
(113, 'admin', 1, 'Luxury Silver Color Crystal Water Drop Bridal Jewelry Sets Rhinestone Tiaras Cro', 'luxury-silver-color-crystal-water-drop-bridal-jewelry-sets-rhinestone-tiaras-crown-necklace-earrings-wedding-dubai-jewel', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"16\",\"position\":2},{\"id\":\"26\",\"position\":3}]', '2', '16', '26', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-07-654a2efc7ac94.png\",\"2023-11-07-654a2efc7bc01.png\",\"2023-11-07-654a2efc7bdca.png\",\"2023-11-07-654a2efc7bf76.png\",\"2023-11-07-654a2efc7f20d.png\",\"2023-11-07-654a2efc7f4fc.png\",\"2023-11-07-654a2efc7f717.png\"]', '[{\"color\":\"0000FF\",\"image_name\":\"2023-11-07-654a2efc7ac94.png\"},{\"color\":\"DAA520\",\"image_name\":\"2023-11-07-654a2efc7bc01.png\"},{\"color\":\"008000\",\"image_name\":\"2023-11-07-654a2efc7bdca.png\"},{\"color\":\"C0C0C0\",\"image_name\":\"2023-11-07-654a2efc7bf76.png\"},{\"color\":null,\"image_name\":\"2023-11-07-654a2efc7f20d.png\"},{\"color\":null,\"image_name\":\"2023-11-07-654a2efc7f4fc.png\"},{\"color\":null,\"image_name\":\"2023-11-07-654a2efc7f717.png\"}]', '2023-11-07-654a2efc7f960.png', NULL, NULL, 'youtube', NULL, '[\"#0000FF\",\"#DAA520\",\"#008000\",\"#C0C0C0\"]', 0, 'null', '[]', '[{\"type\":\"Blue\",\"price\":6,\"sku\":\"LSCCWDBJSRTCNEWDJS-Blue\",\"qty\":100},{\"type\":\"Goldenrod\",\"price\":7,\"sku\":\"LSCCWDBJSRTCNEWDJS-Goldenrod\",\"qty\":100},{\"type\":\"Green\",\"price\":6,\"sku\":\"LSCCWDBJSRTCNEWDJS-Green\",\"qty\":100},{\"type\":\"Silver\",\"price\":8,\"sku\":\"LSCCWDBJSRTCNEWDJS-Silver\",\"qty\":100}]', 0, 7, 8, '0', 'percent', 'include', '2', 'percent', 400, 51, '<p>Luxury Silver Color Crystal Water Drop Bridal Jewelry Sets Rhinestone Tiaras Crown Necklace Earrings Wedding Dubai Jewelry Set.<br />\r\nmetal</p>\r\n\r\n<p>&nbsp;</p>', 0, NULL, '2023-11-07 15:35:08', '2024-01-12 04:28:19', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '105765', '[\"DE\",\"SD\",\"SY\"]', 'Turkey'),
(114, 'admin', 1, 'Bespoke V-neck A-line Wedding Dress with Spaghetti Straps Chapel Train Abito Da ', 'bespoke-v-neck-a-line-wedding-dress-with-spaghetti-straps-chapel-train-abito-da-sposa-completamente-in-pizzo-macrame-bac', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"16\",\"position\":2},{\"id\":\"27\",\"position\":3}]', '2', '16', '27', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-07-654a3d1704f10.png\",\"2023-11-07-654a3d1705f47.png\",\"2023-11-07-654a3d170613c.png\"]', '[]', '2023-11-07-654a3d170636e.png', '1', NULL, 'youtube', NULL, '[]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"2\",\"4\",\"6\",\"8\"]}]', '[{\"type\":\"2\",\"price\":111,\"sku\":\"BVAWDwSSCTADSCiPMB-2\",\"qty\":50},{\"type\":\"4\",\"price\":110,\"sku\":\"BVAWDwSSCTADSCiPMB-4\",\"qty\":50},{\"type\":\"6\",\"price\":112,\"sku\":\"BVAWDwSSCTADSCiPMB-6\",\"qty\":50},{\"type\":\"8\",\"price\":115,\"sku\":\"BVAWDwSSCTADSCiPMB-8\",\"qty\":50}]', 0, 110, 120, '0', 'percent', 'include', '5', 'percent', 200, 1, '<p>Bespoke V-neck A-line Wedding Dress with Spaghetti Straps Chapel Train Abito Da Sposa Completamente in Pizzo Macram&egrave; Backless<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-07 16:35:19', '2024-01-22 14:27:10', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '180433', NULL, NULL),
(115, 'admin', 1, 'Petal Sleeve Stand Collar Hollow Out Flower Lace Patchwork Shirt Femme Blusas Al', 'petal-sleeve-stand-collar-hollow-out-flower-lace-patchwork-shirt-femme-blusas-all-match-women-lace-blouse-button-white-t', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"28\",\"position\":2},{\"id\":\"29\",\"position\":3}]', '2', '28', '29', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-07-654a508076d2f.png\",\"2023-11-07-654a508077c8d.png\",\"2023-11-07-654a508077ea7.png\",\"2023-11-07-654a50807cc86.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-07-654a508076d2f.png\"},{\"color\":\"F5DEB3\",\"image_name\":\"2023-11-07-654a508077c8d.png\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-07-654a508077ea7.png\"},{\"color\":null,\"image_name\":\"2023-11-07-654a50807cc86.png\"}]', '2023-11-07-654a50807cf75.png', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#F5DEB3\",\"#FFFFFF\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\"]}]', '[{\"type\":\"Black-S\",\"price\":10,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-Black-S\",\"qty\":50},{\"type\":\"Black-M\",\"price\":10,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-Black-M\",\"qty\":50},{\"type\":\"Black-L\",\"price\":10,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-Black-L\",\"qty\":50},{\"type\":\"Wheat-S\",\"price\":11,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-Wheat-S\",\"qty\":50},{\"type\":\"Wheat-M\",\"price\":11,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-Wheat-M\",\"qty\":50},{\"type\":\"Wheat-L\",\"price\":11,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-Wheat-L\",\"qty\":50},{\"type\":\"White-S\",\"price\":9,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-White-S\",\"qty\":50},{\"type\":\"White-M\",\"price\":9,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-White-M\",\"qty\":50},{\"type\":\"White-L\",\"price\":9,\"sku\":\"PSSCHOFLPSFBAWLBBWT1-White-L\",\"qty\":50}]', 0, 10, 11, '0', 'percent', 'include', '2', 'percent', 450, 1, '<pre>\r\nPetal Sleeve Stand Collar Hollow Out Flower Lace Patchwork Shirt Femme Blusas All-match Women Lace Blouse Button White Top 12419</pre>', 0, NULL, '2023-11-07 17:58:08', '2023-11-07 17:58:08', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '145274', NULL, NULL),
(116, 'admin', 1, 'Autumn Winter Striped Knitted Pullover Tops For Women Casual Line Pattern Long S', 'autumn-winter-striped-knitted-pullover-tops-for-women-casual-line-pattern-long-sleeve-oversized-sweaters-chic-street-kni', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"28\",\"position\":2},{\"id\":\"30\",\"position\":3}]', '2', '28', '30', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-07-654a55a259679.png\",\"2023-11-07-654a55a25c875.png\"]', '[{\"color\":\"FFE4E1\",\"image_name\":\"2023-11-07-654a55a259679.png\"},{\"color\":null,\"image_name\":\"2023-11-07-654a55a25c875.png\"}]', '2023-11-07-654a55a25caf1.png', NULL, NULL, 'youtube', NULL, '[\"#FFE4E1\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\"]}]', '[{\"type\":\"MistyRose-S\",\"price\":14,\"sku\":\"AWSKPTFWCLPLSOSCSK-MistyRose-S\",\"qty\":50},{\"type\":\"MistyRose-M\",\"price\":14,\"sku\":\"AWSKPTFWCLPLSOSCSK-MistyRose-M\",\"qty\":50},{\"type\":\"MistyRose-L\",\"price\":15,\"sku\":\"AWSKPTFWCLPLSOSCSK-MistyRose-L\",\"qty\":50}]', 0, 15, 17, '0', 'percent', 'include', '5', 'percent', 150, 1, '<pre>\r\n\r\nAutumn Winter Striped Knitted Pullover Tops For Women Casual Line Pattern Long Sleeve Oversized Sweaters Chic Street Knitwear\r\nMaterial Polyester</pre>\r\n\r\n<p>Fit Type: LOOSE</p>\r\n\r\n<pre>\r\n\r\n&nbsp;</pre>', 0, NULL, '2023-11-07 18:20:02', '2023-11-07 18:20:02', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '115244', NULL, NULL),
(117, 'admin', 1, 'Women\'s Summer T-shirts Sexy Transparent Mesh Crop Tops Long Sleeve Shirts Y2K L', 'womens-summer-t-shirts-sexy-transparent-mesh-crop-tops-long-sleeve-shirts-y2k-ladies-black-clubwear-skinny-slim-tees-clo', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"28\",\"position\":2},{\"id\":\"31\",\"position\":3}]', '2', '28', '31', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-07-654a5774a51c5.png\",\"2023-11-07-654a5774a8631.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-07-654a5774a51c5.png\"},{\"color\":null,\"image_name\":\"2023-11-07-654a5774a8631.png\"}]', '2023-11-07-654a5774a88ef.png', NULL, NULL, 'youtube', NULL, '[\"#000000\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\"]}]', '[{\"type\":\"Black-S\",\"price\":6,\"sku\":\"WSTSTMCTLSSYLBCSSTC-Black-S\",\"qty\":50},{\"type\":\"Black-M\",\"price\":7,\"sku\":\"WSTSTMCTLSSYLBCSSTC-Black-M\",\"qty\":50},{\"type\":\"Black-L\",\"price\":7,\"sku\":\"WSTSTMCTLSSYLBCSSTC-Black-L\",\"qty\":50}]', 0, 6, 10, '0', 'percent', 'include', '5', 'percent', 150, 1, '<pre>\r\nWomen&#39;s Summer T-shirts Sexy Transparent Mesh Crop Tops Long Sleeve Shirts Y2K Ladies Black Clubwear Skinny Slim Tees Clothes\r\n</pre>\r\n\r\n<p><strong>Specifications:</strong></p>\r\n\r\n<p>Item Name: women long sleeve shirt</p>\r\n\r\n<p>Gender: Women</p>\r\n\r\n<p>Material: Polyester</p>\r\n\r\n<p>Size:S/M/L</p>\r\n\r\n<p>Color: Black</p>\r\n\r\n<p>Weight: 0.12kg</p>\r\n\r\n<p>&nbsp;</p>', 0, NULL, '2023-11-07 18:27:48', '2023-11-07 18:27:48', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '116240', NULL, NULL),
(118, 'admin', 1, 'Love Heart O Neck Knit Sweater For Women Embroidery Fashion Long Sleeve Pullover', 'love-heart-o-neck-knit-sweater-for-women-embroidery-fashion-long-sleeve-pullover-sweaters-female-oversized-high-street-j', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"28\",\"position\":2},{\"id\":\"32\",\"position\":3}]', '2', '28', '32', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-07-654a7dd6bf1b1.png\",\"2023-11-07-654a7dd6c010a.png\",\"2023-11-07-654a7dd6c02b6.png\",\"2023-11-07-654a7dd6c5347.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-07-654a7dd6bf1b1.png\"},{\"color\":\"FFB6C1\",\"image_name\":\"2023-11-07-654a7dd6c010a.png\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-07-654a7dd6c02b6.png\"},{\"color\":null,\"image_name\":\"2023-11-07-654a7dd6c5347.png\"}]', '2023-11-07-654a7dd6c568b.png', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#FFB6C1\",\"#FFFFFF\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"  M\",\"  L\"]}]', '[{\"type\":\"Black-S\",\"price\":13,\"sku\":\"LHONKSFWEFLSPSFOHSJ-Black-S\",\"qty\":50},{\"type\":\"Black-M\",\"price\":13,\"sku\":\"LHONKSFWEFLSPSFOHSJ-Black-M\",\"qty\":50},{\"type\":\"Black-L\",\"price\":12,\"sku\":\"LHONKSFWEFLSPSFOHSJ-Black-L\",\"qty\":50},{\"type\":\"LightPink-S\",\"price\":12,\"sku\":\"LHONKSFWEFLSPSFOHSJ-LightPink-S\",\"qty\":50},{\"type\":\"LightPink-M\",\"price\":12,\"sku\":\"LHONKSFWEFLSPSFOHSJ-LightPink-M\",\"qty\":50},{\"type\":\"LightPink-L\",\"price\":12,\"sku\":\"LHONKSFWEFLSPSFOHSJ-LightPink-L\",\"qty\":50},{\"type\":\"White-S\",\"price\":14,\"sku\":\"LHONKSFWEFLSPSFOHSJ-White-S\",\"qty\":50},{\"type\":\"White-M\",\"price\":14,\"sku\":\"LHONKSFWEFLSPSFOHSJ-White-M\",\"qty\":50},{\"type\":\"White-L\",\"price\":14,\"sku\":\"LHONKSFWEFLSPSFOHSJ-White-L\",\"qty\":50}]', 0, 13, 15, '0', 'percent', 'include', '3', 'percent', 450, 1, '<pre>\r\nLove Heart O Neck Knit Sweater For Women Embroidery Fashion Long Sleeve Pullover Sweaters Female Oversized High Street Jumper</pre>', 0, NULL, '2023-11-07 21:11:34', '2023-11-07 21:14:49', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '146341', NULL, NULL),
(119, 'admin', 1, '2023 New Vintage Bandage Maxi Dress Women Lantern Sleeve Long Party Dresses Autu', '2023-new-vintage-bandage-maxi-dress-women-lantern-sleeve-long-party-dresses-autumn-elegant-luxury-guest-wedding-evening-', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"33\",\"position\":2},{\"id\":\"34\",\"position\":3}]', '2', '33', '34', 6, 'pc', 1, 1, NULL, NULL, '[\"2023-11-08-654bb9e89745c.png\",\"2023-11-08-654bb9e8ae55f.png\",\"2023-11-08-654bb9e8ae7ef.png\",\"2023-11-08-654bb9e934fc5.png\"]', '[{\"color\":\"800000\",\"image_name\":\"2023-11-08-654bb9e89745c.png\"},{\"color\":\"6B8E23\",\"image_name\":\"2023-11-08-654bb9e8ae55f.png\"},{\"color\":\"800080\",\"image_name\":\"2023-11-08-654bb9e8ae7ef.png\"},{\"color\":null,\"image_name\":\"2023-11-08-654bb9e934fc5.png\"}]', '2023-11-08-654bb9e935343.png', NULL, NULL, 'youtube', NULL, '[\"#800000\",\"#6B8E23\",\"#800080\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\",\"XL\"]}]', '[{\"type\":\"Maroon-S\",\"price\":13,\"sku\":\"2NVBMDWLSLPDAELGWEV-Maroon-S\",\"qty\":50},{\"type\":\"Maroon-M\",\"price\":12,\"sku\":\"2NVBMDWLSLPDAELGWEV-Maroon-M\",\"qty\":50},{\"type\":\"Maroon-L\",\"price\":14,\"sku\":\"2NVBMDWLSLPDAELGWEV-Maroon-L\",\"qty\":50},{\"type\":\"Maroon-XL\",\"price\":13,\"sku\":\"2NVBMDWLSLPDAELGWEV-Maroon-XL\",\"qty\":50},{\"type\":\"OliveDrab-S\",\"price\":13,\"sku\":\"2NVBMDWLSLPDAELGWEV-OliveDrab-S\",\"qty\":50},{\"type\":\"OliveDrab-M\",\"price\":14,\"sku\":\"2NVBMDWLSLPDAELGWEV-OliveDrab-M\",\"qty\":50},{\"type\":\"OliveDrab-L\",\"price\":15,\"sku\":\"2NVBMDWLSLPDAELGWEV-OliveDrab-L\",\"qty\":50},{\"type\":\"OliveDrab-XL\",\"price\":14,\"sku\":\"2NVBMDWLSLPDAELGWEV-OliveDrab-XL\",\"qty\":50},{\"type\":\"Purple-S\",\"price\":12,\"sku\":\"2NVBMDWLSLPDAELGWEV-Purple-S\",\"qty\":50},{\"type\":\"Purple-M\",\"price\":13,\"sku\":\"2NVBMDWLSLPDAELGWEV-Purple-M\",\"qty\":50},{\"type\":\"Purple-L\",\"price\":14,\"sku\":\"2NVBMDWLSLPDAELGWEV-Purple-L\",\"qty\":50},{\"type\":\"Purple-XL\",\"price\":14,\"sku\":\"2NVBMDWLSLPDAELGWEV-Purple-XL\",\"qty\":50}]', 0, 13, 15, '0', 'percent', 'include', '5', 'percent', 600, 1, '<h3>2023 New Vintage Bandage Maxi Dress Women Lantern Sleeve Long Party Dresses Autumn Elegant Luxury Guest Wedding Evening Vestidos</h3>\r\n\r\n<pre>\r\nMaterial: Polyester</pre>', 0, NULL, '2023-11-08 19:40:09', '2023-11-08 19:40:09', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '120610', NULL, NULL),
(120, 'admin', 1, 'Sching Fake Two-Piece Hepburn Lightly Mature Dress Women\'s Summer New French Min', 'sching-fake-two-piece-hepburn-lightly-mature-dress-womens-summer-new-french-minority-waist-tight-show-thin-blk-dress-FqF', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"33\",\"position\":2},{\"id\":\"35\",\"position\":3}]', '2', '33', '35', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-08-654bc29a4232e.png\",\"2023-11-08-654bc29a4626b.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-08-654bc29a4232e.png\"},{\"color\":null,\"image_name\":\"2023-11-08-654bc29a4626b.png\"}]', '2023-11-08-654bc29a46533.png', NULL, NULL, 'youtube', NULL, '[\"#000000\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]}]', '[{\"type\":\"Black-S\",\"price\":3,\"sku\":\"SFTHLMDWSNFMWSTBD-Black-S\",\"qty\":1},{\"type\":\"Black-M\",\"price\":4,\"sku\":\"SFTHLMDWSNFMWSTBD-Black-M\",\"qty\":1},{\"type\":\"Black-L\",\"price\":4,\"sku\":\"SFTHLMDWSNFMWSTBD-Black-L\",\"qty\":1},{\"type\":\"Black-XL\",\"price\":5,\"sku\":\"SFTHLMDWSNFMWSTBD-Black-XL\",\"qty\":1},{\"type\":\"Black-XXL\",\"price\":4.99,\"sku\":\"SFTHLMDWSNFMWSTBD-Black-XXL\",\"qty\":1}]', 0, 4, 5, '0', 'percent', 'include', '3', 'percent', 5, 1, '<pre>\r\nPle of shipment: Guang province\r\nFabric/Material: Chemical Fiber/polyester (polyester fiber)\r\nIngredient content: 81%(inclusive)-90%(inclusive)\r\nStyle: niche features/minimalism\r\nPopular element/process: Three-dimensional decoration, voile, zipper\r\nCombination form: Fake two pieces\r\nStyle: A-line skirt\r\nSleeve length: short sleeve\r\nSkirt length: mid skirt\r\nCollar style: round neck\r\nWith/without Velvet: no velvet\r\nTime to Market: Summer 2021\r\nSleeve type: Conventional</pre>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 246px; top: -5.6px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 0, NULL, '2023-11-08 20:17:14', '2023-11-08 20:17:14', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '112403', NULL, NULL),
(121, 'admin', 1, 'Women Elegant Luxury Dress Evening Party Prom Wedding Club Graduation Backless S', 'women-elegant-luxury-dress-evening-party-prom-wedding-club-graduation-backless-sleeveless-one-shoulder-maxi-dresses-sexy', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"33\",\"position\":2},{\"id\":\"36\",\"position\":3}]', '2', '33', '36', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-08-654bd3826378d.png\",\"2023-11-08-654bd38264a1c.png\",\"2023-11-08-654bd38264c76.png\",\"2023-11-08-654bd3826b325.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-08-654bd3826378d.png\"},{\"color\":\"0000FF\",\"image_name\":\"2023-11-08-654bd38264a1c.png\"},{\"color\":\"FF0000\",\"image_name\":\"2023-11-08-654bd38264c76.png\"},{\"color\":null,\"image_name\":\"2023-11-08-654bd3826b325.png\"}]', '2023-11-08-654bd3826b61f.png', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#0000FF\",\"#FF0000\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\",\"XL\"]}]', '[{\"type\":\"Black-S\",\"price\":8,\"sku\":\"WELDEPPWCGBSOSMDSV-Black-S\",\"qty\":100},{\"type\":\"Black-M\",\"price\":8,\"sku\":\"WELDEPPWCGBSOSMDSV-Black-M\",\"qty\":100},{\"type\":\"Black-L\",\"price\":9,\"sku\":\"WELDEPPWCGBSOSMDSV-Black-L\",\"qty\":100},{\"type\":\"Black-XL\",\"price\":9,\"sku\":\"WELDEPPWCGBSOSMDSV-Black-XL\",\"qty\":100},{\"type\":\"Blue-S\",\"price\":8,\"sku\":\"WELDEPPWCGBSOSMDSV-Blue-S\",\"qty\":100},{\"type\":\"Blue-M\",\"price\":9,\"sku\":\"WELDEPPWCGBSOSMDSV-Blue-M\",\"qty\":100},{\"type\":\"Blue-L\",\"price\":10,\"sku\":\"WELDEPPWCGBSOSMDSV-Blue-L\",\"qty\":100},{\"type\":\"Blue-XL\",\"price\":8,\"sku\":\"WELDEPPWCGBSOSMDSV-Blue-XL\",\"qty\":100},{\"type\":\"Red-S\",\"price\":9,\"sku\":\"WELDEPPWCGBSOSMDSV-Red-S\",\"qty\":100},{\"type\":\"Red-M\",\"price\":9,\"sku\":\"WELDEPPWCGBSOSMDSV-Red-M\",\"qty\":100},{\"type\":\"Red-L\",\"price\":8,\"sku\":\"WELDEPPWCGBSOSMDSV-Red-L\",\"qty\":100},{\"type\":\"Red-XL\",\"price\":10,\"sku\":\"WELDEPPWCGBSOSMDSV-Red-XL\",\"qty\":100}]', 0, 8, 10, '0', 'percent', 'include', '5', 'percent', 1200, 1, '<p>Women Elegant Luxury Dress Evening Party Prom Wedding Club Graduation Backless Sleeveless One Shoulder Maxi Dresses Sexy Vestido<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-08 21:29:22', '2023-11-08 21:29:22', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '153217', NULL, NULL),
(122, 'admin', 1, 'Korean Fashion Casual Women\'s Pants Loose Straight Wide Leg Pants for Women Offi', 'korean-fashion-casual-womens-pants-loose-straight-wide-leg-pants-for-women-office-lady-cargo-pants-woman-pants-baggy-clo', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"19\",\"position\":2},{\"id\":\"20\",\"position\":3}]', '2', '19', '20', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-08-654bd65c99c52.png\",\"2023-11-08-654bd65c9ac91.png\",\"2023-11-08-654bd65c9aeda.png\",\"2023-11-08-654bd65ca01a9.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-08-654bd65c99c52.png\"},{\"color\":\"D2B48C\",\"image_name\":\"2023-11-08-654bd65c9ac91.png\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-08-654bd65c9aeda.png\"},{\"color\":null,\"image_name\":\"2023-11-08-654bd65ca01a9.png\"}]', '2023-11-08-654bd65ca04d7.png', '1', NULL, 'youtube', NULL, '[\"#000000\",\"#D2B48C\",\"#FFFFFF\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\"]}]', '[{\"type\":\"Black-S\",\"price\":12,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-Black-S\",\"qty\":100},{\"type\":\"Black-M\",\"price\":12,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-Black-M\",\"qty\":100},{\"type\":\"Black-L\",\"price\":13,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-Black-L\",\"qty\":100},{\"type\":\"Tan-S\",\"price\":12.01,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-Tan-S\",\"qty\":100},{\"type\":\"Tan-M\",\"price\":13,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-Tan-M\",\"qty\":100},{\"type\":\"Tan-L\",\"price\":13,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-Tan-L\",\"qty\":100},{\"type\":\"White-S\",\"price\":13,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-White-S\",\"qty\":100},{\"type\":\"White-M\",\"price\":13,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-White-M\",\"qty\":100},{\"type\":\"White-L\",\"price\":14,\"sku\":\"KFCWPLSWLPfWOLCPWPBC-White-L\",\"qty\":100}]', 0, 12, 13, '0', 'percent', 'include', '5', 'percent', 900, 1, '<p>Korean Fashion Casual Women&#39;s Pants Loose Straight Wide Leg Pants for Women Office Lady Cargo Pants Woman Pants Baggy Clothing<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-08 21:41:32', '2023-11-14 12:06:03', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '179068', NULL, NULL),
(123, 'admin', 1, 'Summer High Waist Slim Shorts Women Korean Tight Elastic Bag Hip Three-point Hot', 'summer-high-waist-slim-shorts-women-korean-tight-elastic-bag-hip-three-point-hot-pants-casual-outer-wear-bottoms-female-', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"19\",\"position\":2},{\"id\":\"21\",\"position\":3}]', '2', '19', '21', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-08-654bd83e96d06.png\",\"2023-11-08-654bd83e97d29.png\",\"2023-11-08-654bd83e9bb08.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-08-654bd83e96d06.png\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-08-654bd83e97d29.png\"},{\"color\":null,\"image_name\":\"2023-11-08-654bd83e9bb08.png\"}]', '2023-11-08-654bd83e9bdde.png', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#FFFFFF\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\"]}]', '[{\"type\":\"Black-S\",\"price\":6,\"sku\":\"SHWSSWKTEBHTHPCOWBFC-Black-S\",\"qty\":100},{\"type\":\"Black-M\",\"price\":6,\"sku\":\"SHWSSWKTEBHTHPCOWBFC-Black-M\",\"qty\":100},{\"type\":\"Black-L\",\"price\":7,\"sku\":\"SHWSSWKTEBHTHPCOWBFC-Black-L\",\"qty\":97},{\"type\":\"White-S\",\"price\":7,\"sku\":\"SHWSSWKTEBHTHPCOWBFC-White-S\",\"qty\":100},{\"type\":\"White-M\",\"price\":7,\"sku\":\"SHWSSWKTEBHTHPCOWBFC-White-M\",\"qty\":100},{\"type\":\"White-L\",\"price\":8,\"sku\":\"SHWSSWKTEBHTHPCOWBFC-White-L\",\"qty\":100}]', 0, 6, 7, '0', 'percent', 'include', '2.99', 'percent', 597, 1, '<p>Summer High Waist Slim Shorts Women Korean Tight Elastic Bag Hip Three-point Hot Pants Casual Outer Wear Bottoms Female Clothes</p>', 0, NULL, '2023-11-08 21:49:34', '2023-11-26 00:13:17', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '173934', NULL, NULL),
(124, 'admin', 1, 'ZOKI White Women Pleated Skirts Summer High Waist Zipper Girls Dancing JK Mini S', 'zoki-white-women-pleated-skirts-summer-high-waist-zipper-girls-dancing-jk-mini-skirts-black-fashion-student-a-line-falda', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"19\",\"position\":2},{\"id\":\"22\",\"position\":3}]', '2', '19', '22', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-08-654bdc081f5a0.png\",\"2023-11-08-654bdc08208eb.png\",\"2023-11-08-654bdc08252d5.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-08-654bdc081f5a0.png\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-08-654bdc08208eb.png\"},{\"color\":null,\"image_name\":\"2023-11-08-654bdc08252d5.png\"}]', '2023-11-08-654bdc0825615.png', '1', NULL, 'youtube', NULL, '[\"#000000\",\"#FFFFFF\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\"]}]', '[{\"type\":\"Black-S\",\"price\":3,\"sku\":\"ZWWPSSHWZGDJMSBFSALF2-Black-S\",\"qty\":50},{\"type\":\"Black-M\",\"price\":2,\"sku\":\"ZWWPSSHWZGDJMSBFSALF2-Black-M\",\"qty\":50},{\"type\":\"Black-L\",\"price\":3,\"sku\":\"ZWWPSSHWZGDJMSBFSALF2-Black-L\",\"qty\":50},{\"type\":\"White-S\",\"price\":2,\"sku\":\"ZWWPSSHWZGDJMSBFSALF2-White-S\",\"qty\":50},{\"type\":\"White-M\",\"price\":2,\"sku\":\"ZWWPSSHWZGDJMSBFSALF2-White-M\",\"qty\":50},{\"type\":\"White-L\",\"price\":3,\"sku\":\"ZWWPSSHWZGDJMSBFSALF2-White-L\",\"qty\":50}]', 0, 3, 4, '0', 'percent', 'include', '0', 'percent', 300, 1, '<p>ZOKI White Women Pleated Skirts Summer High Waist Zipper Girls Dancing JK Mini Skirts Black Fashion Student A Line Faldas 2023</p>', 0, NULL, '2023-11-08 22:05:44', '2023-11-14 12:06:01', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '144003', NULL, NULL),
(125, 'admin', 1, 'Women\'s Jeans High Waist 2023 Spring Summer Fashion Streetwear Straight Wide Leg', 'womens-jeans-high-waist-2023-spring-summer-fashion-streetwear-straight-wide-leg-pants-loose-casual-female-denim-trousers', 'physical', '[{\"id\":\"2\",\"position\":1},{\"id\":\"19\",\"position\":2},{\"id\":\"23\",\"position\":3}]', '2', '19', '23', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-08-654bf60dd7ffd.png\",\"2023-11-08-654bf60dd93e0.png\",\"2023-11-08-654bf60dd9640.png\",\"2023-11-08-654bf60e048ed.png\",\"2023-11-08-654bf60e04c6c.png\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-08-654bf60dd7ffd.png\"},{\"color\":\"00008B\",\"image_name\":\"2023-11-08-654bf60dd93e0.png\"},{\"color\":\"ADD8E6\",\"image_name\":\"2023-11-08-654bf60dd9640.png\"},{\"color\":null,\"image_name\":\"2023-11-08-654bf60e048ed.png\"},{\"color\":null,\"image_name\":\"2023-11-08-654bf60e04c6c.png\"}]', '2023-11-08-654bf60e04fa0.png', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#00008B\",\"#ADD8E6\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"M\",\"L\",\"XL\"]}]', '[{\"type\":\"Black-S\",\"price\":7,\"sku\":\"WJHW2SSFSSWLPLCFDT-Black-S\",\"qty\":100},{\"type\":\"Black-M\",\"price\":7,\"sku\":\"WJHW2SSFSSWLPLCFDT-Black-M\",\"qty\":100},{\"type\":\"Black-L\",\"price\":8,\"sku\":\"WJHW2SSFSSWLPLCFDT-Black-L\",\"qty\":100},{\"type\":\"Black-XL\",\"price\":8,\"sku\":\"WJHW2SSFSSWLPLCFDT-Black-XL\",\"qty\":100},{\"type\":\"DarkBlue-S\",\"price\":7,\"sku\":\"WJHW2SSFSSWLPLCFDT-DarkBlue-S\",\"qty\":100},{\"type\":\"DarkBlue-M\",\"price\":8,\"sku\":\"WJHW2SSFSSWLPLCFDT-DarkBlue-M\",\"qty\":100},{\"type\":\"DarkBlue-L\",\"price\":7,\"sku\":\"WJHW2SSFSSWLPLCFDT-DarkBlue-L\",\"qty\":100},{\"type\":\"DarkBlue-XL\",\"price\":7,\"sku\":\"WJHW2SSFSSWLPLCFDT-DarkBlue-XL\",\"qty\":99},{\"type\":\"LightBlue-S\",\"price\":8,\"sku\":\"WJHW2SSFSSWLPLCFDT-LightBlue-S\",\"qty\":100},{\"type\":\"LightBlue-M\",\"price\":8,\"sku\":\"WJHW2SSFSSWLPLCFDT-LightBlue-M\",\"qty\":100},{\"type\":\"LightBlue-L\",\"price\":8,\"sku\":\"WJHW2SSFSSWLPLCFDT-LightBlue-L\",\"qty\":100},{\"type\":\"LightBlue-XL\",\"price\":7,\"sku\":\"WJHW2SSFSSWLPLCFDT-LightBlue-XL\",\"qty\":100}]', 0, 7, 8, '0', 'percent', 'include', '3', 'percent', 1199, 1, '<p>Women&#39;s Jeans High Waist 2023 Spring Summer Fashion Streetwear Straight Wide Leg Pants Loose Casual Female Denim Trousers<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-08 23:56:46', '2023-11-08 23:56:46', 1, 1, NULL, NULL, 'def.png', 1, NULL, 0.00, 0, NULL, NULL, '154324', NULL, NULL),
(126, 'admin', 1, 'Men\'s Casual Shirt Cotton Linen Long-Sleeved Top Beach Vintage Stand Collar Desi', 'mens-casual-shirt-cotton-linen-long-sleeved-top-beach-vintage-stand-collar-design-stylish-style-loose-bag-plus-size-four', 'physical', '[{\"id\":\"3\",\"position\":1},{\"id\":\"14\",\"position\":2},{\"id\":\"44\",\"position\":3}]', '3', '14', '44', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-09-654d2788a65f5.webp\",\"2023-11-09-654d2788be773.webp\",\"2023-11-09-654d2788d5dda.webp\",\"2023-11-09-654d2788e9c38.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-09-654d2788a65f5.webp\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-09-654d2788be773.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d2788d5dda.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d2788e9c38.webp\"}]', '2023-11-09-654d27890d329.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#FFFFFF\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"M\",\"L\",\"XL\"]}]', '[{\"type\":\"Black-M\",\"price\":9,\"sku\":\"MCSCLLTBVSCDSSLBPFS-Black-M\",\"qty\":100},{\"type\":\"Black-L\",\"price\":11,\"sku\":\"MCSCLLTBVSCDSSLBPFS-Black-L\",\"qty\":100},{\"type\":\"Black-XL\",\"price\":11,\"sku\":\"MCSCLLTBVSCDSSLBPFS-Black-XL\",\"qty\":100},{\"type\":\"White-M\",\"price\":9,\"sku\":\"MCSCLLTBVSCDSSLBPFS-White-M\",\"qty\":100},{\"type\":\"White-L\",\"price\":10,\"sku\":\"MCSCLLTBVSCDSSLBPFS-White-L\",\"qty\":100},{\"type\":\"White-XL\",\"price\":11,\"sku\":\"MCSCLLTBVSCDSSLBPFS-White-XL\",\"qty\":100}]', 0, 10, 12, '0', 'percent', 'include', '3', 'percent', 600, 1, '<p>Men&#39;s Casual Shirt Cotton Linen Long-Sleeved Top Beach Vintage Stand Collar Design Stylish Style Loose Bag Plus-Size Four Season<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-09 21:40:09', '2023-11-09 21:40:09', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '130595', NULL, NULL),
(127, 'admin', 1, '2piece/set Fashion Designer Pu Leather Women\'s Handbags Good Casual Ladies Tote', '2pieceset-fashion-designer-pu-leather-womens-handbags-good-casual-ladies-tote-female-black-bucket-women-shoulder-crossbo', 'physical', '[{\"id\":\"259\",\"position\":1},{\"id\":\"187\",\"position\":2}]', '259', '187', NULL, 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-09-654d29e1d9541.webp\",\"2023-11-09-654d29e1f0249.webp\",\"2023-11-09-654d29e2159a6.webp\",\"2023-11-09-654d29e22fd3c.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-09-654d29e1d9541.webp\"},{\"color\":\"A52A2A\",\"image_name\":\"2023-11-09-654d29e1f0249.webp\"},{\"color\":\"8FBC8F\",\"image_name\":\"2023-11-09-654d29e2159a6.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d29e22fd3c.webp\"}]', '2023-11-09-654d29e2452c9.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#A52A2A\",\"#8FBC8F\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":12,\"sku\":\"2FDPLWHGCLTFBBWSCB-Black\",\"qty\":100},{\"type\":\"Brown\",\"price\":11,\"sku\":\"2FDPLWHGCLTFBBWSCB-Brown\",\"qty\":100},{\"type\":\"DarkSeaGreen\",\"price\":10,\"sku\":\"2FDPLWHGCLTFBBWSCB-DarkSeaGreen\",\"qty\":100}]', 0, 11, 13, '0', 'percent', 'include', '3', 'percent', 300, 1, '<p>2piece/set Fashion Designer Pu Leather Women&#39;s Handbags Good Casual Ladies Tote Female Black Bucket Women Shoulder Crossbody Bag<br />\r\nUpper width 18CM, lower width 24CM, height 23CM, thickness 16CM</p>', 0, NULL, '2023-11-09 21:50:10', '2024-01-16 02:38:09', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '179105', 'All', NULL),
(128, 'admin', 1, 'Mini Massage Gun Fitness Fascia Gun Vibrator Massager For Body Shaping Back Rela', 'mini-massage-gun-fitness-fascia-gun-vibrator-massager-for-body-shaping-back-relaxation-treatment-pain-relief-muscle-mass', 'physical', '[{\"id\":\"5\",\"position\":1},{\"id\":\"93\",\"position\":2},{\"id\":\"96\",\"position\":3}]', '5', '93', '96', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-09-654d2ccf8cfa1.webp\",\"2023-11-09-654d2ccfa409f.webp\",\"2023-11-09-654d2ccfb9654.webp\",\"2023-11-09-654d2ccfcc7a8.webp\"]', '[{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-09-654d2ccf8cfa1.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d2ccfa409f.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d2ccfb9654.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d2ccfcc7a8.webp\"}]', '2023-11-09-654d2ccfdd86c.webp', NULL, NULL, 'youtube', NULL, '[\"#FFFFFF\"]', 0, 'null', '[]', '[{\"type\":\"White\",\"price\":35,\"sku\":\"MMGFFGVMFBSBR-White\",\"qty\":100}]', 0, 35, 40, '0', 'percent', 'include', '4.99', 'percent', 100, 1, '<p>Mini Massage Gun Fitness Fascia Gun Vibrator Massager For Body Shaping Back Relaxation Treatment Pain Relief Muscle Massage Guns<br />\r\nRotational speed: 4000 r / m<br />\r\nUSB charging<br />\r\nProduct power: 30W<br />\r\nBattery capacity:1500mAh</p>', 0, NULL, '2023-11-09 22:02:39', '2023-11-09 22:23:25', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '115046', NULL, NULL),
(129, 'admin', 1, '2022 Ins Fashion Children Sneakers Children Canvas Shoes Kids Size 25-37 Boys Sn', '2022-ins-fashion-children-sneakers-children-canvas-shoes-kids-size-25-37-boys-sneakers-girls-shoes-high-boots-lace-up-de', 'physical', '[{\"id\":\"4\",\"position\":1},{\"id\":\"192\",\"position\":2},{\"id\":\"238\",\"position\":3}]', '4', '192', '238', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-09-654d2efbe6479.webp\",\"2023-11-09-654d2efc06368.webp\",\"2023-11-09-654d2efc210ef.webp\",\"2023-11-09-654d2efc32e8e.webp\"]', '[{\"color\":\"00008B\",\"image_name\":\"2023-11-09-654d2efbe6479.webp\"},{\"color\":\"ADD8E6\",\"image_name\":\"2023-11-09-654d2efc06368.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d2efc210ef.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d2efc32e8e.webp\"}]', '2023-11-09-654d2efc46506.webp', NULL, NULL, 'youtube', NULL, '[\"#00008B\",\"#ADD8E6\"]', 0, 'null', '[]', '[{\"type\":\"DarkBlue\",\"price\":17,\"sku\":\"2IFCSCCSKS2BSGSHBLD-DarkBlue\",\"qty\":100},{\"type\":\"LightBlue\",\"price\":18,\"sku\":\"2IFCSCCSKS2BSGSHBLD-LightBlue\",\"qty\":100}]', 0, 17, 18, '0', 'percent', 'include', '3', 'percent', 200, 1, '<p>2022 Ins Fashion Children Sneakers Children Canvas Shoes Kids Size 25-37 Boys Sneakers Girls Shoes High Boots Lace-up Denim</p>', 0, NULL, '2023-11-09 22:11:56', '2024-01-16 02:49:41', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '114315', 'All', NULL),
(130, 'admin', 1, 'Children Drawing Board Projection Table Light Toy For Boy Сoloring Pen Book Tool', 'children-drawing-board-projection-table-light-toy-for-boy-soloring-pen-book-tool-set-girl-learning-educational-kids-3-ye', 'physical', '[{\"id\":\"7\",\"position\":1},{\"id\":\"121\",\"position\":2},{\"id\":\"126\",\"position\":3}]', '7', '121', '126', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-09-654d3184535cd.webp\",\"2023-11-09-654d318468a82.webp\",\"2023-11-09-654d31848073f.webp\",\"2023-11-09-654d31848f2b6.webp\",\"2023-11-09-654d3184a19af.webp\"]', '[{\"color\":\"FFC0CB\",\"image_name\":\"2023-11-09-654d3184535cd.webp\"},{\"color\":\"FFFF00\",\"image_name\":\"2023-11-09-654d318468a82.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d31848073f.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d31848f2b6.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d3184a19af.webp\"}]', '2023-11-09-654d3184b6f3c.webp', NULL, NULL, 'youtube', NULL, '[\"#FFC0CB\",\"#FFFF00\"]', 0, 'null', '[]', '[{\"type\":\"Pink\",\"price\":8,\"sku\":null,\"qty\":50},{\"type\":\"Yellow\",\"price\":9,\"sku\":null,\"qty\":50}]', 0, 8, 9, '0', 'percent', 'include', '3', 'percent', 100, 1, '<p>Children&#39;s mini projection drawing board toy<br />\r\nFunction:<br />\r\nWith the light projection feature, you can change the cartoon pattern by loading slides and manually rotating slides. You can have more images according to the number of slides purchased, up to 72 images, and each image will not be repeated.<br />\r\n&nbsp;<br />\r\nThe images are fruits, vegetables, vehicles, families, numbers, food, animals, and they are all lovely!<br />\r\nCultivate and improve children&#39;s painting talent and ability. Let&#39;s draw with our children.<br />\r\n&nbsp;<br />\r\nUpgrade the set of eraser placement and brush socket functions. Create a convenient habit for children.<br />\r\n&nbsp;<br />\r\nPackage list:<br />\r\nGiraffe drawing board table: 1PCS<br />\r\nColor pencil: 12PCS<br />\r\nPaintbook: 1PCS<br />\r\nPlate eraser: 1PCS<br />\r\nSlide: 3-9PCS (according to the purchase quantity)<br />\r\n&nbsp;<br />\r\nSize:<br />\r\nTable: 24cm * 16cm * 28cm (9.44in * 6.29in * 11.02in)<br />\r\nPainting area: 16cm * 13cm (6.29in * 5.11in)<br />\r\n&nbsp;</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 796px; top: 38.6px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 0, NULL, '2023-11-09 22:22:44', '2023-11-09 22:22:44', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '126801', NULL, NULL),
(131, 'admin', 1, 'Five-layer Bedroom Closets Home Children Storage Cabinets Drawer Design Dressing', 'five-layer-bedroom-closets-home-children-storage-cabinets-drawer-design-dressing-room-versatile-practical-clothing-cupbo', 'physical', '[{\"id\":\"8\",\"position\":1},{\"id\":\"62\",\"position\":2},{\"id\":\"67\",\"position\":3}]', '8', '62', '67', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-09-654d34290b4bf.webp\",\"2023-11-09-654d342922cb7.webp\",\"2023-11-09-654d342939351.webp\"]', '[{\"color\":\"A52A2A\",\"image_name\":\"2023-11-09-654d34290b4bf.webp\"},{\"color\":\"808080\",\"image_name\":\"2023-11-09-654d342922cb7.webp\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-09-654d342939351.webp\"}]', '2023-11-09-654d3429511ef.webp', NULL, NULL, 'youtube', NULL, '[\"#A52A2A\",\"#808080\",\"#FFFFFF\"]', 0, 'null', '[]', '[{\"type\":\"Brown\",\"price\":85,\"sku\":\"FBCHCSCDDDRVPCC-Brown\",\"qty\":50},{\"type\":\"Gray\",\"price\":80,\"sku\":\"FBCHCSCDDDRVPCC-Gray\",\"qty\":50},{\"type\":\"White\",\"price\":82,\"sku\":\"FBCHCSCDDDRVPCC-White\",\"qty\":50}]', 0, 85, 90, '0', 'percent', 'include', '5', 'percent', 150, 1, '<p>Five-layer Bedroom Closets Home Children Storage Cabinets Drawer Design Dressing Room Versatile Practical Clothing Cupboard<br />\r\nSize: 39x32x85cm<br />\r\nMaterial: Plastic</p>', 0, NULL, '2023-11-09 22:34:01', '2023-11-09 22:34:01', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '146657', NULL, NULL),
(132, 'admin', 1, 'Professional Ear Piercing Gun Tools Set Steel Stud Earrings Safe Sterile Cartila', 'professional-ear-piercing-gun-tools-set-steel-stud-earrings-safe-sterile-cartilage-helix-piercing-tool-ear-jewelry-machi', 'physical', '[{\"id\":\"9\",\"position\":1},{\"id\":\"134\",\"position\":2},{\"id\":\"137\",\"position\":3}]', '9', '134', '137', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-09-654d3eace0ca5.webp\",\"2023-11-09-654d3eacf34a7.webp\",\"2023-11-09-654d3ead0fc7c.webp\",\"2023-11-09-654d3ead25844.webp\",\"2023-11-09-654d3ead40e16.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-09-654d3eace0ca5.webp\"},{\"color\":\"0000FF\",\"image_name\":\"2023-11-09-654d3eacf34a7.webp\"},{\"color\":\"800080\",\"image_name\":\"2023-11-09-654d3ead0fc7c.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d3ead25844.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d3ead40e16.webp\"}]', '2023-11-09-654d3ead520e2.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#0000FF\",\"#800080\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":11,\"sku\":\"PEPGTSSSESSC-Black\",\"qty\":100},{\"type\":\"Blue\",\"price\":12,\"sku\":\"PEPGTSSSESSC-Blue\",\"qty\":100},{\"type\":\"Purple\",\"price\":10,\"sku\":\"PEPGTSSSESSC-Purple\",\"qty\":100}]', 0, 11, 12, '0', 'percent', 'include', '3', 'percent', 300, 1, '<p>Professional Ear Piercing Gun Tools Set Steel Stud Earrings Safe Sterile Cartilage Helix Piercing Tool Ear Jewelry Machine Kit</p>', 0, NULL, '2023-11-09 23:18:53', '2023-11-09 23:19:50', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '110396', NULL, NULL),
(133, 'admin', 1, 'Leather Car Seat Covers for Renault Megane 2 3 Fluence Scenic Clio Captur Kadjar', 'leather-car-seat-covers-for-renault-megane-2-3-fluence-scenic-clio-captur-kadjar-logan-2-duster-arkana-kangoo-for-vehicl', 'physical', '[{\"id\":\"10\",\"position\":1},{\"id\":\"146\",\"position\":2},{\"id\":\"150\",\"position\":3}]', '10', '146', '150', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-09-654d412475b51.webp\",\"2023-11-09-654d41248ecfe.webp\",\"2023-11-09-654d4124a90ee.webp\",\"2023-11-09-654d4124c365f.webp\",\"2023-11-09-654d4124da60f.webp\",\"2023-11-09-654d4124edb27.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-09-654d412475b51.webp\"},{\"color\":\"A52A2A\",\"image_name\":\"2023-11-09-654d41248ecfe.webp\"},{\"color\":\"8B0000\",\"image_name\":\"2023-11-09-654d4124a90ee.webp\"},{\"color\":\"4682B4\",\"image_name\":\"2023-11-09-654d4124c365f.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d4124da60f.webp\"},{\"color\":null,\"image_name\":\"2023-11-09-654d4124edb27.webp\"}]', '2023-11-09-654d41251331d.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#A52A2A\",\"#8B0000\",\"#4682B4\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":35,\"sku\":\"LCSCfRM23FSCCKL2DAKfVP-Black\",\"qty\":50},{\"type\":\"Brown\",\"price\":36,\"sku\":\"LCSCfRM23FSCCKL2DAKfVP-Brown\",\"qty\":50},{\"type\":\"DarkRed\",\"price\":33,\"sku\":\"LCSCfRM23FSCCKL2DAKfVP-DarkRed\",\"qty\":50},{\"type\":\"SteelBlue\",\"price\":34,\"sku\":\"LCSCfRM23FSCCKL2DAKfVP-SteelBlue\",\"qty\":50}]', 0, 35, 40, '0', 'percent', 'include', '3', 'percent', 200, 1, '<p>Leather Car Seat Covers for Renault Megane 2 3 Fluence Scenic Clio Captur Kadjar Logan 2 Duster Arkana Kangoo for Vehicle Parts<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-09 23:29:25', '2023-11-09 23:29:25', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '148268', NULL, NULL),
(134, 'admin', 1, '2022 Spring 4 Color Blazer Men Slim Fashion Social Mens Dress Jacket Business Fo', '2022-spring-4-color-blazer-men-slim-fashion-social-mens-dress-jacket-business-formal-jacket-men-office-suit-jacket-s-3xl', 'physical', '[{\"id\":\"3\",\"position\":1},{\"id\":\"15\",\"position\":2},{\"id\":\"48\",\"position\":3}]', '3', '15', '48', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-10-654e2a0ce723d.webp\",\"2023-11-10-654e2a0d052ba.webp\",\"2023-11-10-654e2a0d16005.webp\",\"2023-11-10-654e2a0d2aab3.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-10-654e2a0ce723d.webp\"},{\"color\":\"A52A2A\",\"image_name\":\"2023-11-10-654e2a0d052ba.webp\"},{\"color\":\"808080\",\"image_name\":\"2023-11-10-654e2a0d16005.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e2a0d2aab3.webp\"}]', '2023-11-10-654e2a0d3bf00.webp', '1', NULL, 'youtube', NULL, '[\"#000000\",\"#A52A2A\",\"#808080\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":28,\"sku\":\"2S4CBMSFSMDJBFJMOSJS-Black\",\"qty\":1},{\"type\":\"Brown\",\"price\":25,\"sku\":\"2S4CBMSFSMDJBFJMOSJS-Brown\",\"qty\":1},{\"type\":\"Gray\",\"price\":23.99,\"sku\":\"2S4CBMSFSMDJBFJMOSJS-Gray\",\"qty\":1}]', 0, 25, 30, '0', 'percent', 'include', '3', 'percent', 3, 1, '<p>Before placing an order, you must check the following shopping tips, so that you will have a successful shopping experience:&nbsp;</p>\r\n\r\n<p>1. Size: This is Asian size, about 3 sizes smaller.than US/EU size. For example, if you wear US/EU size M, we suggest you choose our Asian size XXL.&nbsp;</p>\r\n\r\n<p>2. Color: Different computer screen can display different colors even if it is the same color. So please allow a reasonable color difference.&nbsp;</p>\r\n\r\n<p>3. Normally we will arrange your order within 3 days. after the payment&nbsp;</p>\r\n\r\n<p>4. Feedback is very important to us, please kindly give us? 4 or 5 stars. positive feedback. If you encounter any problems, please try to contact us, we are glad to help you deal with any problem&nbsp;</p>\r\n\r\n<p>Please read carefully before you place your order. Asian size is? different from the US size.<br />\r\n&nbsp;</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 742px; top: -4.8px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 0, NULL, '2023-11-10 16:03:09', '2023-11-14 12:07:02', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '139903', NULL, NULL),
(135, 'admin', 1, 'Luxury Design Bifold Short Wallets Male Hasp Vintage Purse Coin Pouch Multi-func', 'luxury-design-bifold-short-wallets-male-hasp-vintage-purse-coin-pouch-multi-functional-card-pocket-genuine-leather-men-w', 'physical', '[{\"id\":\"259\",\"position\":1},{\"id\":\"77\",\"position\":2},{\"id\":\"85\",\"position\":3}]', '259', '77', '85', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-10-654e2da6bdb1e.webp\",\"2023-11-10-654e2da6d3f24.webp\",\"2023-11-10-654e2da6e64ff.webp\",\"2023-11-10-654e2da70be5b.webp\",\"2023-11-10-654e2da727386.webp\",\"2023-11-10-654e2da747b96.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-10-654e2da6bdb1e.webp\"},{\"color\":\"556B2F\",\"image_name\":\"2023-11-10-654e2da6d3f24.webp\"},{\"color\":\"FF0000\",\"image_name\":\"2023-11-10-654e2da6e64ff.webp\"},{\"color\":\"8B4513\",\"image_name\":\"2023-11-10-654e2da70be5b.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e2da727386.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e2da747b96.webp\"}]', '2023-11-10-654e2da762dbc.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#556B2F\",\"#FF0000\",\"#8B4513\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":10,\"sku\":\"LDBSWMHVPCPMCPGLMWR-Black\",\"qty\":50},{\"type\":\"DarkOliveGreen\",\"price\":9,\"sku\":\"LDBSWMHVPCPMCPGLMWR-DarkOliveGreen\",\"qty\":50},{\"type\":\"Red\",\"price\":9,\"sku\":\"LDBSWMHVPCPMCPGLMWR-Red\",\"qty\":50},{\"type\":\"SaddleBrown\",\"price\":10,\"sku\":\"LDBSWMHVPCPMCPGLMWR-SaddleBrown\",\"qty\":50}]', 0, 10, 12, '0', 'percent', 'include', '3', 'percent', 200, 1, '<p>&nbsp;</p>\r\n\r\n<p>Genuine Leather Type Cow Leather Interior Interior Slot Pocket,Interior Zipper Pocket,Interior Key Chain Holder,Interior Compartment,Zipper Poucht,Coin Pocket,Passcard Pocket,Note Compartment,Photo Holder,Card Holde</p>\r\n\r\n<p>&nbsp;</p>', 0, NULL, '2023-11-10 16:18:31', '2024-01-16 02:45:32', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '143556', 'All', NULL);
INSERT INTO `products` (`id`, `added_by`, `user_id`, `name`, `slug`, `product_type`, `category_ids`, `category_id`, `sub_category_id`, `sub_sub_category_id`, `brand_id`, `unit`, `min_qty`, `refundable`, `digital_product_type`, `digital_file_ready`, `images`, `color_image`, `thumbnail`, `featured`, `flash_deal`, `video_provider`, `video_url`, `colors`, `variant_product`, `attributes`, `choice_options`, `variation`, `published`, `unit_price`, `purchase_price`, `tax`, `tax_type`, `tax_model`, `discount`, `discount_type`, `current_stock`, `minimum_order_qty`, `details`, `free_shipping`, `attachment`, `created_at`, `updated_at`, `status`, `featured_status`, `meta_title`, `meta_description`, `meta_image`, `request_status`, `denied_note`, `shipping_cost`, `multiply_qty`, `temp_shipping_cost`, `is_shipping_cost_updated`, `code`, `shipping_country`, `origin`) VALUES
(136, 'admin', 1, 'INSMART Oral Irrigator Dental Water Flosser Teeth Whitening Waterproof Portable ', 'insmart-oral-irrigator-dental-water-flosser-teeth-whitening-waterproof-portable-dental-water-jet-floss-300ml-teeth-clean', 'physical', '[{\"id\":\"5\",\"position\":1},{\"id\":\"95\",\"position\":2},{\"id\":\"102\",\"position\":3}]', '5', '95', '102', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-10-654e32b271f94.webp\",\"2023-11-10-654e32b29b362.webp\",\"2023-11-10-654e32b2bec7f.webp\",\"2023-11-10-654e32b2e084c.webp\",\"2023-11-10-654e32b308b68.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-10-654e32b271f94.webp\"},{\"color\":\"ADD8E6\",\"image_name\":\"2023-11-10-654e32b29b362.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e32b2bec7f.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e32b2e084c.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e32b308b68.webp\"}]', '2023-11-10-654e32b3264b0.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#ADD8E6\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":32,\"sku\":\"IOIDWFTWWPDWJF3TC-Black\",\"qty\":1},{\"type\":\"LightBlue\",\"price\":30,\"sku\":\"IOIDWFTWWPDWJF3TC-LightBlue\",\"qty\":0}]', 0, 30, 35, '0', 'percent', 'include', '5', 'percent', 1, 1, '<p>INSMART Oral Irrigator Dental Water Flosser Teeth Whitening Waterproof Portable Dental Water Jet Floss 300ML Teeth Cleaner</p>\r\n\r\n<p>4 or more operating modes: The INSMART Oral Irrigator has 4 or more operating modes, allowing you to customize your teeth cleaning experience. Up to 1199 pulses/min: With up to 1199 pulses per minute, the INSMART Oral Irrigator provides powerful and efficient teeth cleaning. 5 or more nozzles: The INSMART Oral Irrigator comes with 5 or more nozzles, making it easy to share with family members or replace when needed.</p>', 0, NULL, '2023-11-10 16:40:03', '2023-11-15 23:58:04', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '188496', NULL, NULL),
(137, 'admin', 1, 'Baby Supplementary Food Grinder Six Piece Set Baby Cartoon Conditioning Grinding', 'baby-supplementary-food-grinder-six-piece-set-baby-cartoon-conditioning-grinding-bowl-4OpSdm', 'physical', '[{\"id\":\"6\",\"position\":1},{\"id\":\"106\",\"position\":2},{\"id\":\"112\",\"position\":3}]', '6', '106', '112', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-10-654e380e434dd.webp\",\"2023-11-10-654e380e502f6.webp\",\"2023-11-10-654e380e63d55.webp\",\"2023-11-10-654e380e75470.webp\",\"2023-11-10-654e380e84161.webp\"]', '[{\"color\":\"0000FF\",\"image_name\":\"2023-11-10-654e380e434dd.webp\"},{\"color\":\"FFFF00\",\"image_name\":\"2023-11-10-654e380e502f6.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e380e63d55.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e380e75470.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e380e84161.webp\"}]', '2023-11-10-654e380e964b0.webp', NULL, NULL, 'youtube', NULL, '[\"#0000FF\",\"#FFFF00\"]', 0, 'null', '[]', '[{\"type\":\"Blue\",\"price\":9,\"sku\":\"BSFGSPSBCCGB-Blue\",\"qty\":100},{\"type\":\"Yellow\",\"price\":8,\"sku\":\"BSFGSPSBCCGB-Yellow\",\"qty\":100}]', 0, 9, 10, '0', 'percent', 'include', '4.99', 'percent', 200, 1, '<p>Baby Supplementary Food Grinder Six Piece Set Baby Cartoon Conditioning Grinding Bowl</p>\r\n\r\n<p>Description<br />\r\n&bull; Six-piece set: This set includes six different types of food, making it a versatile and complete solution for your baby&#39;s meals.</p>\r\n\r\n<p>&bull; Cartoon design: The cute cartoon design of the grinding bowl will make mealtime more fun for your baby and encourage them to eat more.<br />\r\n&bull; Easy to use: The simple design of the food grinder makes it easy to use, even for parents who are busy or tired.</p>\r\n\r\n<p>&bull; Made of safe materials: The food grinder is made of high-quality plastic that is safe for your baby to use and easy to clean.</p>', 0, NULL, '2023-11-10 17:02:54', '2023-11-10 17:02:54', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '163212', NULL, NULL),
(138, 'admin', 1, 'Wuli Home Lazy Living Room Sofa Nordic Style Lazy Leisure Rocking Recliner Light', 'wuli-home-lazy-living-room-sofa-nordic-style-lazy-leisure-rocking-recliner-light-luxury-living-room-balcony-single-sofa-', 'physical', '[{\"id\":\"8\",\"position\":1},{\"id\":\"17\",\"position\":2},{\"id\":\"18\",\"position\":3}]', '8', '17', '18', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-10-654e902c22d7f.webp\",\"2023-11-10-654e902c3b132.webp\",\"2023-11-10-654e902c527b8.webp\",\"2023-11-10-654e902c6c9e7.webp\"]', '[{\"color\":\"FF7F50\",\"image_name\":\"2023-11-10-654e902c22d7f.webp\"},{\"color\":\"DAA520\",\"image_name\":\"2023-11-10-654e902c3b132.webp\"},{\"color\":\"808080\",\"image_name\":\"2023-11-10-654e902c527b8.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e902c6c9e7.webp\"}]', '2023-11-10-654e902c89479.webp', '1', NULL, 'youtube', NULL, '[\"#FF7F50\",\"#DAA520\",\"#808080\"]', 0, 'null', '[]', '[{\"type\":\"Coral\",\"price\":45,\"sku\":\"WHLLRSNSLLRRLLLRBSSC-Coral\",\"qty\":50},{\"type\":\"Goldenrod\",\"price\":44,\"sku\":\"WHLLRSNSLLRRLLLRBSSC-Goldenrod\",\"qty\":50},{\"type\":\"Gray\",\"price\":43,\"sku\":\"WHLLRSNSLLRRLLLRBSSC-Gray\",\"qty\":50}]', 0, 45, 50, '0', 'percent', 'include', '3', 'flat', 150, 1, '<p>Wuli Home Lazy Living Room Sofa Nordic Style Lazy Leisure Rocking Recliner Light Luxury Living Room Balcony Single Sofa Chair<br />\r\nCover: Genuine Leather<br />\r\nSize: 95*85*68cm</p>', 0, NULL, '2023-11-10 23:18:52', '2023-11-14 12:05:48', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '167715', NULL, NULL),
(139, 'admin', 1, 'English Learning Small Laptop Toy for Kids. Boys and Girls Computer for Alphabet', 'english-learning-small-laptop-toy-for-kids-boys-and-girls-computer-for-alphabet-abcnumberswordsspellingmathsmusic-MWOxur', 'physical', '[{\"id\":\"7\",\"position\":1},{\"id\":\"122\",\"position\":2},{\"id\":\"128\",\"position\":3}]', '7', '122', '128', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-10-654e928f5d9d5.webp\",\"2023-11-10-654e928f77093.webp\",\"2023-11-10-654e928f91a90.webp\",\"2023-11-10-654e928fabc9e.webp\"]', '[{\"color\":\"0000FF\",\"image_name\":\"2023-11-10-654e928f5d9d5.webp\"},{\"color\":\"FFC0CB\",\"image_name\":\"2023-11-10-654e928f77093.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e928f91a90.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e928fabc9e.webp\"}]', '2023-11-10-654e928fc55d7.webp', NULL, NULL, 'youtube', NULL, '[\"#0000FF\",\"#FFC0CB\"]', 0, 'null', '[]', '[{\"type\":\"Blue\",\"price\":8,\"sku\":\"ELSLTfKBaGCfAA-Blue\",\"qty\":50},{\"type\":\"Pink\",\"price\":7,\"sku\":\"ELSLTfKBaGCfAA-Pink\",\"qty\":50}]', 0, 8, 10, '0', 'percent', 'include', '5', 'percent', 100, 1, '<p>English Learning Small Laptop Toy for Kids. Boys and Girls Computer for Alphabet ABC.Numbers.Words.Spelling.Maths.Music<br />\r\n&nbsp;</p>\r\n\r\n<p>Product Parameters<br />\r\nProduct name: Early Education Learning Machine<br />\r\nProduct color: pink/blue<br />\r\nBattery used: No. 5 battery * 3<br />\r\nApplicable age: 3 years old and above<br />\r\nPackage size:16*4*13cm/6.3*1.57 * 5.11in<br />\r\nProduct size:15.2*12.5*14cm/5.98*4.92 * 5.51in</p>\r\n\r\n<p>NOTES: Due to different monitors and light, color differences cannot be completely avoided</p>', 0, NULL, '2023-11-10 23:29:03', '2023-11-10 23:29:03', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '132902', NULL, NULL),
(140, 'admin', 1, 'ENFASHION Para Mujer OT Buckle Geometry Oval Necklace For Women\'s Jewelry Neckla', 'enfashion-para-mujer-ot-buckle-geometry-oval-necklace-for-womens-jewelry-necklaces-stainless-steel-fashion-trendy-cockta', 'physical', '[{\"id\":\"9\",\"position\":1},{\"id\":\"135\",\"position\":2},{\"id\":\"140\",\"position\":3}]', '9', '135', '140', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-10-654e9843326da.webp\",\"2023-11-10-654e98433eb9b.webp\",\"2023-11-10-654e98434f48b.webp\"]', '[{\"color\":\"FFD700\",\"image_name\":\"2023-11-10-654e9843326da.webp\"},{\"color\":\"C0C0C0\",\"image_name\":\"2023-11-10-654e98433eb9b.webp\"},{\"color\":null,\"image_name\":\"2023-11-10-654e98434f48b.webp\"}]', '2023-11-10-654e98435b742.webp', NULL, NULL, 'youtube', NULL, '[\"#FFD700\",\"#C0C0C0\"]', 0, 'null', '[]', '[{\"type\":\"Gold\",\"price\":18,\"sku\":\"EPMOBGONFWJNSsFTC3-Gold\",\"qty\":100},{\"type\":\"Silver\",\"price\":17,\"sku\":\"EPMOBGONFWJNSsFTC3-Silver\",\"qty\":100}]', 0, 18, 20, '0', 'percent', 'include', '3', 'percent', 200, 1, '<p>ENFASHION Para Mujer OT Buckle Geometry Oval Necklace For Women&#39;s Jewelry Necklaces Stainless steel Fashion Trendy Cocktail 3412<br />\r\n&nbsp;</p>\r\n\r\n<p>MATERIAL<br />\r\nStainless steel</p>\r\n\r\n<p>FEATURES<br />\r\nNickel Free/Lead Free/Chromium-Free/Hypoallergenic</p>', 0, NULL, '2023-11-10 23:53:23', '2023-11-10 23:53:23', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '102926', NULL, NULL),
(141, 'admin', 1, 'Universal Full Car Cover Rain Frost Snow Dust Waterproof Protection Exterior Car', 'universal-full-car-cover-rain-frost-snow-dust-waterproof-protection-exterior-car-protector-covers-anti-uv-outdoor-sun-re', 'physical', '[{\"id\":\"10\",\"position\":1},{\"id\":\"147\",\"position\":2},{\"id\":\"153\",\"position\":3}]', '10', '147', '153', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-11-654e9a38bc6b0.webp\",\"2023-11-11-654e9a38d692f.webp\",\"2023-11-11-654e9a38ebb88.webp\",\"2023-11-14-6553c82237e3c.webp\"]', '[{\"color\":null,\"image_name\":\"2023-11-11-654e9a38bc6b0.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654e9a38d692f.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654e9a38ebb88.webp\"},{\"color\":\"D3D3D3\",\"image_name\":\"2023-11-14-6553c82237e3c.webp\"}]', '2023-11-16-6555ceae1b283.webp', '1', NULL, 'youtube', NULL, '[\"#D3D3D3\"]', 0, 'null', '[]', '[{\"type\":\"LightGrey\",\"price\":21.99,\"sku\":\"UFCCRFSDWPECPCAUOSR-LightGrey\",\"qty\":100}]', 0, 22, 25, '0', 'percent', 'include', '3', 'percent', 100, 1, '<p>Universal Full Car Cover Rain Frost Snow Dust Waterproof Protection Exterior Car Protector Covers Anti UV Outdoor Sun Reflective</p>', 0, NULL, '2023-11-11 00:01:45', '2023-11-16 11:11:26', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '147111', NULL, NULL),
(142, 'admin', 1, 'SOYO AMD Radeon RX5700XT 8GB Gaming Graphics Card GDDR6 Video Memory 256Bit PCIE', 'soyo-amd-radeon-rx5700xt-8gb-gaming-graphics-card-gddr6-video-memory-256bit-pciex16-40-for-desktop-computer-video-cards-', 'physical', '[{\"id\":\"11\",\"position\":1},{\"id\":\"164\",\"position\":2},{\"id\":\"168\",\"position\":3}]', '11', '164', '168', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-11-654f64b9acf18.webp\",\"2023-11-11-654f64b9bdb02.webp\",\"2023-11-11-654f64b9ce891.webp\",\"2023-11-11-654f64b9dc1fd.webp\",\"2023-11-11-654f64b9f06de.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-11-654f64b9acf18.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654f64b9bdb02.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654f64b9ce891.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654f64b9dc1fd.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654f64b9f06de.webp\"}]', '2023-11-11-654f64ba11133.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":118,\"sku\":\"SARR8GGCGVM2P4fDCVC-Black\",\"qty\":100}]', 0, 118, 120, '0', 'percent', 'include', '3', 'percent', 100, 1, '<p>SOYO AMD Radeon RX5700XT 8GB Gaming Graphics Card GDDR6 Video Memory 256Bit PCIEx16 4.0 for Desktop Computer Video Cards<br />\r\n&nbsp;</p>\r\n\r\n<p><strong>Product Description：</strong></p>\r\n\r\n<p><strong>* Stream processor: 2560</strong></p>\r\n\r\n<p><strong>* Core frequency: 1755-1905MHZ</strong></p>\r\n\r\n<p><strong>* Memory frequency: 1750MHZ</strong></p>\r\n\r\n<p><strong>* Core technology: 7 nm</strong></p>\r\n\r\n<p><strong>* Memory capacity: 8GB</strong></p>\r\n\r\n<p>&nbsp;</p>', 0, NULL, '2023-11-11 14:25:46', '2023-12-02 11:55:38', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '112483', '[\"AF\",\"AX\",\"AL\",\"DZ\",\"AS\",\"AD\",\"AO\",\"AI\",\"AQ\",\"AG\",\"AR\",\"AM\",\"AW\",\"AU\",\"AT\",\"AZ\",\"BS\",\"BH\",\"BD\",\"BB\",\"BY\",\"BE\",\"BZ\",\"BJ\",\"BM\",\"BT\",\"BO\",\"BA\",\"BW\",\"BV\",\"BR\",\"IO\",\"BN\",\"BG\",\"BF\",\"BI\",\"KH\",\"CM\",\"CA\",\"CV\",\"KY\",\"CF\",\"TD\",\"CL\",\"CN\",\"CX\",\"CC\",\"CO\",\"KM\",\"CG\",\"CD\",\"CK\",\"CR\",\"CI\",\"HR\",\"CU\",\"CY\",\"CZ\",\"DK\",\"DJ\",\"DM\",\"DO\",\"EC\",\"EG\",\"SV\",\"GQ\",\"ER\",\"EE\",\"ET\",\"FK\",\"FO\",\"FJ\",\"FI\",\"FR\",\"GF\",\"PF\",\"TF\",\"GA\",\"GM\",\"GE\",\"DE\",\"GH\",\"GI\",\"GR\",\"GL\",\"GD\",\"GP\",\"GU\",\"GT\",\"GG\",\"GN\",\"GW\",\"GY\",\"HT\",\"HM\",\"VA\",\"HN\",\"HK\",\"HU\",\"IS\",\"IN\",\"ID\",\"IR\",\"IQ\",\"IE\",\"IM\",\"IL\",\"IT\",\"JM\",\"JP\",\"JE\",\"JO\",\"KZ\",\"KE\",\"KI\",\"KP\",\"KR\",\"KW\",\"KG\",\"LA\",\"LV\",\"LB\",\"LS\",\"LR\",\"LY\",\"LI\",\"LT\",\"LU\",\"MO\",\"MK\",\"MG\",\"MW\",\"MY\",\"MV\",\"ML\",\"MT\",\"MH\",\"MQ\",\"MR\",\"MU\",\"YT\",\"MX\",\"FM\",\"MD\",\"MC\",\"MN\",\"MS\",\"MA\",\"MZ\",\"MM\",\"NA\",\"NR\",\"NP\",\"NL\",\"AN\",\"NC\",\"NZ\",\"NI\",\"NE\",\"NG\",\"NU\",\"NF\",\"MP\",\"NO\",\"OM\",\"PK\",\"PW\",\"PS\",\"PA\",\"PG\",\"PY\",\"PE\",\"PH\",\"PN\",\"PL\",\"PT\",\"PR\",\"QA\",\"RE\",\"RO\",\"RU\",\"RW\",\"SH\",\"KN\",\"LC\",\"PM\",\"VC\",\"WS\",\"SM\",\"ST\",\"SA\",\"SN\",\"CS\",\"SC\",\"SL\",\"SG\",\"SK\",\"SI\",\"SB\",\"SO\",\"ZA\",\"GS\",\"ES\",\"LK\",\"SD\",\"SR\",\"SJ\",\"SZ\",\"SE\",\"CH\",\"SY\",\"TW\",\"TJ\",\"TZ\",\"TH\",\"TL\",\"TG\",\"TK\",\"TO\",\"TT\",\"TN\",\"TR\",\"TM\",\"TC\",\"TV\",\"UG\",\"UA\",\"AE\",\"GB\",\"US\",\"UM\",\"UY\",\"UZ\",\"VU\",\"VE\",\"VN\",\"VG\",\"VI\",\"WF\",\"EH\",\"YE\",\"ZM\",\"ZW\"]', NULL),
(143, 'admin', 1, 'Leather Pants Mens Stretch Slim-Fit Winter Fleece-Lined Thickened Riding Tight F', 'leather-pants-mens-stretch-slim-fit-winter-fleece-lined-thickened-riding-tight-feet-warm-man-leather-motorcycle-pants-wa', 'physical', '[{\"id\":\"3\",\"position\":1},{\"id\":\"42\",\"position\":2},{\"id\":\"52\",\"position\":3}]', '3', '42', '52', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-11-654f6aba8579f.webp\",\"2023-11-11-654f6aba9f422.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-11-654f6aba8579f.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654f6aba9f422.webp\"}]', '2023-11-11-654f6abab20c2.webp', '1', NULL, 'youtube', NULL, '[\"#000000\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"28\",\"  29\",\"  30\",\"  31\",\"  32\",\"  33\",\"  34\",\"  36\",\"  37\",\"  38\",\"  39\",\"  40\"]}]', '[{\"type\":\"Black-28\",\"price\":30,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-28\",\"qty\":49},{\"type\":\"Black-29\",\"price\":31,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-29\",\"qty\":50},{\"type\":\"Black-30\",\"price\":29,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-30\",\"qty\":50},{\"type\":\"Black-31\",\"price\":30,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-31\",\"qty\":50},{\"type\":\"Black-32\",\"price\":30,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-32\",\"qty\":50},{\"type\":\"Black-33\",\"price\":29,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-33\",\"qty\":50},{\"type\":\"Black-34\",\"price\":28,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-34\",\"qty\":50},{\"type\":\"Black-36\",\"price\":30,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-36\",\"qty\":50},{\"type\":\"Black-37\",\"price\":31,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-37\",\"qty\":50},{\"type\":\"Black-38\",\"price\":30,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-38\",\"qty\":50},{\"type\":\"Black-39\",\"price\":29,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-39\",\"qty\":50},{\"type\":\"Black-40\",\"price\":30,\"sku\":\"LPMSSWFTRTFWMLMPW-Black-40\",\"qty\":50}]', 0, 30, 35, '0', 'percent', 'include', '3', 'percent', 599, 1, '<p>Leather Pants Mens Stretch Slim-Fit Winter Fleece-Lined Thickened Riding Tight Feet Warm Man Leather Motorcycle Pants Waterproof</p>', 0, NULL, '2023-11-11 14:51:22', '2024-01-22 14:25:01', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '162297', '[\"AF\",\"AX\",\"AL\",\"DZ\",\"AS\",\"AD\",\"AO\",\"AI\",\"AQ\",\"AG\",\"AR\",\"AM\",\"AW\",\"AU\",\"AT\",\"AZ\",\"BS\",\"BH\",\"BD\",\"BB\",\"BY\",\"BE\",\"BZ\",\"BJ\",\"BM\",\"BT\",\"BO\",\"BA\",\"BW\",\"BV\",\"BR\",\"IO\",\"BN\",\"BG\",\"BF\",\"BI\",\"KH\",\"CM\",\"CA\",\"CV\",\"KY\",\"CF\",\"TD\",\"CL\",\"CN\",\"CX\",\"CC\",\"CO\",\"KM\",\"CG\",\"CD\",\"CK\",\"CR\",\"CI\",\"HR\",\"CU\",\"CY\",\"CZ\",\"DK\",\"DJ\",\"DM\",\"DO\",\"EC\",\"EG\",\"SV\",\"GQ\",\"ER\",\"EE\",\"ET\",\"FK\",\"FO\",\"FJ\",\"FI\",\"FR\",\"GF\",\"PF\",\"TF\",\"GA\",\"GM\",\"GE\",\"DE\",\"GH\",\"GI\",\"GR\",\"GL\",\"GD\",\"GP\",\"GU\",\"GT\",\"GG\",\"GN\",\"GW\",\"GY\",\"HT\",\"HM\",\"VA\",\"HN\",\"HK\",\"HU\",\"IS\",\"IN\",\"ID\",\"IR\",\"IQ\",\"IE\",\"IM\",\"IL\",\"IT\",\"JM\",\"JP\",\"JE\",\"JO\",\"KZ\",\"KE\",\"KI\",\"KP\",\"KR\",\"KW\",\"KG\",\"LA\",\"LV\",\"LB\",\"LS\",\"LR\",\"LY\",\"LI\",\"LT\",\"LU\",\"MO\",\"MK\",\"MG\",\"MW\",\"MY\",\"MV\",\"ML\",\"MT\",\"MH\",\"MQ\",\"MR\",\"MU\",\"YT\",\"MX\",\"FM\",\"MD\",\"MC\",\"MN\",\"MS\",\"MA\",\"MZ\",\"MM\",\"NA\",\"NR\",\"NP\",\"NL\",\"AN\",\"NC\",\"NZ\",\"NI\",\"NE\",\"NG\",\"NU\",\"NF\",\"MP\",\"NO\",\"OM\",\"PK\",\"PW\",\"PS\",\"PA\",\"PG\",\"PY\",\"PE\",\"PH\",\"PN\",\"PL\",\"PT\",\"PR\",\"QA\",\"RE\",\"RO\",\"RU\",\"RW\",\"SH\",\"KN\",\"LC\",\"PM\",\"VC\",\"WS\",\"SM\",\"ST\",\"SA\",\"SN\",\"CS\",\"SC\",\"SL\",\"SG\",\"SK\",\"SI\",\"SB\",\"SO\",\"ZA\",\"GS\",\"ES\",\"LK\",\"SD\",\"SR\",\"SJ\",\"SZ\",\"SE\",\"CH\",\"SY\",\"TW\",\"TJ\",\"TZ\",\"TH\",\"TL\",\"TG\",\"TK\",\"TO\",\"TT\",\"TN\",\"TR\",\"TM\",\"TC\",\"TV\",\"UG\",\"UA\",\"AE\",\"GB\",\"US\",\"UM\",\"UY\",\"UZ\",\"VU\",\"VE\",\"VN\",\"VG\",\"VI\",\"WF\",\"EH\",\"YE\",\"ZM\",\"ZW\"]', NULL),
(144, 'admin', 1, 'Military Canvas Duffle Gym Bag Sports Travel Luggage Handbag Tote Shoulder Bag B', 'military-canvas-duffle-gym-bag-sports-travel-luggage-handbag-tote-shoulder-bag-brown-220-WtNAab', 'physical', '[{\"id\":\"259\",\"position\":1},{\"id\":\"78\",\"position\":2}]', '259', '78', NULL, 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-11-654f769303c0f.webp\",\"2023-11-11-654f7693175d5.webp\"]', '[{\"color\":\"A9A9A9\",\"image_name\":\"2023-11-11-654f769303c0f.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654f7693175d5.webp\"}]', '2023-11-11-654f769327de0.webp', '1', NULL, 'youtube', NULL, '[\"#A9A9A9\"]', 0, 'null', '[]', '[{\"type\":\"DarkGray\",\"price\":18,\"sku\":\"MCDGBSTLHTSBB2-DarkGray\",\"qty\":100}]', 0, 18, 20, '0', 'percent', 'include', '2.99', 'percent', 100, 1, '<p>Features:</p>\r\n\r\n<p>1. High quality： Made with high quality and durable canvas material，lined with polyester cotton cloth.</p>\r\n\r\n<p>2. Simple Design: Main compartment with easy-access U-shaped opening and adopt two-way design zipper, smooth and durable to use.</p>\r\n\r\n<p>3. Multi-function: Can be used as a tote/shoulder bag, or messenger bag with the detachable and adjustable shoulder strap.</p>\r\n\r\n<p>4. Large Capacity: 22&quot; Main compartment stands tall for easy packing your clothes, shoes , umbrella, water bottle, etc.</p>\r\n\r\n<p>5. Occasion: Canvas duffel fits versatile occasions, like daily use, weekend outdoor activities, business trip, overnight trip, camping, hiking, climbing, sports, fishing, etc. Enough room for clothes and traveling necessities.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Specification:</p>\r\n\r\n<p>Material: Canvas</p>\r\n\r\n<p>Closure: Zipper</p>\r\n\r\n<p>Lining: Coated cotton polyester blend</p>\r\n\r\n<p>Color: Brown</p>\r\n\r\n<p>22&quot; Size: 22.0&quot; x 11.&quot; x 10.2&quot; (L x W x H)</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Package Includes:</p>\r\n\r\n<p>1 x Duffle Bag</p>\r\n\r\n<p>&nbsp;</p>', 0, NULL, '2023-11-11 15:41:55', '2024-01-16 02:37:55', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '143144', 'All', NULL),
(145, 'admin', 1, 'Dental Chair Cover Unit PU Leather 4pcs/set Dental Seat Elastic Waterproof Prote', 'dental-chair-cover-unit-pu-leather-4pcsset-dental-seat-elastic-waterproof-protective-protector-dentist-equipme-dentistry', 'physical', '[{\"id\":\"5\",\"position\":1},{\"id\":\"95\",\"position\":2},{\"id\":\"103\",\"position\":3}]', '5', '95', '103', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-11-654f7b5d2fc62.webp\",\"2023-11-11-654f7b5d3eef1.webp\",\"2023-11-11-654f7b5d4ce96.webp\",\"2023-11-11-654f7b5d5bc4d.webp\",\"2023-11-11-654f7b5d6ac68.webp\",\"2023-11-11-654f7b5d790ff.webp\",\"2023-11-11-654f7b5d88cb7.webp\",\"2023-11-11-654f7b5da1570.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-11-654f7b5d2fc62.webp\"},{\"color\":\"0000FF\",\"image_name\":\"2023-11-11-654f7b5d3eef1.webp\"},{\"color\":\"A9A9A9\",\"image_name\":\"2023-11-11-654f7b5d4ce96.webp\"},{\"color\":\"FF8C00\",\"image_name\":\"2023-11-11-654f7b5d5bc4d.webp\"},{\"color\":\"B22222\",\"image_name\":\"2023-11-11-654f7b5d6ac68.webp\"},{\"color\":\"9370DB\",\"image_name\":\"2023-11-11-654f7b5d790ff.webp\"},{\"color\":\"FFC0CB\",\"image_name\":\"2023-11-11-654f7b5d88cb7.webp\"},{\"color\":null,\"image_name\":\"2023-11-11-654f7b5da1570.webp\"}]', '2023-11-11-654f7b5dafdbe.webp', '1', NULL, 'youtube', NULL, '[\"#000000\",\"#0000FF\",\"#A9A9A9\",\"#FF8C00\",\"#B22222\",\"#9370DB\",\"#FFC0CB\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":19,\"sku\":\"DCCUPL4DSEWPPDEDL-Black\",\"qty\":50},{\"type\":\"Blue\",\"price\":18,\"sku\":\"DCCUPL4DSEWPPDEDL-Blue\",\"qty\":50},{\"type\":\"DarkGray\",\"price\":19,\"sku\":\"DCCUPL4DSEWPPDEDL-DarkGray\",\"qty\":50},{\"type\":\"DarkOrange\",\"price\":18,\"sku\":\"DCCUPL4DSEWPPDEDL-DarkOrange\",\"qty\":50},{\"type\":\"FireBrick\",\"price\":19,\"sku\":\"DCCUPL4DSEWPPDEDL-FireBrick\",\"qty\":50},{\"type\":\"MediumPurple\",\"price\":18,\"sku\":\"DCCUPL4DSEWPPDEDL-MediumPurple\",\"qty\":50},{\"type\":\"Pink\",\"price\":17.99,\"sku\":\"DCCUPL4DSEWPPDEDL-Pink\",\"qty\":50}]', 0, 18, 20, '0', 'percent', 'include', '3', 'percent', 350, 1, '<p>Dental Chair Cover Unit PU Leather 4pcs/set Dental Seat Elastic Waterproof Protective Protector Dentist Equipme Dentistry Lab<br />\r\n&nbsp;</p>\r\n\r\n<p>This paragraph for the 4pcs/1set of dental chairs:</p>\r\n\r\n<p>1. A cushion + a doctor chair cushion + a backrest + a pillow</p>\r\n\r\n<p>2. Fabric features: mouth pull elastic, eight elastic tooth chairs for various types of fabric, comfortable skin abrasion, nonpilling, no hanging wire does not fade, and no deformation. The best environmental tooth coverings.</p>\r\n\r\n<p>3. Size: 112CM-118CM</p>\r\n\r\n<p>Packing: 4pcs/1set</p>\r\n\r\n<p>Note !!! Due to the light and screen setting difference, the item&#39;s color may be slightly different from the pictures.</p>\r\n\r\n<p>&nbsp;</p>', 0, NULL, '2023-11-11 16:02:21', '2023-12-02 11:49:41', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '159696', '[\"AF\",\"AX\",\"AL\",\"DZ\",\"AS\",\"AD\",\"AO\",\"AI\",\"AQ\",\"AG\",\"AR\",\"AM\",\"AW\",\"AU\",\"AT\",\"AZ\",\"BS\",\"BH\",\"BD\",\"BB\",\"BY\",\"BE\",\"BZ\",\"BJ\",\"BM\",\"BT\",\"BO\",\"BA\",\"BW\",\"BV\",\"BR\",\"IO\",\"BN\",\"BG\",\"BF\",\"BI\",\"KH\",\"CM\",\"CA\",\"CV\",\"KY\",\"CF\",\"TD\",\"CL\",\"CN\",\"CX\",\"CC\",\"CO\",\"KM\",\"CG\",\"CD\",\"CK\",\"CR\",\"CI\",\"HR\",\"CU\",\"CY\",\"CZ\",\"DK\",\"DJ\",\"DM\",\"DO\",\"EC\",\"EG\",\"SV\",\"GQ\",\"ER\",\"EE\",\"ET\",\"FK\",\"FO\",\"FJ\",\"FI\",\"FR\",\"GF\",\"PF\",\"TF\",\"GA\",\"GM\",\"GE\",\"DE\",\"GH\",\"GI\",\"GR\",\"GL\",\"GD\",\"GP\",\"GU\",\"GT\",\"GG\",\"GN\",\"GW\",\"GY\",\"HT\",\"HM\",\"VA\",\"HN\",\"HK\",\"HU\",\"IS\",\"IN\",\"ID\",\"IR\",\"IQ\",\"IE\",\"IM\",\"IL\",\"IT\",\"JM\",\"JP\",\"JE\",\"JO\",\"KZ\",\"KE\",\"KI\",\"KP\",\"KR\",\"KW\",\"KG\",\"LA\",\"LV\",\"LB\",\"LS\",\"LR\",\"LY\",\"LI\",\"LT\",\"LU\",\"MO\",\"MK\",\"MG\",\"MW\",\"MY\",\"MV\",\"ML\",\"MT\",\"MH\",\"MQ\",\"MR\",\"MU\",\"YT\",\"MX\",\"FM\",\"MD\",\"MC\",\"MN\",\"MS\",\"MA\",\"MZ\",\"MM\",\"NA\",\"NR\",\"NP\",\"NL\",\"AN\",\"NC\",\"NZ\",\"NI\",\"NE\",\"NG\",\"NU\",\"NF\",\"MP\",\"NO\",\"OM\",\"PK\",\"PW\",\"PS\",\"PA\",\"PG\",\"PY\",\"PE\",\"PH\",\"PN\",\"PL\",\"PT\",\"PR\",\"QA\",\"RE\",\"RO\",\"RU\",\"RW\",\"SH\",\"KN\",\"LC\",\"PM\",\"VC\",\"WS\",\"SM\",\"ST\",\"SA\",\"SN\",\"CS\",\"SC\",\"SL\",\"SG\",\"SK\",\"SI\",\"SB\",\"SO\",\"ZA\",\"GS\",\"ES\",\"LK\",\"SD\",\"SR\",\"SJ\",\"SZ\",\"SE\",\"CH\",\"SY\",\"TW\",\"TJ\",\"TZ\",\"TH\",\"TL\",\"TG\",\"TK\",\"TO\",\"TT\",\"TN\",\"TR\",\"TM\",\"TC\",\"TV\",\"UG\",\"UA\",\"AE\",\"GB\",\"US\",\"UM\",\"UY\",\"UZ\",\"VU\",\"VE\",\"VN\",\"VG\",\"VI\",\"WF\",\"EH\",\"YE\",\"ZM\",\"ZW\"]', NULL),
(146, 'admin', 1, 'SheeCute Girls Winter Warm Pants Kids Fleece Lined Leggings for 3-11 Years SCW71', 'sheecute-girls-winter-warm-pants-kids-fleece-lined-leggings-for-3-11-years-scw7101-hQWiSh', 'physical', '[{\"id\":\"6\",\"position\":1},{\"id\":\"107\",\"position\":2},{\"id\":\"115\",\"position\":3}]', '6', '107', '115', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-13-65523e6902a86.webp\",\"2023-11-13-65523e6916693.webp\",\"2023-11-13-65523e69270ce.webp\",\"2023-11-13-65523e6939903.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-13-65523e6902a86.webp\"},{\"color\":\"A52A2A\",\"image_name\":\"2023-11-13-65523e6916693.webp\"},{\"color\":\"FFB6C1\",\"image_name\":\"2023-11-13-65523e69270ce.webp\"},{\"color\":\"800080\",\"image_name\":\"2023-11-13-65523e6939903.webp\"}]', '2023-11-13-65523e6953540.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#A52A2A\",\"#FFB6C1\",\"#800080\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"4years\",\"  5years\",\"  3years\",\"  6years\",\"  8-9years\"]}]', '[{\"type\":\"Black-4years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-Black-4years\",\"qty\":50},{\"type\":\"Black-5years\",\"price\":11,\"sku\":\"SGWWPKFLLf3YS-Black-5years\",\"qty\":50},{\"type\":\"Black-3years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-Black-3years\",\"qty\":50},{\"type\":\"Black-6years\",\"price\":11,\"sku\":\"SGWWPKFLLf3YS-Black-6years\",\"qty\":50},{\"type\":\"Black-8-9years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-Black-8-9years\",\"qty\":50},{\"type\":\"Brown-4years\",\"price\":10,\"sku\":\"SGWWPKFLLf3YS-Brown-4years\",\"qty\":50},{\"type\":\"Brown-5years\",\"price\":10,\"sku\":\"SGWWPKFLLf3YS-Brown-5years\",\"qty\":50},{\"type\":\"Brown-3years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-Brown-3years\",\"qty\":50},{\"type\":\"Brown-6years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-Brown-6years\",\"qty\":50},{\"type\":\"Brown-8-9years\",\"price\":11,\"sku\":\"SGWWPKFLLf3YS-Brown-8-9years\",\"qty\":50},{\"type\":\"LightPink-4years\",\"price\":11,\"sku\":\"SGWWPKFLLf3YS-LightPink-4years\",\"qty\":50},{\"type\":\"LightPink-5years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-LightPink-5years\",\"qty\":50},{\"type\":\"LightPink-3years\",\"price\":10,\"sku\":\"SGWWPKFLLf3YS-LightPink-3years\",\"qty\":50},{\"type\":\"LightPink-6years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-LightPink-6years\",\"qty\":50},{\"type\":\"LightPink-8-9years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-LightPink-8-9years\",\"qty\":50},{\"type\":\"Purple-4years\",\"price\":11,\"sku\":\"SGWWPKFLLf3YS-Purple-4years\",\"qty\":50},{\"type\":\"Purple-5years\",\"price\":10,\"sku\":\"SGWWPKFLLf3YS-Purple-5years\",\"qty\":50},{\"type\":\"Purple-3years\",\"price\":11,\"sku\":\"SGWWPKFLLf3YS-Purple-3years\",\"qty\":50},{\"type\":\"Purple-6years\",\"price\":11,\"sku\":\"SGWWPKFLLf3YS-Purple-6years\",\"qty\":50},{\"type\":\"Purple-8-9years\",\"price\":12,\"sku\":\"SGWWPKFLLf3YS-Purple-8-9years\",\"qty\":50}]', 0, 12, 15, '0', 'percent', 'include', '3', 'percent', 1000, 1, '<p>SheeCute Girls Winter Warm Pants Kids Fleece Lined Leggings for 3-11 Years SCW7101</p>', 0, NULL, '2023-11-13 18:19:05', '2023-12-02 11:56:12', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '101491', '[\"AF\",\"AX\",\"AL\",\"DZ\",\"AS\",\"AD\",\"AO\",\"AI\",\"AQ\",\"AG\",\"AR\",\"AM\",\"AW\",\"AU\",\"AT\",\"AZ\",\"BS\",\"BH\",\"BD\",\"BB\",\"BY\",\"BE\",\"BZ\",\"BJ\",\"BM\",\"BT\",\"BO\",\"BA\",\"BW\",\"BV\",\"BR\",\"IO\",\"BN\",\"BG\",\"BF\",\"BI\",\"KH\",\"CM\",\"CA\",\"CV\",\"KY\",\"CF\",\"TD\",\"CL\",\"CN\",\"CX\",\"CC\",\"CO\",\"KM\",\"CG\",\"CD\",\"CK\",\"CR\",\"CI\",\"HR\",\"CU\",\"CY\",\"CZ\",\"DK\",\"DJ\",\"DM\",\"DO\",\"EC\",\"EG\",\"SV\",\"GQ\",\"ER\",\"EE\",\"ET\",\"FK\",\"FO\",\"FJ\",\"FI\",\"FR\",\"GF\",\"PF\",\"TF\",\"GA\",\"GM\",\"GE\",\"DE\",\"GH\",\"GI\",\"GR\",\"GL\",\"GD\",\"GP\",\"GU\",\"GT\",\"GG\",\"GN\",\"GW\",\"GY\",\"HT\",\"HM\",\"VA\",\"HN\",\"HK\",\"HU\",\"IS\",\"IN\",\"ID\",\"IR\",\"IQ\",\"IE\",\"IM\",\"IL\",\"IT\",\"JM\",\"JP\",\"JE\",\"JO\",\"KZ\",\"KE\",\"KI\",\"KP\",\"KR\",\"KW\",\"KG\",\"LA\",\"LV\",\"LB\",\"LS\",\"LR\",\"LY\",\"LI\",\"LT\",\"LU\",\"MO\",\"MK\",\"MG\",\"MW\",\"MY\",\"MV\",\"ML\",\"MT\",\"MH\",\"MQ\",\"MR\",\"MU\",\"YT\",\"MX\",\"FM\",\"MD\",\"MC\",\"MN\",\"MS\",\"MA\",\"MZ\",\"MM\",\"NA\",\"NR\",\"NP\",\"NL\",\"AN\",\"NC\",\"NZ\",\"NI\",\"NE\",\"NG\",\"NU\",\"NF\",\"MP\",\"NO\",\"OM\",\"PK\",\"PW\",\"PS\",\"PA\",\"PG\",\"PY\",\"PE\",\"PH\",\"PN\",\"PL\",\"PT\",\"PR\",\"QA\",\"RE\",\"RO\",\"RU\",\"RW\",\"SH\",\"KN\",\"LC\",\"PM\",\"VC\",\"WS\",\"SM\",\"ST\",\"SA\",\"SN\",\"CS\",\"SC\",\"SL\",\"SG\",\"SK\",\"SI\",\"SB\",\"SO\",\"ZA\",\"GS\",\"ES\",\"LK\",\"SD\",\"SR\",\"SJ\",\"SZ\",\"SE\",\"CH\",\"SY\",\"TW\",\"TJ\",\"TZ\",\"TH\",\"TL\",\"TG\",\"TK\",\"TO\",\"TT\",\"TN\",\"TR\",\"TM\",\"TC\",\"TV\",\"UG\",\"UA\",\"AE\",\"GB\",\"US\",\"UM\",\"UY\",\"UZ\",\"VU\",\"VE\",\"VN\",\"VG\",\"VI\",\"WF\",\"EH\",\"YE\",\"ZM\",\"ZW\"]', NULL),
(147, 'admin', 1, 'JJ Funny Doll Function Crawling Baby with Battery Operated Laughing Singing Acco', 'jj-funny-doll-function-crawling-baby-with-battery-operated-laughing-singing-accompany-with-your-children-size-105-inches', 'physical', '[{\"id\":\"7\",\"position\":1},{\"id\":\"123\",\"position\":2},{\"id\":\"131\",\"position\":3}]', '7', '123', '131', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-13-655240faad484.webp\",\"2023-11-13-655240fabee3a.webp\",\"2023-11-13-655240fadd5f1.webp\"]', '[{\"color\":\"FF69B4\",\"image_name\":\"2023-11-13-655240faad484.webp\"},{\"color\":\"ADD8E6\",\"image_name\":\"2023-11-13-655240fabee3a.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-655240fadd5f1.webp\"}]', '2023-11-13-655240faf3724.webp', NULL, NULL, 'youtube', NULL, '[\"#FF69B4\",\"#ADD8E6\"]', 0, 'null', '[]', '[{\"type\":\"HotPink\",\"price\":7,\"sku\":\"JFDFCBwBOLSAwYCS1I-HotPink\",\"qty\":99},{\"type\":\"LightBlue\",\"price\":6,\"sku\":\"JFDFCBwBOLSAwYCS1I-LightBlue\",\"qty\":100}]', 0, 7, 8, '0', 'percent', 'include', '3', 'percent', 199, 1, '<p>JJ Funny Doll Function Crawling Baby with Battery Operated Laughing Singing Accompany with Your Children Size 10.5 Inches<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-13 18:30:02', '2023-12-02 11:56:21', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '174949', '[\"AF\",\"AX\",\"AL\",\"DZ\",\"AS\",\"AD\",\"AO\",\"AI\",\"AQ\",\"AG\",\"AR\",\"AM\",\"AW\",\"AU\",\"AT\",\"AZ\",\"BS\",\"BH\",\"BD\",\"BB\",\"BY\",\"BE\",\"BZ\",\"BJ\",\"BM\",\"BT\",\"BO\",\"BA\",\"BW\",\"BV\",\"BR\",\"IO\",\"BN\",\"BG\",\"BF\",\"BI\",\"KH\",\"CM\",\"CA\",\"CV\",\"KY\",\"CF\",\"TD\",\"CL\",\"CN\",\"CX\",\"CC\",\"CO\",\"KM\",\"CG\",\"CD\",\"CK\",\"CR\",\"CI\",\"HR\",\"CU\",\"CY\",\"CZ\",\"DK\",\"DJ\",\"DM\",\"DO\",\"EC\",\"EG\",\"SV\",\"GQ\",\"ER\",\"EE\",\"ET\",\"FK\",\"FO\",\"FJ\",\"FI\",\"FR\",\"GF\",\"PF\",\"TF\",\"GA\",\"GM\",\"GE\",\"DE\",\"GH\",\"GI\",\"GR\",\"GL\",\"GD\",\"GP\",\"GU\",\"GT\",\"GG\",\"GN\",\"GW\",\"GY\",\"HT\",\"HM\",\"VA\",\"HN\",\"HK\",\"HU\",\"IS\",\"IN\",\"ID\",\"IR\",\"IQ\",\"IE\",\"IM\",\"IL\",\"IT\",\"JM\",\"JP\",\"JE\",\"JO\",\"KZ\",\"KE\",\"KI\",\"KP\",\"KR\",\"KW\",\"KG\",\"LA\",\"LV\",\"LB\",\"LS\",\"LR\",\"LY\",\"LI\",\"LT\",\"LU\",\"MO\",\"MK\",\"MG\",\"MW\",\"MY\",\"MV\",\"ML\",\"MT\",\"MH\",\"MQ\",\"MR\",\"MU\",\"YT\",\"MX\",\"FM\",\"MD\",\"MC\",\"MN\",\"MS\",\"MA\",\"MZ\",\"MM\",\"NA\",\"NR\",\"NP\",\"NL\",\"AN\",\"NC\",\"NZ\",\"NI\",\"NE\",\"NG\",\"NU\",\"NF\",\"MP\",\"NO\",\"OM\",\"PK\",\"PW\",\"PS\",\"PA\",\"PG\",\"PY\",\"PE\",\"PH\",\"PN\",\"PL\",\"PT\",\"PR\",\"QA\",\"RE\",\"RO\",\"RU\",\"RW\",\"SH\",\"KN\",\"LC\",\"PM\",\"VC\",\"WS\",\"SM\",\"ST\",\"SA\",\"SN\",\"CS\",\"SC\",\"SL\",\"SG\",\"SK\",\"SI\",\"SB\",\"SO\",\"ZA\",\"GS\",\"ES\",\"LK\",\"SD\",\"SR\",\"SJ\",\"SZ\",\"SE\",\"CH\",\"SY\",\"TW\",\"TJ\",\"TZ\",\"TH\",\"TL\",\"TG\",\"TK\",\"TO\",\"TT\",\"TN\",\"TR\",\"TM\",\"TC\",\"TV\",\"UG\",\"UA\",\"AE\",\"GB\",\"US\",\"UM\",\"UY\",\"UZ\",\"VU\",\"VE\",\"VN\",\"VG\",\"VI\",\"WF\",\"EH\",\"YE\",\"ZM\",\"ZW\"]', NULL),
(148, 'admin', 1, 'OLIXIS, 3 Drawer Mobile Lateral File Cabinet Home Office Printer Stand with Open', 'olixis-3-drawer-mobile-lateral-file-cabinet-home-office-printer-stand-with-open-storage-shelves-black-office-cabinet-U4e', 'physical', '[{\"id\":\"8\",\"position\":1},{\"id\":\"63\",\"position\":2},{\"id\":\"70\",\"position\":3}]', '8', '63', '70', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-13-655244b5ccfea.webp\",\"2023-11-13-655244b5e4aba.webp\",\"2023-11-13-655244b6042b9.webp\",\"2023-11-13-655244b6223cb.webp\",\"2023-11-13-655244b636565.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-13-655244b5ccfea.webp\"},{\"color\":\"BC8F8F\",\"image_name\":\"2023-11-13-655244b5e4aba.webp\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-13-655244b6042b9.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-655244b6223cb.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-655244b636565.webp\"}]', '2023-11-13-655244b64cc33.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#BC8F8F\",\"#FFFFFF\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":55,\"sku\":\"O3DMLFCHOPSwOSSBOC-Black\",\"qty\":100},{\"type\":\"RosyBrown\",\"price\":54,\"sku\":\"O3DMLFCHOPSwOSSBOC-RosyBrown\",\"qty\":100},{\"type\":\"White\",\"price\":52,\"sku\":\"O3DMLFCHOPSwOSSBOC-White\",\"qty\":100}]', 0, 55, 60, '0', 'percent', 'include', '5', 'percent', 300, 1, '<p>OLIXIS, 3 Drawer Mobile Lateral File Cabinet Home Office Printer Stand with Open Storage Shelves, Black, Office Cabinet<br />\r\nLength<br />\r\n15.75&quot;D<br />\r\nWidth<br />\r\n31.3&quot;W<br />\r\nHeight<br />\r\n24.61&quot;H<br />\r\nWith Rollers: Yes<br />\r\nSize<br />\r\n15.75&quot;D x 31.3&quot;W x 24.61&quot;H<br />\r\nMaterial: Wooden</p>', 0, NULL, '2023-11-13 18:45:58', '2023-12-02 11:56:30', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '173420', '[\"AF\",\"AX\",\"AL\",\"DZ\",\"AS\",\"AD\",\"AO\",\"AI\",\"AQ\",\"AG\",\"AR\",\"AM\",\"AW\",\"AU\",\"AT\",\"AZ\",\"BS\",\"BH\",\"BD\",\"BB\",\"BY\",\"BE\",\"BZ\",\"BJ\",\"BM\",\"BT\",\"BO\",\"BA\",\"BW\",\"BV\",\"BR\",\"IO\",\"BN\",\"BG\",\"BF\",\"BI\",\"KH\",\"CM\",\"CA\",\"CV\",\"KY\",\"CF\",\"TD\",\"CL\",\"CN\",\"CX\",\"CC\",\"CO\",\"KM\",\"CG\",\"CD\",\"CK\",\"CR\",\"CI\",\"HR\",\"CU\",\"CY\",\"CZ\",\"DK\",\"DJ\",\"DM\",\"DO\",\"EC\",\"EG\",\"SV\",\"GQ\",\"ER\",\"EE\",\"ET\",\"FK\",\"FO\",\"FJ\",\"FI\",\"FR\",\"GF\",\"PF\",\"TF\",\"GA\",\"GM\",\"GE\",\"DE\",\"GH\",\"GI\",\"GR\",\"GL\",\"GD\",\"GP\",\"GU\",\"GT\",\"GG\",\"GN\",\"GW\",\"GY\",\"HT\",\"HM\",\"VA\",\"HN\",\"HK\",\"HU\",\"IS\",\"IN\",\"ID\",\"IR\",\"IQ\",\"IE\",\"IM\",\"IL\",\"IT\",\"JM\",\"JP\",\"JE\",\"JO\",\"KZ\",\"KE\",\"KI\",\"KP\",\"KR\",\"KW\",\"KG\",\"LA\",\"LV\",\"LB\",\"LS\",\"LR\",\"LY\",\"LI\",\"LT\",\"LU\",\"MO\",\"MK\",\"MG\",\"MW\",\"MY\",\"MV\",\"ML\",\"MT\",\"MH\",\"MQ\",\"MR\",\"MU\",\"YT\",\"MX\",\"FM\",\"MD\",\"MC\",\"MN\",\"MS\",\"MA\",\"MZ\",\"MM\",\"NA\",\"NR\",\"NP\",\"NL\",\"AN\",\"NC\",\"NZ\",\"NI\",\"NE\",\"NG\",\"NU\",\"NF\",\"MP\",\"NO\",\"OM\",\"PK\",\"PW\",\"PS\",\"PA\",\"PG\",\"PY\",\"PE\",\"PH\",\"PN\",\"PL\",\"PT\",\"PR\",\"QA\",\"RE\",\"RO\",\"RU\",\"RW\",\"SH\",\"KN\",\"LC\",\"PM\",\"VC\",\"WS\",\"SM\",\"ST\",\"SA\",\"SN\",\"CS\",\"SC\",\"SL\",\"SG\",\"SK\",\"SI\",\"SB\",\"SO\",\"ZA\",\"GS\",\"ES\",\"LK\",\"SD\",\"SR\",\"SJ\",\"SZ\",\"SE\",\"CH\",\"SY\",\"TW\",\"TJ\",\"TZ\",\"TH\",\"TL\",\"TG\",\"TK\",\"TO\",\"TT\",\"TN\",\"TR\",\"TM\",\"TC\",\"TV\",\"UG\",\"UA\",\"AE\",\"GB\",\"US\",\"UM\",\"UY\",\"UZ\",\"VU\",\"VE\",\"VN\",\"VG\",\"VI\",\"WF\",\"EH\",\"YE\",\"ZM\",\"ZW\"]', NULL),
(149, 'admin', 1, 'LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watche', 'lige-2023-smart-watch-for-men-women-gift-full-touch-screen-sports-fitness-watches-bluetooth-calls-digital-smartwatch-wri', 'physical', '[{\"id\":\"9\",\"position\":1},{\"id\":\"136\",\"position\":2},{\"id\":\"143\",\"position\":3}]', '9', '136', '143', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-13-655248b45e7e3.webp\",\"2023-11-13-655248b47207f.webp\",\"2023-11-13-655248b487e48.webp\",\"2023-11-13-655248b4995af.webp\",\"2023-11-13-655248b4aea0f.webp\",\"2023-11-13-655248b4c9c47.webp\",\"2023-11-13-655248b4de60d.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-13-655248b45e7e3.webp\"},{\"color\":\"696969\",\"image_name\":\"2023-11-13-655248b47207f.webp\"},{\"color\":\"DAA520\",\"image_name\":\"2023-11-13-655248b487e48.webp\"},{\"color\":\"808080\",\"image_name\":\"2023-11-13-655248b4995af.webp\"},{\"color\":\"FFB6C1\",\"image_name\":\"2023-11-13-655248b4aea0f.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-655248b4c9c47.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-655248b4de60d.webp\"}]', '2023-11-13-655248b50227d.webp', '1', NULL, 'youtube', NULL, '[\"#000000\",\"#696969\",\"#DAA520\",\"#808080\",\"#FFB6C1\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":12,\"sku\":\"L2SWFMWGFTSSFWBCDSW-Black\",\"qty\":0},{\"type\":\"DimGray\",\"price\":12,\"sku\":\"L2SWFMWGFTSSFWBCDSW-DimGray\",\"qty\":1},{\"type\":\"Goldenrod\",\"price\":12,\"sku\":\"L2SWFMWGFTSSFWBCDSW-Goldenrod\",\"qty\":1},{\"type\":\"Gray\",\"price\":12,\"sku\":\"L2SWFMWGFTSSFWBCDSW-Gray\",\"qty\":1},{\"type\":\"LightPink\",\"price\":12,\"sku\":\"L2SWFMWGFTSSFWBCDSW-LightPink\",\"qty\":0}]', 0, 12, 15, '5', 'percent', 'include', '0', 'percent', 3, 1, '<p>LIGE 2023 Smart Watch For Men Women Gift Full Touch Screen Sports Fitness Watches Bluetooth Calls Digital Smartwatch Wristwatch<br />\r\n&nbsp;</p>\r\n\r\n<p>&bull; Full Touch Screen :The Lige 2023 smartwatch features a full touch screen that allows for easy and intuitive navigation.</p>\r\n\r\n<p>&bull; Blood Pressure Monitor :With a built-in blood pressure monitor, this smartwatch can help you keep track of your health and fitness levels.</p>\r\n\r\n<p>&bull; Multiple Dials :Choose from a variety of watch faces to customize your Lige 2023 smartwatch to your personal style.</p>\r\n\r\n<p>&bull; Calorie Tracker :Keep track of your daily calorie burn with the Lige 2023 smartwatch&#39;s calorie tracker feature.</p>\r\n\r\n<p>&bull; Full Touch Screen :The watch features a full touch screen that makes it easy to navigate and use all its functions.</p>\r\n\r\n<p>&bull; Blood Pressure Monitor :The watch comes with a blood pressure monitor, allowing you to keep track of your health and fitness levels.</p>\r\n\r\n<p>&bull; Multiple Dials :The watch has multiple dials, allowing you to customize the look and feel of your watch to suit your personal style.<br />\r\n&bull; Calorie Tracker:The watch tracks your calorie intake and expenditure, helping you stay on track with your fitness goals.<br />\r\nProduct parameters<br />\r\nScreen:1.69-inch TFT 240*280<br />\r\nTouch Panel:Full touch screen<br />\r\nBattery：180Mah<br />\r\nApp:FitPro<br />\r\nCharging method：Magnetic charging<br />\r\nWaterproof:IP67</p>', 0, NULL, '2023-11-13 19:03:01', '2024-01-25 11:45:02', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '121615', '[\"AF\",\"AX\",\"AL\",\"DZ\",\"AS\",\"AD\",\"AO\",\"AI\",\"AQ\",\"AG\",\"AR\",\"AM\",\"AW\",\"AU\",\"AT\",\"AZ\",\"BS\",\"BH\",\"BD\",\"BB\",\"BY\",\"BE\",\"BZ\",\"BJ\",\"BM\",\"BT\",\"BO\",\"BA\",\"BW\",\"BV\",\"BR\",\"IO\",\"BN\",\"BG\",\"BF\",\"BI\",\"KH\",\"CM\",\"CA\",\"CV\",\"KY\",\"CF\",\"TD\",\"CL\",\"CN\",\"CX\",\"CC\",\"CO\",\"KM\",\"CG\",\"CD\",\"CK\",\"CR\",\"CI\",\"HR\",\"CU\",\"CY\",\"CZ\",\"DK\",\"DJ\",\"DM\",\"DO\",\"EC\",\"EG\",\"SV\",\"GQ\",\"ER\",\"EE\",\"ET\",\"FK\",\"FO\",\"FJ\",\"FI\",\"FR\",\"GF\",\"PF\",\"TF\",\"GA\",\"GM\",\"GE\",\"DE\",\"GH\",\"GI\",\"GR\",\"GL\",\"GD\",\"GP\",\"GU\",\"GT\",\"GG\",\"GN\",\"GW\",\"GY\",\"HT\",\"HM\",\"VA\",\"HN\",\"HK\",\"HU\",\"IS\",\"IN\",\"ID\",\"IR\",\"IQ\",\"IE\",\"IM\",\"IL\",\"IT\",\"JM\",\"JP\",\"JE\",\"JO\",\"KZ\",\"KE\",\"KI\",\"KP\",\"KR\",\"KW\",\"KG\",\"LA\",\"LV\",\"LB\",\"LS\",\"LR\",\"LY\",\"LI\",\"LT\",\"LU\",\"MO\",\"MK\",\"MG\",\"MW\",\"MY\",\"MV\",\"ML\",\"MT\",\"MH\",\"MQ\",\"MR\",\"MU\",\"YT\",\"MX\",\"FM\",\"MD\",\"MC\",\"MN\",\"MS\",\"MA\",\"MZ\",\"MM\",\"NA\",\"NR\",\"NP\",\"NL\",\"AN\",\"NC\",\"NZ\",\"NI\",\"NE\",\"NG\",\"NU\",\"NF\",\"MP\",\"NO\",\"OM\",\"PK\",\"PW\",\"PS\",\"PA\",\"PG\",\"PY\",\"PE\",\"PH\",\"PN\",\"PL\",\"PT\",\"PR\",\"QA\",\"RE\",\"RO\",\"RU\",\"RW\",\"SH\",\"KN\",\"LC\",\"PM\",\"VC\",\"WS\",\"SM\",\"ST\",\"SA\",\"SN\",\"CS\",\"SC\",\"SL\",\"SG\",\"SK\",\"SI\",\"SB\",\"SO\",\"ZA\",\"GS\",\"ES\",\"LK\",\"SD\",\"SR\",\"SJ\",\"SZ\",\"SE\",\"CH\",\"SY\",\"TW\",\"TJ\",\"TZ\",\"TH\",\"TL\",\"TG\",\"TK\",\"TO\",\"TT\",\"TN\",\"TR\",\"TM\",\"TC\",\"TV\",\"UG\",\"UA\",\"AE\",\"GB\",\"US\",\"UM\",\"UY\",\"UZ\",\"VU\",\"VE\",\"VN\",\"VG\",\"VI\",\"WF\",\"EH\",\"YE\",\"ZM\",\"ZW\"]', NULL),
(150, 'admin', 1, 'QUICKLYNKS T31 Car Full OBD2/EOBD Scanner Check Auto Engine System Diagnostic To', 'quicklynks-t31-car-full-obd2eobd-scanner-check-auto-engine-system-diagnostic-tools-automotive-professional-code-reader-s', 'physical', '[{\"id\":\"10\",\"position\":1},{\"id\":\"148\",\"position\":2},{\"id\":\"156\",\"position\":3}]', '10', '148', '156', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-13-65528b7257193.webp\",\"2023-11-13-65528b7266856.webp\",\"2023-11-13-65528b727a9f5.webp\",\"2023-11-13-65528b7293353.webp\",\"2023-11-13-65528b72a9b97.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-13-65528b7257193.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-65528b7266856.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-65528b727a9f5.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-65528b7293353.webp\"},{\"color\":null,\"image_name\":\"2023-11-13-65528b72a9b97.webp\"}]', '2023-11-13-65528b72be8df.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":15,\"sku\":\"QTCFOSCAESDTAPCRS-Black\",\"qty\":100}]', 0, 15, 20, '0', 'percent', 'include', '5', 'percent', 100, 1, '<p>QUICKLYNKS T31 Car Full OBD2/EOBD Scanner Check Auto Engine System Diagnostic Tools Automotive Professional Code Reader Scanner</p>', 0, NULL, '2023-11-13 23:47:46', '2023-12-02 11:56:50', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '186231', '[\"AF\",\"AX\",\"AL\",\"DZ\",\"AS\",\"AD\",\"AO\",\"AI\",\"AQ\",\"AG\",\"AR\",\"AM\",\"AW\",\"AU\",\"AT\",\"AZ\",\"BS\",\"BH\",\"BD\",\"BB\",\"BY\",\"BE\",\"BZ\",\"BJ\",\"BM\",\"BT\",\"BO\",\"BA\",\"BW\",\"BV\",\"BR\",\"IO\",\"BN\",\"BG\",\"BF\",\"BI\",\"KH\",\"CM\",\"CA\",\"CV\",\"KY\",\"CF\",\"TD\",\"CL\",\"CN\",\"CX\",\"CC\",\"CO\",\"KM\",\"CG\",\"CD\",\"CK\",\"CR\",\"CI\",\"HR\",\"CU\",\"CY\",\"CZ\",\"DK\",\"DJ\",\"DM\",\"DO\",\"EC\",\"EG\",\"SV\",\"GQ\",\"ER\",\"EE\",\"ET\",\"FK\",\"FO\",\"FJ\",\"FI\",\"FR\",\"GF\",\"PF\",\"TF\",\"GA\",\"GM\",\"GE\",\"DE\",\"GH\",\"GI\",\"GR\",\"GL\",\"GD\",\"GP\",\"GU\",\"GT\",\"GG\",\"GN\",\"GW\",\"GY\",\"HT\",\"HM\",\"VA\",\"HN\",\"HK\",\"HU\",\"IS\",\"IN\",\"ID\",\"IR\",\"IQ\",\"IE\",\"IM\",\"IL\",\"IT\",\"JM\",\"JP\",\"JE\",\"JO\",\"KZ\",\"KE\",\"KI\",\"KP\",\"KR\",\"KW\",\"KG\",\"LA\",\"LV\",\"LB\",\"LS\",\"LR\",\"LY\",\"LI\",\"LT\",\"LU\",\"MO\",\"MK\",\"MG\",\"MW\",\"MY\",\"MV\",\"ML\",\"MT\",\"MH\",\"MQ\",\"MR\",\"MU\",\"YT\",\"MX\",\"FM\",\"MD\",\"MC\",\"MN\",\"MS\",\"MA\",\"MZ\",\"MM\",\"NA\",\"NR\",\"NP\",\"NL\",\"AN\",\"NC\",\"NZ\",\"NI\",\"NE\",\"NG\",\"NU\",\"NF\",\"MP\",\"NO\",\"OM\",\"PK\",\"PW\",\"PS\",\"PA\",\"PG\",\"PY\",\"PE\",\"PH\",\"PN\",\"PL\",\"PT\",\"PR\",\"QA\",\"RE\",\"RO\",\"RU\",\"RW\",\"SH\",\"KN\",\"LC\",\"PM\",\"VC\",\"WS\",\"SM\",\"ST\",\"SA\",\"SN\",\"CS\",\"SC\",\"SL\",\"SG\",\"SK\",\"SI\",\"SB\",\"SO\",\"ZA\",\"GS\",\"ES\",\"LK\",\"SD\",\"SR\",\"SJ\",\"SZ\",\"SE\",\"CH\",\"SY\",\"TW\",\"TJ\",\"TZ\",\"TH\",\"TL\",\"TG\",\"TK\",\"TO\",\"TT\",\"TN\",\"TR\",\"TM\",\"TC\",\"TV\",\"UG\",\"UA\",\"AE\",\"GB\",\"US\",\"UM\",\"UY\",\"UZ\",\"VU\",\"VE\",\"VN\",\"VG\",\"VI\",\"WF\",\"EH\",\"YE\",\"ZM\",\"ZW\"]', NULL),
(151, 'admin', 1, '2023 Global Version New PAD 6 PRO Tablet Android12 11 Inch 16GB 1T 5G Dual SIM P', '2023-global-version-new-pad-6-pro-tablet-android12-11-inch-16gb-1t-5g-dual-sim-phone-call-gps-bluetooth-wifi-google-tabl', 'physical', '[{\"id\":\"11\",\"position\":1},{\"id\":\"165\",\"position\":2},{\"id\":\"172\",\"position\":3}]', '11', '165', '172', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-14-65528ef8ba5ba.webp\",\"2023-11-14-65528ef8cbe9e.webp\",\"2023-11-14-65528ef8e2fa2.webp\",\"2023-11-14-65528ef902d4d.webp\",\"2023-11-14-65528ef91d758.webp\",\"2023-11-14-65528ef93293a.webp\"]', '[{\"color\":\"0000FF\",\"image_name\":\"2023-11-14-65528ef8ba5ba.webp\"},{\"color\":\"808080\",\"image_name\":\"2023-11-14-65528ef8cbe9e.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-65528ef8e2fa2.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-65528ef902d4d.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-65528ef91d758.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-65528ef93293a.webp\"}]', '2023-11-14-65528ef945c39.webp', NULL, NULL, 'youtube', NULL, '[\"#0000FF\",\"#808080\"]', 0, 'null', '[]', '[{\"type\":\"Blue\",\"price\":92,\"sku\":\"2GVNP6PTA1I115DSPCGBWGTP-Blue\",\"qty\":99},{\"type\":\"Gray\",\"price\":90,\"sku\":\"2GVNP6PTA1I115DSPCGBWGTP-Gray\",\"qty\":100}]', 0, 92, 100, '0', 'percent', 'include', '5', 'percent', 199, 49, '<p>2023 Global Version New PAD 6 PRO Tablet Android12 11 Inch 16GB 1T 5G Dual SIM Phone Call GPS Bluetooth WiFi Google Tablet PC<br />\r\n<br />\r\n<strong>Specification:</strong><br />\r\nModel No.: Pad 6 Pro<br />\r\nCPU: Snapdragon870 Deca Core (Latest 10 Core)<br />\r\nSIM/TF: 2 SIM Card Slots (Nano SIM) + 1 TF Card Slots (Maximum support extension 128GB)<br />\r\nScreen: 11 Inch 4K Screen<br />\r\nResolution :2560*1600<br />\r\nCamera: Front Camera 16MP+ Rear Camera 32MP<br />\r\nMemory: 16GB RAM+1T ROM/12GB RAM+512GB/ ROM 6GB RAM+128GB ROM<br />\r\nSystem: Android 12 System<br />\r\nBattery: 10000mAh High Density Lithium-ion battery<br />\r\nUnique Back Cover: Hot Bend 3D Plating Gradient Glass Back Cover. It is art, it is also technology!<br />\r\nNet-Work: GSM850/900/1800/1900MHz, 3G: WCDMA850/1900/2100MHz, 4G,5G<br />\r\nVibration:Support<br />\r\nMulti Media: MP3/MP4/3GP/FM Radio/Bluetooth<br />\r\nMulti Function: Full screen, Face recognition,Screen finger print, Dual SIM, Wifi, GPS, Gravity Sensor, Alarm ,<br />\r\nCalendar,Calculator,Audio recorder ,Video recorder, WAP/MMS/GPR, Image viewer,E-Book,World clock<br />\r\nLanguages: Multi-language support<br />\r\nThe Tablet support &nbsp;T-mobile,AT&amp;T,Straight Talk,Cricket Wireless,Google Project Fi,Lycamobile,MetroPCS ,MintMobile, does not support the Telecom CDMA network. (For example USA &nbsp;operators:Verizon,Sprint,U.S Cellular,Boost Mobile,FreedomPop,Ting)</p>', 0, NULL, '2023-11-14 00:02:49', '2024-01-13 00:08:45', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '157210', 'All', NULL);
INSERT INTO `products` (`id`, `added_by`, `user_id`, `name`, `slug`, `product_type`, `category_ids`, `category_id`, `sub_category_id`, `sub_sub_category_id`, `brand_id`, `unit`, `min_qty`, `refundable`, `digital_product_type`, `digital_file_ready`, `images`, `color_image`, `thumbnail`, `featured`, `flash_deal`, `video_provider`, `video_url`, `colors`, `variant_product`, `attributes`, `choice_options`, `variation`, `published`, `unit_price`, `purchase_price`, `tax`, `tax_type`, `tax_model`, `discount`, `discount_type`, `current_stock`, `minimum_order_qty`, `details`, `free_shipping`, `attachment`, `created_at`, `updated_at`, `status`, `featured_status`, `meta_title`, `meta_description`, `meta_image`, `request_status`, `denied_note`, `shipping_cost`, `multiply_qty`, `temp_shipping_cost`, `is_shipping_cost_updated`, `code`, `shipping_country`, `origin`) VALUES
(152, 'seller', 1, 'New arrived 2023 Men Winter Leather Jacket Lapel Fleece Motor Biker Leather Jack', 'new-arrived-2023-men-winter-leather-jacket-lapel-fleece-motor-biker-leather-jacket-men-business-casual-long-faux-leather', 'physical', '[{\"id\":\"3\",\"position\":1},{\"id\":\"43\",\"position\":2},{\"id\":\"56\",\"position\":3}]', '3', '43', '56', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-14-6553cabcd978b.webp\",\"2023-11-14-6553cabcea667.webp\",\"2023-11-14-6553cabd11081.webp\",\"2023-11-14-6553cabd2077e.webp\",\"2023-11-14-6553cabd39b03.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-14-6553cabcd978b.webp\"},{\"color\":\"A52A2A\",\"image_name\":\"2023-11-14-6553cabcea667.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553cabd11081.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553cabd2077e.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553cabd39b03.webp\"}]', '2023-11-14-6553cabd4d678.webp', '1', NULL, 'youtube', NULL, '[\"#000000\",\"#A52A2A\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"S\",\"  M\",\"  L\",\"  XL\"]}]', '[{\"type\":\"Black-S\",\"price\":44,\"sku\":\"Na2MWLJLFMBLJ-Black-S\",\"qty\":100},{\"type\":\"Black-M\",\"price\":45,\"sku\":\"Na2MWLJLFMBLJ-Black-M\",\"qty\":100},{\"type\":\"Black-L\",\"price\":45,\"sku\":\"Na2MWLJLFMBLJ-Black-L\",\"qty\":100},{\"type\":\"Black-XL\",\"price\":45,\"sku\":\"Na2MWLJLFMBLJ-Black-XL\",\"qty\":100},{\"type\":\"Brown-S\",\"price\":43,\"sku\":\"Na2MWLJLFMBLJ-Brown-S\",\"qty\":100},{\"type\":\"Brown-M\",\"price\":44,\"sku\":\"Na2MWLJLFMBLJ-Brown-M\",\"qty\":100},{\"type\":\"Brown-L\",\"price\":45,\"sku\":\"Na2MWLJLFMBLJ-Brown-L\",\"qty\":100},{\"type\":\"Brown-XL\",\"price\":45,\"sku\":\"Na2MWLJLFMBLJ-Brown-XL\",\"qty\":100}]', 0, 45, 50, '0', 'percent', 'include', '5', 'percent', 800, 1, '<p>New arrived 2023 Men Winter Leather Jacket Lapel Fleece Motor Biker Leather Jacket Men Business Casual Long Faux Leather Coats</p>', 0, NULL, '2023-11-14 22:30:05', '2023-11-15 23:55:00', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '154960', NULL, NULL),
(153, 'seller', 1, 'Neck Massager Electric Red Light Therapy Cervicales Vibrator Muscle Relax Should', 'neck-massager-electric-red-light-therapy-cervicales-vibrator-muscle-relax-shoulder-massage-gun-chiropractic-fascia-gun-n', 'physical', '[{\"id\":\"5\",\"position\":1},{\"id\":\"189\",\"position\":2},{\"id\":\"212\",\"position\":3}]', '5', '189', '212', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-14-6553d1310f3c4.webp\",\"2023-11-14-6553d13126020.webp\",\"2023-11-14-6553d13138cef.webp\",\"2023-11-14-6553d1314bd0b.webp\"]', '[{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-14-6553d1310f3c4.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553d13126020.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553d13138cef.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553d1314bd0b.webp\"}]', '2023-11-14-6553d1315d4e7.webp', NULL, NULL, 'youtube', NULL, '[\"#FFFFFF\"]', 0, 'null', '[]', '[{\"type\":\"White\",\"price\":55,\"sku\":\"NMERLTCVMRSMGCFGN-White\",\"qty\":50}]', 0, 55, 60, '0', 'percent', 'include', '5', 'percent', 50, 1, '<p>Neck Massager Electric Red Light Therapy Cervicales Vibrator Muscle Relax Shoulder Massage Gun Chiropractic Fascia Gun New</p>', 0, NULL, '2023-11-14 22:57:37', '2023-11-14 23:23:55', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '154486', NULL, NULL),
(154, 'seller', 1, 'EVA Baby Wet Wipes Bag Leaf Pattern Cleaning Wipes Carrying Case Reusable Eco-fr', 'eva-baby-wet-wipes-bag-leaf-pattern-cleaning-wipes-carrying-case-reusable-eco-friendly-flip-cover-tissue-box-infant-supp', 'physical', '[{\"id\":\"6\",\"position\":1},{\"id\":\"108\",\"position\":2},{\"id\":\"118\",\"position\":3}]', '6', '108', '118', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-14-6553d3bb57426.webp\",\"2023-11-14-6553d3bb6a407.webp\",\"2023-11-14-6553d3bb7bcee.webp\",\"2023-11-14-6553d3bb93d6f.webp\",\"2023-11-14-6553d3bba88c8.webp\",\"2023-11-14-6553d3bbbb0e2.webp\"]', '[{\"color\":\"A9A9A9\",\"image_name\":\"2023-11-14-6553d3bb57426.webp\"},{\"color\":\"ADD8E6\",\"image_name\":\"2023-11-14-6553d3bb6a407.webp\"},{\"color\":\"FFC0CB\",\"image_name\":\"2023-11-14-6553d3bb7bcee.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553d3bb93d6f.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553d3bba88c8.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553d3bbbb0e2.webp\"}]', '2023-11-14-6553d3bbd043e.webp', '1', NULL, 'youtube', NULL, '[\"#A9A9A9\",\"#ADD8E6\",\"#FFC0CB\"]', 0, 'null', '[]', '[{\"type\":\"DarkGray\",\"price\":2,\"sku\":\"EBWWBLPCWCCREFCTBIS-DarkGray\",\"qty\":0},{\"type\":\"LightBlue\",\"price\":3,\"sku\":\"EBWWBLPCWCCREFCTBIS-LightBlue\",\"qty\":1},{\"type\":\"Pink\",\"price\":3,\"sku\":\"EBWWBLPCWCCREFCTBIS-Pink\",\"qty\":1}]', 0, 3, 4, '0', 'percent', 'include', '2', 'percent', 2, 1, '<p>✿ Premium Quality Bed Pad - highly absorbent soft lining keeps moisture away from baby&#39;s skin, breathable Leakproof EVA compartment on the bottom prevents liquid from seeping through.</p>\r\n\r\n<p>✿ More Economical and Hygienic - Reusable &amp; Washable and Do Not Fade, each baby changing pad features a little built band for convenient hanging..</p>\r\n\r\n<p>✿ Great for At Bed or On The Go - The portable changing pad can be used to protect the bed surfaces, should your baby sleep without a diaper. It can also folded so you can change your baby&rsquo;s diaper anywhere.</p>\r\n\r\n<p>✿ Fluorescent Free - There is No Harmful Chemicals to irritate the baby&#39;s skin. This makes our liners a perfect partner for your infant with sensitive skin.</p>\r\n\r\n<p>【Patterned Mat Size】Size of 70*50 CM, lovely patterned diaper changing pad protects your baby from dirty surfaces and your baby will love resting on this changing station.</p>', 0, NULL, '2023-11-14 23:08:27', '2023-11-26 00:09:42', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '187256', NULL, NULL),
(155, 'seller', 1, 'BeauToday Chunky Sneakers Women Mesh Leather Platform Shoes Mixed Colors Lace-Up', 'beautoday-chunky-sneakers-women-mesh-leather-platform-shoes-mixed-colors-lace-up-lady-trendy-trainers-thick-sole-handmad', 'physical', '[{\"id\":\"4\",\"position\":1},{\"id\":\"237\",\"position\":2},{\"id\":\"89\",\"position\":3}]', '4', '237', '89', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-14-6553da2de0aa3.webp\",\"2023-11-14-6553da2df1ac3.webp\",\"2023-11-14-6553da2e0be59.webp\",\"2023-11-14-6553da2e29bf3.webp\",\"2023-11-14-6553da2e38801.webp\"]', '[{\"color\":\"F5F5DC\",\"image_name\":\"2023-11-14-6553da2de0aa3.webp\"},{\"color\":\"A52A2A\",\"image_name\":\"2023-11-14-6553da2df1ac3.webp\"},{\"color\":\"808080\",\"image_name\":\"2023-11-14-6553da2e0be59.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553da2e29bf3.webp\"},{\"color\":null,\"image_name\":\"2023-11-14-6553da2e38801.webp\"}]', '2023-11-14-6553da2e55830.webp', '1', NULL, 'youtube', NULL, '[\"#F5F5DC\",\"#A52A2A\",\"#808080\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"36\",\"  37\",\"  38\",\"  39\",\"  40\"]}]', '[{\"type\":\"Beige-36\",\"price\":53,\"sku\":\"BCSWMLPSMCLLTTTSH2-Beige-36\",\"qty\":50},{\"type\":\"Beige-37\",\"price\":54,\"sku\":\"BCSWMLPSMCLLTTTSH2-Beige-37\",\"qty\":50},{\"type\":\"Beige-38\",\"price\":55,\"sku\":\"BCSWMLPSMCLLTTTSH2-Beige-38\",\"qty\":50},{\"type\":\"Beige-39\",\"price\":56,\"sku\":\"BCSWMLPSMCLLTTTSH2-Beige-39\",\"qty\":50},{\"type\":\"Beige-40\",\"price\":56,\"sku\":\"BCSWMLPSMCLLTTTSH2-Beige-40\",\"qty\":50},{\"type\":\"Brown-36\",\"price\":53,\"sku\":\"BCSWMLPSMCLLTTTSH2-Brown-36\",\"qty\":50},{\"type\":\"Brown-37\",\"price\":54,\"sku\":\"BCSWMLPSMCLLTTTSH2-Brown-37\",\"qty\":50},{\"type\":\"Brown-38\",\"price\":55,\"sku\":\"BCSWMLPSMCLLTTTSH2-Brown-38\",\"qty\":50},{\"type\":\"Brown-39\",\"price\":56,\"sku\":\"BCSWMLPSMCLLTTTSH2-Brown-39\",\"qty\":50},{\"type\":\"Brown-40\",\"price\":56,\"sku\":\"BCSWMLPSMCLLTTTSH2-Brown-40\",\"qty\":50},{\"type\":\"Gray-36\",\"price\":53,\"sku\":\"BCSWMLPSMCLLTTTSH2-Gray-36\",\"qty\":50},{\"type\":\"Gray-37\",\"price\":54,\"sku\":\"BCSWMLPSMCLLTTTSH2-Gray-37\",\"qty\":50},{\"type\":\"Gray-38\",\"price\":55,\"sku\":\"BCSWMLPSMCLLTTTSH2-Gray-38\",\"qty\":50},{\"type\":\"Gray-39\",\"price\":56,\"sku\":\"BCSWMLPSMCLLTTTSH2-Gray-39\",\"qty\":50},{\"type\":\"Gray-40\",\"price\":56,\"sku\":\"BCSWMLPSMCLLTTTSH2-Gray-40\",\"qty\":50}]', 0, 56, 60, '0', 'percent', 'include', '5', 'percent', 750, 1, '<p>BeauToday Chunky Sneakers Women Mesh Leather Platform Shoes Mixed Colors Lace-Up Lady Trendy Trainers Thick Sole Handmade 29401<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-14 23:35:58', '2024-01-16 02:42:19', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '175327', 'All', NULL),
(156, 'seller', 1, 'Kawaii Sanrio Plush Bag Cinnamoroll Backpack Plushie My Melody Bag Anime Stuffed', 'kawaii-sanrio-plush-bag-cinnamoroll-backpack-plushie-my-melody-bag-anime-stuffed-toys-cute-backpacks-for-girls-christmas', 'physical', '[{\"id\":\"259\",\"position\":1},{\"id\":\"187\",\"position\":2}]', '259', '187', NULL, 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-15-655496a299fbc.webp\",\"2023-11-15-655496a2bae44.webp\",\"2023-11-15-655496a2de24b.webp\"]', '[{\"color\":\"ADD8E6\",\"image_name\":\"2023-11-15-655496a299fbc.webp\"},{\"color\":\"FFB6C1\",\"image_name\":\"2023-11-15-655496a2bae44.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-655496a2de24b.webp\"}]', '2023-11-15-655496a307563.webp', '1', NULL, 'youtube', NULL, '[\"#ADD8E6\",\"#FFB6C1\"]', 0, 'null', '[]', '[{\"type\":\"LightBlue\",\"price\":7,\"sku\":\"KSPBCBPMMBASTCBfGCG-LightBlue\",\"qty\":100},{\"type\":\"LightPink\",\"price\":8,\"sku\":\"KSPBCBPMMBASTCBfGCG-LightPink\",\"qty\":100}]', 0, 8, 10, '0', 'percent', 'include', '5', 'percent', 200, 1, '<p>Kawaii Sanrio Plush Bag Cinnamoroll Backpack Plushie My Melody Bag Anime Stuffed Toys Cute Backpacks for Girls Christmas Gifts<br />\r\nStyle: Fresh and sweet<br />\r\nMaterial: plush<br />\r\nLuggage trend style: small square bag<br />\r\nLuggage size: medium<br />\r\nPopular Element: Embroidery<br />\r\nInventory type: whole order<br />\r\nLining texture: nylon<br />\r\nLuggage shape: vertical square shape<br />\r\nOpening method: zipper<br />\r\nInternal structure of the bag: mobile phone bag<br />\r\nPattern: Anime cartoon<br />\r\nProcessing method: soft surface<br />\r\nHardness: Soft<br />\r\nBrand: Cartoon<br />\r\nWith or without interlayer: No<br />\r\nNumber of shoulder straps: single<br />\r\nSize: 26x20cm</p>', 0, NULL, '2023-11-15 13:00:03', '2024-01-16 02:37:30', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '175131', 'All', NULL),
(157, 'seller', 1, 'Small Waist Style Family Living Room Bedroom Small Coffee Table Side Table Simpl', 'small-waist-style-family-living-room-bedroom-small-coffee-table-side-table-simple-corner-table-candy-plate-style-corner-', 'physical', '[{\"id\":\"8\",\"position\":1},{\"id\":\"197\",\"position\":2},{\"id\":\"213\",\"position\":3}]', '8', '197', '213', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-15-6554ac5764793.webp\",\"2023-11-15-6554ac577c72e.webp\",\"2023-11-15-6554ac5793417.webp\",\"2023-11-15-6554ac57a9cc9.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-15-6554ac5764793.webp\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-15-6554ac577c72e.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554ac5793417.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554ac57a9cc9.webp\"}]', '2023-11-15-6554ac57c0d02.webp', '1', NULL, 'youtube', NULL, '[\"#000000\",\"#FFFFFF\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":17,\"sku\":\"SWSFLRBSCTSTSCTCPSCT-Black\",\"qty\":100},{\"type\":\"White\",\"price\":18,\"sku\":\"SWSFLRBSCTSTSCTCPSCT-White\",\"qty\":100}]', 0, 18, 20, '0', 'percent', 'include', '5', 'percent', 200, 1, '<p>Small Waist Style Family Living Room Bedroom Small Coffee Table Side Table Simple Corner Table Candy Plate Style Corner Table</p>', 0, NULL, '2023-11-15 14:32:39', '2023-11-15 23:54:50', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '160745', NULL, NULL),
(158, 'seller', 1, 'Hip Hop 2pcs Iced CapsTeeth Grillz Cubic Zircon Micro Pave Top & Bottom Charm Gr', 'hip-hop-2pcs-iced-capsteeth-grillz-cubic-zircon-micro-pave-top-bottom-charm-grills-for-men-women-jewelry-FVZSCw', 'physical', '[{\"id\":\"9\",\"position\":1},{\"id\":\"134\",\"position\":2},{\"id\":\"138\",\"position\":3}]', '9', '134', '138', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-15-6554b209046e4.webp\",\"2023-11-15-6554b20919309.webp\",\"2023-11-15-6554b209291b4.webp\",\"2023-11-15-6554b209384b9.webp\"]', '[{\"color\":\"FFD700\",\"image_name\":\"2023-11-15-6554b209046e4.webp\"},{\"color\":\"C0C0C0\",\"image_name\":\"2023-11-15-6554b20919309.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554b209291b4.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554b209384b9.webp\"}]', '2023-11-15-6554b2094d8a5.webp', '1', NULL, 'youtube', NULL, '[\"#FFD700\",\"#C0C0C0\"]', 0, 'null', '[]', '[{\"type\":\"Gold\",\"price\":5,\"sku\":\"HH2ICGCZMPT&BCGFMWJ-Gold\",\"qty\":100},{\"type\":\"Silver\",\"price\":4,\"sku\":\"HH2ICGCZMPT&BCGFMWJ-Silver\",\"qty\":100}]', 0, 5, 6, '0', 'percent', 'include', '3', 'percent', 200, 1, '<p>Hip Hop 2pcs Iced CapsTeeth Grillz Cubic Zircon Micro Pave Top &amp; Bottom Charm Grills For Men Women Jewelry</p>', 0, NULL, '2023-11-15 14:56:57', '2023-11-15 23:54:39', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '130067', NULL, NULL),
(159, 'seller', 1, '46pcs Car Repair Tool Kit 1/4-Inch Socket Set Car Repair Tool Ratchet Torque Wre', '46pcs-car-repair-tool-kit-14-inch-socket-set-car-repair-tool-ratchet-torque-wrench-combo-auto-repairing-set-mechanic-too', 'physical', '[{\"id\":\"10\",\"position\":1},{\"id\":\"148\",\"position\":2},{\"id\":\"156\",\"position\":3}]', '10', '148', '156', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-15-6554b3bbc9233.webp\",\"2023-11-15-6554b3bbdf02e.webp\",\"2023-11-15-6554b3bc030c9.webp\",\"2023-11-15-6554b3bc1512f.webp\",\"2023-11-15-6554b3bc267df.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-15-6554b3bbc9233.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554b3bbdf02e.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554b3bc030c9.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554b3bc1512f.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554b3bc267df.webp\"}]', '2023-11-15-6554b3bc3c8e8.webp', '1', NULL, 'youtube', NULL, '[\"#000000\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":20,\"sku\":\"4CRTK1SSCRTRTWCARSMT-Black\",\"qty\":50}]', 0, 20, 25, '0', 'percent', 'include', '5', 'percent', 50, 1, '<p>46pcs Car Repair Tool Kit 1/4-Inch Socket Set Car Repair Tool Ratchet Torque Wrench Combo Auto Repairing Set Mechanic Tool<br />\r\n&nbsp;</p>\r\n\r\n<p>Description<br />\r\n&bull; 46PCs car repair tool kit :This kit includes 46 essential tools for repairing cars, making it a comprehensive solution for all your auto repair needs.</p>\r\n\r\n<p>&bull; 1/4-inch socket set :The 1/4-inch socket set allows for easy and efficient attachment to various car parts, making repairs more convenient.</p>\r\n\r\n<p>&bull; Ratchet torque wrench combo :The ratchet torque wrench combo ensures that the appropriate amount of torque is applied to each bolt or nut, preventing over-tightening or under-tightening.</p>\r\n\r\n<p>&bull; Mechanic tool :This mechanic tool set is designed to help you tackle any car repair job with ease and confidence.</p>', 0, NULL, '2023-11-15 15:04:12', '2023-11-15 23:54:40', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '187908', NULL, NULL),
(160, 'seller', 1, 'Original Samsung Galaxy A71 5G A716U/U1 Mobile CellPhone 6.7\" RAM 6GB ROM 128GB ', 'original-samsung-galaxy-a71-5g-a716uu1-mobile-cellphone-67-ram-6gb-rom-128gb-4-camera-fingerprint-android-unlocked-smart', 'physical', '[{\"id\":\"11\",\"position\":1},{\"id\":\"166\",\"position\":2},{\"id\":\"176\",\"position\":3}]', '11', '166', '176', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-15-6554b7dde6c23.webp\",\"2023-11-15-6554b7de04eb9.webp\",\"2023-11-15-6554b7de1bf08.webp\",\"2023-11-15-6554b7de2c59e.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-15-6554b7dde6c23.webp\"},{\"color\":\"ADD8E6\",\"image_name\":\"2023-11-15-6554b7de04eb9.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554b7de1bf08.webp\"},{\"color\":null,\"image_name\":\"2023-11-15-6554b7de2c59e.webp\"}]', '2023-11-15-6554b7de3e5df.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#ADD8E6\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":175,\"sku\":\"OSGA5AMC6R6R14CFAUS-Black\",\"qty\":0},{\"type\":\"LightBlue\",\"price\":175,\"sku\":\"OSGA5AMC6R6R14CFAUS-LightBlue\",\"qty\":1}]', 0, 175, 180, '0', 'percent', 'include', '5', 'percent', 1, 1, '<p>Original Samsung Galaxy A71 5G A716U/U1 Mobile CellPhone 6.7&quot; RAM 6GB ROM 128GB 4 Camera Fingerprint Android Unlocked Smartphone<br />\r\n&nbsp;</p>\r\n\r\n<p>1.About Version: U/U1 is the US version that does not support OTA update, but U1 supports OTA update, we send U1 version to customers. About Global version with full languages and supports OTA update.</p>\r\n\r\n<p>2. About Language: For U/U1 version, when you turn on the phone, maybe there only be Deutsch/French/ Spanish/ Portuguese / Italian / Japanese / Korean / Vietnamese / Chinese languages options, but you can add your languages by yourself easily. If you don&#39;t know how to do it, please contact us to get a video of the setting.</p>\r\n\r\n<p>For U/U1 version, some languages (such as Russian, Arabic, Hebrew, Polish, etc.) are only partial in this phone. That means even if you set the default language to Russian / Arabic / Hebrew / Polish, there still are about 50% menus showing in English. But the other languages are completed.<br />\r\n3.About Memory: The internal storage will be less than the specification since part of it will be occupied by built-in systems and apps. For example, ROM is 128GB, but only 110-123GB can be used, it is normal.<br />\r\n4. About Battery: The battery efficiency of the phone will be less than the standard. Normally Battery capacity is about 80%-90%. We do not accept any tests from the third-party application.<br />\r\n5. About Phone: TestThis is a used phone, not brand new, we will test the phone to make sure it&rsquo;s working fine and in good condition too.</p>\r\n\r\n<p>6.About Waterproof: The phones do NOT support waterproofing anymore, as the phone is exchanging the new housing from the USED phone.<br />\r\n7.About accessories: All accessories are not original, but of good quality, any dispute for &quot;Fake accessories&quot; will not be accepted, we don&#39;t offer a warranty for the accessories</p>', 0, NULL, '2023-11-15 15:21:50', '2024-01-25 12:10:31', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '115128', NULL, NULL),
(161, 'seller', 1, 'Fork In The Road Foods, Little Goodies, 12 Ounce', 'fork-in-the-road-foods-little-goodies-12-ounce-Q2RrY0', 'physical', '[{\"id\":\"124\",\"position\":1},{\"id\":\"206\",\"position\":2},{\"id\":\"214\",\"position\":3}]', '124', '206', '214', 1, 'kg', 1, 1, NULL, NULL, '[\"2023-11-15-6554bd100b52f.webp\",\"2023-11-15-6554bd102c0d4.webp\",\"2023-11-15-6554bd1048911.webp\",\"2023-11-15-6554bd1059131.webp\"]', '[]', '2023-11-15-6554bd106e6f1.webp', NULL, NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 100, 110, '0', 'percent', 'include', '5', 'percent', 0, 1, '<p>Ingredients<br />\r\nPasture-raised Beef, Water, Contains 2% or Less of the Following: Onion, Garlic, Mustard, Paprika, Celery Powder, Vinegar, Salt, Sugar, Extractives of Paprika, Allspice, Coriander, Nutmeg, Red Pepper, Rosemary.<br />\r\nAbout this item<br />\r\nBrand&nbsp;&nbsp; &nbsp;Fork In The Road Foods<br />\r\nSize&nbsp;&nbsp; &nbsp;12 Ounce<br />\r\nFlavor&nbsp;&nbsp; &nbsp;Beef<br />\r\nItem Weight&nbsp;&nbsp; &nbsp;12 Ounces<br />\r\nSpecialty&nbsp;&nbsp; &nbsp;Placeholder<br />\r\nUncured Pasture Raised Beef Cocktail Franks<br />\r\nAnimal Welfare Certified GAP Step 4 Pasture Raised Beef<br />\r\nMade in our family-owned and operated kitchens in Northern California<br />\r\nNo chemical nitrates or nitrites<br />\r\nGluten, soy, and dairy free</p>', 0, NULL, '2023-11-15 15:44:00', '2023-11-15 23:54:25', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '152967', NULL, NULL),
(162, 'seller', 2, 'Blood Oranges - 18 Lb Case', 'blood-oranges-18-lb-case-lvS9pq', 'physical', '[{\"id\":\"124\",\"position\":1},{\"id\":\"208\",\"position\":2},{\"id\":\"220\",\"position\":3}]', '124', '208', '220', 1, 'kg', 1, 1, NULL, NULL, '[\"2023-11-15-6554e1449fdf3.webp\"]', '[]', '2023-11-15-6554e144b3bef.webp', NULL, NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 40, 50, '0', 'percent', 'include', '5', 'percent', 0, 1, '<p>Blood Oranges - 18 Lb Case<br />\r\n&nbsp;</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 134px; top: 38.6px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 0, NULL, '2023-11-15 18:18:28', '2023-11-15 23:54:24', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '184909', NULL, NULL),
(163, 'seller', 2, 'Kelm Int. Poland Spring 8 oz Mini Water Bottles - 24 Pack Mini Bottled Spring Wa', 'kelm-int-poland-spring-8-oz-mini-water-bottles-24-pack-mini-bottled-spring-water-for-on-the-go-and-home-office-use-bpa-f', 'physical', '[{\"id\":\"124\",\"position\":1},{\"id\":\"207\",\"position\":2},{\"id\":\"217\",\"position\":3}]', '124', '207', '217', 1, 'ltrs', 1, 1, NULL, NULL, '[\"2023-11-15-6554e30028ee9.webp\",\"2023-11-15-6554e300418c5.webp\"]', '[]', '2023-11-16-655670b6d4c4a.webp', NULL, NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 28, 30, '0', 'percent', 'include', '5', 'percent', 0, 1, '<p>Kelm Int. Poland Spring 8 oz Mini Water Bottles - 24 Pack Mini Bottled Spring Water for On-the-Go and Home Office Use - BPA-Free and Recyclable<br />\r\nBULLETPROOF FRESHNESS LOCKDOWN - Experience packaging perfection with our mini water bottles 24 pack. Each bottle is tightly sealed for leak-proof delivery, ensuring freshness until that first sip. Enjoy peak satisfaction with Poland Spring Water 24 pack, the ultimate solution. Stay refreshed and delighted with our perfectly preserved mini water bottles, available in a convenient 24-pack. Trust the brand that masters freshness &ndash; choose Poland Spring for an unparalleled drinking experience.</p>', 0, NULL, '2023-11-15 18:25:52', '2023-11-16 22:42:46', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '182712', NULL, NULL),
(164, 'seller', 2, 'Lenovo IdeaPad 3i 14 Laptop, Student and Business, 14\" FHD Screen, Intel i3-1115', 'lenovo-ideapad-3i-14-laptop-student-and-business-14-fhd-screen-intel-i3-1115g4-processor-20gb-ram-1tb-ssd-hdmi-media-car', 'physical', '[{\"id\":\"11\",\"position\":1},{\"id\":\"167\",\"position\":2},{\"id\":\"180\",\"position\":3}]', '11', '167', '180', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-15-6554e4ac4c920.webp\",\"2023-11-15-6554e4ac67715.webp\",\"2023-11-15-6554e4ac7c8ba.webp\"]', '[]', '2023-11-15-6554e4ac9efe2.webp', '1', NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 410, 420, '0', 'percent', 'include', '10', 'percent', 0, 1, '<p>Lenovo IdeaPad 3i 14 Laptop, Student and Business, 14&quot; FHD Screen, Intel i3-1115G4 Processor, 20GB RAM, 1TB SSD, HDMI, Media Card Reader, Webcam, Dolby Audio, Wi-Fi 6, Windows 11 Home, Platinum Grey<br />\r\nLenovo brand<br />\r\nModel name IdeaPad<br />\r\nScreen size 14 inches<br />\r\nColor gray<br />\r\nHard drive size 512 GB<br />\r\nCore i3 family CPU model<br />\r\nInstalled RAM memory: 12 GB<br />\r\nWindows 11 Home operating system<br />\r\nSpecial feature Dolby<br />\r\nGraphics card description: Integrated</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 5px; top: 67.4px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 0, NULL, '2023-11-15 18:33:00', '2023-11-15 23:54:45', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '124487', NULL, NULL),
(165, 'seller', 2, 'Papitas Margarita Con Limon-lemon Flavored Chips', 'papitas-margarita-con-limon-lemon-flavored-chips-YPJjSe', 'physical', '[{\"id\":\"124\",\"position\":1},{\"id\":\"209\",\"position\":2},{\"id\":\"222\",\"position\":3}]', '124', '209', '222', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-16-65563081d1ebe.webp\"]', '[]', '2023-11-16-65567006cc6cd.webp', '1', NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 11, 12, '0', 'percent', 'include', '3', 'percent', 0, 1, '<p>Papitas Margarita Con Limon-lemon Flavored Chips<br />\r\nSize&nbsp;&nbsp; &nbsp;12.28 Ounce (Pack of 1)<br />\r\nBrand&nbsp;&nbsp; &nbsp;Margarita<br />\r\nPackage Weight&nbsp;&nbsp; &nbsp;0.34 Kilograms<br />\r\nNumber of Pieces&nbsp;&nbsp; &nbsp;1<br />\r\nTemperature Condition&nbsp;&nbsp; &nbsp;Fresh</p>', 0, NULL, '2023-11-16 18:08:49', '2023-11-16 22:39:50', 1, 1, NULL, NULL, '2023-11-16-65567006d81c2.webp', 1, NULL, 0.00, 0, NULL, NULL, '177688', NULL, NULL),
(166, 'seller', 2, 'Pacific Foods Organic Coconut Unsweetened Plant-Based Beverage, 32oz', 'pacific-foods-organic-coconut-unsweetened-plant-based-beverage-32oz-V5hXre', 'physical', '[{\"id\":\"124\",\"position\":1},{\"id\":\"210\",\"position\":2},{\"id\":\"225\",\"position\":3}]', '124', '210', '225', 1, 'ltrs', 1, 1, NULL, NULL, '[\"2023-11-16-655639050b061.webp\",\"2023-11-16-655639051ae56.webp\",\"2023-11-16-655639052b42c.webp\"]', '[]', '2023-11-16-65567041575ac.webp', NULL, NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 4, 5, '0', 'percent', 'include', '3', 'percent', 0, 1, '<p>Pacific Foods Organic Coconut Unsweetened Plant-Based Beverage, 32oz</p>', 0, NULL, '2023-11-16 18:45:09', '2023-11-16 22:40:49', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '178254', NULL, NULL),
(167, 'seller', 2, 'Barnyard Mix Fertile Chicken Hatching Eggs Raised on Organic (12 Eggs)', 'barnyard-mix-fertile-chicken-hatching-eggs-raised-on-organic-12-eggs-7H1gXW', 'physical', '[{\"id\":\"124\",\"position\":1},{\"id\":\"211\",\"position\":2},{\"id\":\"228\",\"position\":3}]', '124', '211', '228', 1, 'kg', 1, 1, NULL, NULL, '[\"2023-11-16-65563a3c1a2c4.webp\"]', '[]', '2023-11-16-65563a3c3635f.webp', '1', NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 16, 17, '0', 'percent', 'include', '5', 'percent', 0, 1, '<p>Barnyard Mix Fertile Chicken Hatching Eggs Raised on Organic (12 Eggs)</p>', 0, NULL, '2023-11-16 18:50:20', '2023-11-16 21:25:53', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '136651', NULL, NULL),
(168, 'seller', 2, 'Automatic Quick-opening Mosquito Net Hammock Outdoor Camping Pole Hammock swing ', 'automatic-quick-opening-mosquito-net-hammock-outdoor-camping-pole-hammock-swing-anti-rollover-nylon-rocking-chair-260x14', 'physical', '[{\"id\":\"8\",\"position\":1},{\"id\":\"64\",\"position\":2},{\"id\":\"73\",\"position\":3}]', '8', '64', '73', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-16-65563c834c557.webp\",\"2023-11-16-65563c8367d7c.webp\",\"2023-11-16-65563c838019d.webp\",\"2023-11-16-65563c838fb88.webp\",\"2023-11-16-65563c83aca72.webp\"]', '[{\"color\":\"556B2F\",\"image_name\":\"2023-11-16-65563c834c557.webp\"},{\"color\":\"FF8C00\",\"image_name\":\"2023-11-16-65563c8367d7c.webp\"},{\"color\":\"008000\",\"image_name\":\"2023-11-16-65563c838019d.webp\"},{\"color\":null,\"image_name\":\"2023-11-16-65563c838fb88.webp\"},{\"color\":null,\"image_name\":\"2023-11-16-65563c83aca72.webp\"}]', '2023-11-16-65563c83c4bda.webp', NULL, NULL, 'youtube', NULL, '[\"#556B2F\",\"#FF8C00\",\"#008000\"]', 0, 'null', '[]', '[{\"type\":\"DarkOliveGreen\",\"price\":13,\"sku\":\"AQMNHOCPHsANRC2-DarkOliveGreen\",\"qty\":50},{\"type\":\"DarkOrange\",\"price\":12,\"sku\":\"AQMNHOCPHsANRC2-DarkOrange\",\"qty\":50},{\"type\":\"Green\",\"price\":11.5,\"sku\":\"AQMNHOCPHsANRC2-Green\",\"qty\":50}]', 0, 13, 15, '0', 'percent', 'include', '5', 'percent', 150, 1, '<p>Automatic Quick-opening Mosquito Net Hammock Outdoor Camping Pole Hammock swing Anti-rollover Nylon Rocking Chair 260x140cm<br />\r\n&nbsp;</p>\r\n\r\n<p>Name: pole mosquito net hammock</p>\r\n\r\n<p>Fabric: 210T wrinkled nylon (commonly known as parachute cloth) + polyester mesh<br />\r\nSize: 260*140cm Manual measurement error 3%<br />\r\nPacking: same color fabric + opp bag packing<br />\r\nBearing: safe bearing 200kg<br />\r\nAccessories: 8cm silver iron buckle*2, high-strength polyester webbing*2, conjoined storage bag*1</p>', 0, NULL, '2023-11-16 19:00:03', '2023-11-16 21:25:34', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '177456', NULL, NULL),
(169, 'seller', 2, 'Men\'s Unpositioned Fashion Hooded Plaid Men\'s Quilted Lined Button Down Plaid Sh', 'mens-unpositioned-fashion-hooded-plaid-mens-quilted-lined-button-down-plaid-shirt-add-velvet-to-keep-warm-jacket-with-ho', 'physical', '[{\"id\":\"3\",\"position\":1},{\"id\":\"14\",\"position\":2},{\"id\":\"45\",\"position\":3}]', '3', '14', '45', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-16-655640c91669d.webp\",\"2023-11-16-655640c9318bb.webp\",\"2023-11-16-655640c94a765.webp\"]', '[{\"color\":\"006400\",\"image_name\":\"2023-11-16-655640c91669d.webp\"},{\"color\":\"0000CD\",\"image_name\":\"2023-11-16-655640c9318bb.webp\"},{\"color\":null,\"image_name\":\"2023-11-16-655640c94a765.webp\"}]', '2023-11-16-655640c961f2b.webp', '1', NULL, 'youtube', NULL, '[\"#006400\",\"#0000CD\"]', 0, 'null', '[]', '[{\"type\":\"DarkGreen\",\"price\":22,\"sku\":\"MUFHPMQLBDPSAVTKWJWH-DarkGreen\",\"qty\":100},{\"type\":\"MediumBlue\",\"price\":23,\"sku\":\"MUFHPMQLBDPSAVTKWJWH-MediumBlue\",\"qty\":100}]', 0, 23, 25, '0', 'percent', 'include', '3', 'percent', 200, 1, '<p>Men&#39;s Unpositioned Fashion Hooded Plaid Men&#39;s Quilted Lined Button Down Plaid Shirt Add Velvet To Keep Warm Jacket With Hood</p>', 0, NULL, '2023-11-16 19:18:17', '2023-11-16 21:25:47', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '188514', NULL, NULL),
(170, 'seller', 2, 'Handbags for Women 2023 Designer Luxury New Fashion Versatile High-end Crossbody', 'handbags-for-women-2023-designer-luxury-new-fashion-versatile-high-end-crossbody-bag-printed-one-shoulder-small-square-b', 'physical', '[{\"id\":\"259\",\"position\":1},{\"id\":\"187\",\"position\":2}]', '259', '187', NULL, 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-16-655642fd6ee6f.webp\",\"2023-11-16-655642fd887ee.webp\",\"2023-11-16-655642fd9a587.webp\"]', '[{\"color\":\"F0E68C\",\"image_name\":\"2023-11-16-655642fd6ee6f.webp\"},{\"color\":null,\"image_name\":\"2023-11-16-655642fd887ee.webp\"},{\"color\":null,\"image_name\":\"2023-11-16-655642fd9a587.webp\"}]', '2023-11-16-655642fdad59b.webp', '1', NULL, 'youtube', NULL, '[\"#F0E68C\"]', 0, 'null', '[]', '[{\"type\":\"Khaki\",\"price\":48,\"sku\":\"HfW2DLNFVHCBPOSSSB-Khaki\",\"qty\":50}]', 0, 48, 50, '0', 'percent', 'include', '5', 'percent', 50, 1, '<p>Handbags for Women 2023 Designer Luxury New Fashion Versatile High-end Crossbody Bag Printed One Shoulder Small Square Bag</p>', 0, NULL, '2023-11-16 19:27:41', '2024-01-16 02:48:58', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '111641', 'All', NULL),
(171, 'seller', 2, 'Kosher Mre Meat Meals Ready to Eat, Variety of Stuffed Chicken Breast, Turkey Sh', 'kosher-mre-meat-meals-ready-to-eat-variety-of-stuffed-chicken-breast-turkey-shwarma-bone-in-chicken-3-pack-bundle-prepar', 'physical', '[{\"id\":\"124\",\"position\":1},{\"id\":\"206\",\"position\":2},{\"id\":\"215\",\"position\":3}]', '124', '206', '215', 1, 'kg', 1, 1, NULL, NULL, '[\"2023-11-16-655645818748d.webp\",\"2023-11-16-65564581a185d.webp\"]', '[]', '2023-11-16-65564581bc4e5.webp', NULL, NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 36, 38, '0', 'percent', 'include', '5', 'percent', 0, 1, '<p>Kosher Mre Meat Meals Ready to Eat, Variety of Stuffed Chicken Breast, Turkey Shwarma, Bone In Chicken (3 Pack Bundle) - Prepared Entree Fully Cooked, Shelf Stable Microwave Dinner<br />\r\nTaste and Nutrition: If you&rsquo;re away from home or don&rsquo;t have the time to cook, our shelf-stable Glatt Kosher Meat Meals are the perfect solution to provide great taste and excellent nutrition. &nbsp;Quality and Care: We prepare each delicious shelf-stable kosher meal using only the highest quality, ingredients and care. Then sterilized to preserve freshness, and texture, with no preservatives or MSG added. &nbsp;Glatt Kosher: All meals are Glatt Kosher and under the strict rabbinical supervision of the Orthodox Union (OU), and Rabbi Getzel Berkowitz of Kiryas Joel. &nbsp;Shelf Stable and Easy to Prepare: KJ Poultry&rsquo;s shelf-stable meals are already fully cooked, so they are quick and easy for you to prepare and serve. Simply unwrap and pop into the microwaveable tray into a microwave for approximately 2 minutes. &nbsp;Ideal Occasions: Whether you&rsquo;re exploring the great outdoors, serving in the armed forces, prepping for an emergency, or just don&rsquo;t have the time to prepare a meal, KJ Poultry&rsquo;s fully-cooked, shelf-stable meals provide the tasty nutrition to power you through the day.</p>', 0, NULL, '2023-11-16 19:38:25', '2023-11-16 21:25:18', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '154541', NULL, NULL),
(172, 'seller', 3, '13 PCS Makeup Brushes Set Eye Shadow Foundation Women Cosmetic Brush Eyeshadow B', '13-pcs-makeup-brushes-set-eye-shadow-foundation-women-cosmetic-brush-eyeshadow-blush-beauty-soft-make-up-tools-bag-ES4aJ', 'physical', '[{\"id\":\"5\",\"position\":1},{\"id\":\"190\",\"position\":2},{\"id\":\"234\",\"position\":3}]', '5', '190', '234', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-17-6557b81300311.webp\",\"2023-11-17-6557b8131b604.webp\",\"2023-11-17-6557b813350fc.webp\"]', '[{\"color\":\"008000\",\"image_name\":\"2023-11-17-6557b81300311.webp\"},{\"color\":\"CD5C5C\",\"image_name\":\"2023-11-17-6557b8131b604.webp\"},{\"color\":null,\"image_name\":\"2023-11-17-6557b813350fc.webp\"}]', '2023-11-17-6557b8134e560.webp', NULL, NULL, 'youtube', NULL, '[\"#008000\",\"#CD5C5C\"]', 0, 'null', '[]', '[{\"type\":\"Green\",\"price\":7,\"sku\":\"1PMBSESFWCBEBBSMUTB-Green\",\"qty\":100},{\"type\":\"IndianRed\",\"price\":8,\"sku\":\"1PMBSESFWCBEBBSMUTB-IndianRed\",\"qty\":100}]', 0, 8, 10, '0', 'percent', 'include', '0', 'flat', 200, 1, '<p>13 PCS Makeup Brushes Set Eye Shadow Foundation Women Cosmetic Brush Eyeshadow Blush Beauty Soft Make Up Tools Bag</p>', 0, NULL, '2023-11-17 21:59:31', '2023-11-20 18:40:58', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '116592', NULL, NULL),
(173, 'seller', 3, 'Baby Shoe Boys/Girls Toddler Shoe 2023Summer New Boy Breathable Mesh Sports Shoe', 'baby-shoe-boysgirls-toddler-shoe-2023summer-new-boy-breathable-mesh-sports-shoe-girls-shoe-soft-sole-casual-shoe-kids-sh', 'physical', '[{\"id\":\"6\",\"position\":1},{\"id\":\"192\",\"position\":2},{\"id\":\"237\",\"position\":3}]', '6', '192', '237', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-17-6557bef598c8e.webp\",\"2023-11-17-6557bef5b2140.webp\",\"2023-11-17-6557bef5c8499.webp\",\"2023-11-17-6557bef5e82ae.webp\",\"2023-11-17-6557c72f8d6cf.webp\"]', '[{\"color\":\"808080\",\"image_name\":\"2023-11-17-6557bef598c8e.webp\"},{\"color\":\"FFC0CB\",\"image_name\":\"2023-11-17-6557bef5b2140.webp\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-17-6557bef5c8499.webp\"},{\"color\":null,\"image_name\":\"2023-11-17-6557bef5e82ae.webp\"},{\"color\":null,\"image_name\":\"2023-11-17-6557c72f8d6cf.webp\"}]', '2023-11-17-6557bef60d4a3.webp', NULL, NULL, 'youtube', NULL, '[\"#808080\",\"#FFC0CB\",\"#FFFFFF\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"16\",\"      17\",\"      18\",\"      19\",\"      20\",\"      21\",\"      22\",\"      23\"]}]', '[{\"type\":\"Gray-16\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-Gray-16\",\"qty\":100},{\"type\":\"Gray-17\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Gray-17\",\"qty\":100},{\"type\":\"Gray-18\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Gray-18\",\"qty\":106},{\"type\":\"Gray-19\",\"price\":10,\"sku\":\"BSBTS2NBBMSS-Gray-19\",\"qty\":100},{\"type\":\"Gray-20\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Gray-20\",\"qty\":111},{\"type\":\"Gray-21\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-Gray-21\",\"qty\":100},{\"type\":\"Gray-22\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-Gray-22\",\"qty\":111},{\"type\":\"Gray-23\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Gray-23\",\"qty\":100},{\"type\":\"Pink-16\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Pink-16\",\"qty\":100},{\"type\":\"Pink-17\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-Pink-17\",\"qty\":100},{\"type\":\"Pink-18\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Pink-18\",\"qty\":100},{\"type\":\"Pink-19\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Pink-19\",\"qty\":100},{\"type\":\"Pink-20\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-Pink-20\",\"qty\":100},{\"type\":\"Pink-21\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Pink-21\",\"qty\":100},{\"type\":\"Pink-22\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-Pink-22\",\"qty\":100},{\"type\":\"Pink-23\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-Pink-23\",\"qty\":100},{\"type\":\"White-16\",\"price\":10,\"sku\":\"BSBTS2NBBMSS-White-16\",\"qty\":100},{\"type\":\"White-17\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-White-17\",\"qty\":100},{\"type\":\"White-18\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-White-18\",\"qty\":100},{\"type\":\"White-19\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-White-19\",\"qty\":100},{\"type\":\"White-20\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-White-20\",\"qty\":100},{\"type\":\"White-21\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-White-21\",\"qty\":100},{\"type\":\"White-22\",\"price\":12,\"sku\":\"BSBTS2NBBMSS-White-22\",\"qty\":100},{\"type\":\"White-23\",\"price\":11,\"sku\":\"BSBTS2NBBMSS-White-23\",\"qty\":100}]', 0, 12, 15, '0', 'percent', 'include', '5', 'percent', 2428, 1, '<p>Baby Shoe Boys/Girls Toddler Shoe 2023Summer New Boy Breathable Mesh Sports Shoe Girls shoe Soft Sole Casual Shoe Kids Shoe T&ecirc;nis<br />\r\n&nbsp;</p>', 0, NULL, '2023-11-17 22:28:54', '2023-11-26 00:13:13', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '120815', NULL, NULL),
(174, 'seller', 3, 'Montessori Baby Busy Board 3D Toddlers Story Cloth Book Sensory toys for babies ', 'montessori-baby-busy-board-3d-toddlers-story-cloth-book-sensory-toys-for-babies-education-habits-toys-books-for-kids-fro', 'physical', '[{\"id\":\"7\",\"position\":1},{\"id\":\"121\",\"position\":2},{\"id\":\"126\",\"position\":3}]', '7', '121', '126', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-17-6557c70e1f2fa.webp\",\"2023-11-17-6557c70e38442.webp\"]', '[{\"color\":\"0000FF\",\"image_name\":\"2023-11-17-6557c70e1f2fa.webp\"},{\"color\":null,\"image_name\":\"2023-11-17-6557c70e38442.webp\"}]', '2023-11-17-6557c70e5274d.webp', NULL, NULL, 'youtube', NULL, '[\"#0000FF\"]', 0, 'null', '[]', '[{\"type\":\"Blue\",\"price\":8,\"sku\":\"MBBB3TSCBStfbEHTbfkf0-Blue\",\"qty\":1}]', 0, 8, 10, '0', 'percent', 'include', '5', 'percent', 1, 1, '<p>Montessori Baby Busy Board 3D Toddlers Story Cloth Book Sensory toys for babies Education Habits Toys books for kids from 0-3</p>', 0, NULL, '2023-11-17 23:03:26', '2023-11-20 18:41:01', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '161477', NULL, NULL),
(175, 'seller', 3, 'Square Sunglasses Woman Brand Designer Fashion Rimless Gradient Sun Glasses Shad', 'square-sunglasses-woman-brand-designer-fashion-rimless-gradient-sun-glasses-shades-cutting-lens-ladies-frameless-eyeglas', 'physical', '[{\"id\":\"9\",\"position\":1},{\"id\":\"201\",\"position\":2},{\"id\":\"241\",\"position\":3}]', '9', '201', '241', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-18-6558e4c32af88.webp\",\"2023-11-18-6558e4c346198.webp\",\"2023-11-18-6558e4c35f198.webp\"]', '[{\"color\":\"A52A2A\",\"image_name\":\"2023-11-18-6558e4c32af88.webp\"},{\"color\":\"A9A9A9\",\"image_name\":\"2023-11-18-6558e4c346198.webp\"},{\"color\":\"FF1493\",\"image_name\":\"2023-11-18-6558e4c35f198.webp\"}]', '2023-11-18-6558e4c37cd5d.webp', NULL, NULL, 'youtube', NULL, '[\"#A52A2A\",\"#A9A9A9\",\"#FF1493\"]', 0, 'null', '[]', '[{\"type\":\"Brown\",\"price\":6,\"sku\":\"SSWBDFRGSGSCLLFE-Brown\",\"qty\":1},{\"type\":\"DarkGray\",\"price\":6,\"sku\":\"SSWBDFRGSGSCLLFE-DarkGray\",\"qty\":1},{\"type\":\"DeepPink\",\"price\":6,\"sku\":\"SSWBDFRGSGSCLLFE-DeepPink\",\"qty\":1}]', 0, 6, 8, '0', 'percent', 'include', '3', 'percent', 3, 1, '<p>Square Sunglasses Woman Brand Designer Fashion Rimless Gradient Sun Glasses Shades Cutting Lens Ladies Frameless Eyeglasses</p>', 0, NULL, '2023-11-18 19:22:27', '2023-11-20 18:41:02', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '101571', NULL, NULL),
(176, 'seller', 3, 'For KTM 200 250 300 200EXC 250XC 250XCW 300XC 300XCW 410W Electric Engine Parts ', 'for-ktm-200-250-300-200exc-250xc-250xcw-300xc-300xcw-410w-electric-engine-parts-starter-motor-2008-2012-starter-motorcyc', 'physical', '[{\"id\":\"10\",\"position\":1},{\"id\":\"149\",\"position\":2},{\"id\":\"159\",\"position\":3}]', '10', '149', '159', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-18-6558e76ca9cad.webp\",\"2023-11-18-6558e76cbe0c5.webp\",\"2023-11-18-6558e76cced93.webp\"]', '[{\"color\":\"A9A9A9\",\"image_name\":\"2023-11-18-6558e76ca9cad.webp\"},{\"color\":null,\"image_name\":\"2023-11-18-6558e76cbe0c5.webp\"},{\"color\":null,\"image_name\":\"2023-11-18-6558e76cced93.webp\"}]', '2023-11-18-6558e76cdef04.webp', NULL, NULL, 'youtube', NULL, '[\"#A9A9A9\"]', 0, 'null', '[]', '[{\"type\":\"DarkGray\",\"price\":36,\"sku\":\"FK223222334EEPSM2SM1-DarkGray\",\"qty\":100}]', 0, 36, 40, '0', 'percent', 'include', '3', 'percent', 100, 1, '<p>For KTM 200 250 300 200EXC 250XC 250XCW 300XC 300XCW 410W Electric Engine Parts Starter Motor 2008-2012 Starter Motorcycle 12V<br />\r\n&nbsp;</p>\r\n\r\n<ul>\r\n	<li>\r\n	<p>Working condition: This item is a brand-new, unused, unopened, undamaged item in its original packaging (where packaging is applicable).&nbsp; see the seller&#39;s listing for full details.<br />\r\n	Recommended seller: It is recommended to provide high-quality products when purchased by the manufacturer, and are strictly tested before shipment. as long as you are not satisfied, you can rest assured to buy.<br />\r\n	Top quality construction: Our engine parts are made of high quality materials, which is durable and long lasting.<br />\r\n	&nbsp;</p>\r\n\r\n	<p>9 Teeth Spline<br />\r\n	5cm Body OD<br />\r\n	12.3cm overall length</p>\r\n\r\n	<p>Please check the pictures before ordering</p>\r\n	</li>\r\n</ul>', 0, NULL, '2023-11-18 19:33:48', '2023-11-20 18:41:04', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '147633', NULL, NULL),
(177, 'seller', 3, 'New Men\'s Genuine Leather Jacket Male Cowhide Overcoat Autumn Winter Business Co', 'new-mens-genuine-leather-jacket-male-cowhide-overcoat-autumn-winter-business-coat-trench-style-double-breasted-clothes-c', 'physical', '[{\"id\":\"3\",\"position\":1},{\"id\":\"43\",\"position\":2},{\"id\":\"56\",\"position\":3}]', '3', '43', '56', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-20-655b4a1f05778.webp\",\"2023-11-20-655b4a1f241a8.webp\",\"2023-11-20-655b4a1f3c0f0.webp\",\"2023-11-20-655b4a1f504fc.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-20-655b4a1f05778.webp\"},{\"color\":null,\"image_name\":\"2023-11-20-655b4a1f241a8.webp\"},{\"color\":null,\"image_name\":\"2023-11-20-655b4a1f3c0f0.webp\"},{\"color\":null,\"image_name\":\"2023-11-20-655b4a1f504fc.webp\"}]', '2023-11-20-655b4a1f62f01.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\"]', 0, '[\"1\"]', '[{\"name\":\"choice_1\",\"title\":\"Size\",\"options\":[\"M\",\"L\",\"XL\",\"2XL\",\"3XL\",\"4XL\"]}]', '[{\"type\":\"Black-M\",\"price\":106,\"sku\":\"NMGLJMCOAWBCTSDBCC-Black-M\",\"qty\":98},{\"type\":\"Black-L\",\"price\":100,\"sku\":\"NMGLJMCOAWBCTSDBCC-Black-L\",\"qty\":100},{\"type\":\"Black-XL\",\"price\":105,\"sku\":\"NMGLJMCOAWBCTSDBCC-Black-XL\",\"qty\":99},{\"type\":\"Black-2XL\",\"price\":108,\"sku\":\"NMGLJMCOAWBCTSDBCC-Black-2XL\",\"qty\":100},{\"type\":\"Black-3XL\",\"price\":110,\"sku\":\"NMGLJMCOAWBCTSDBCC-Black-3XL\",\"qty\":100},{\"type\":\"Black-4XL\",\"price\":110,\"sku\":\"NMGLJMCOAWBCTSDBCC-Black-4XL\",\"qty\":100}]', 0, 110, 115, '0', 'percent', 'include', '5', 'percent', 597, 1, '<p>New Men&#39;s Genuine Leather Jacket Male Cowhide Overcoat Autumn Winter Business Coat Trench Style Double Breasted Clothes Calfskin</p>', 0, NULL, '2023-11-20 14:59:27', '2023-11-26 00:11:18', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '111430', NULL, NULL),
(178, 'seller', 3, 'Sell like hot Mini Portable Drive 3.0 Flash Drive 2TB USB PEN DRIVE 1tb External', 'sell-like-hot-mini-portable-drive-30-flash-drive-2tb-usb-pen-drive-1tb-external-flash-memory-for-laptop-desktop-mechanic', 'physical', '[{\"id\":\"11\",\"position\":1},{\"id\":\"164\",\"position\":2},{\"id\":\"169\",\"position\":3}]', '11', '164', '169', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-20-655b6a226af94.webp\",\"2023-11-20-655b6a228947b.webp\",\"2023-11-20-655b6a22af5a7.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-20-655b6a226af94.webp\"},{\"color\":\"C0C0C0\",\"image_name\":\"2023-11-20-655b6a228947b.webp\"},{\"color\":null,\"image_name\":\"2023-11-20-655b6a22af5a7.webp\"}]', '2023-11-20-655b6a22c9e10.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#C0C0C0\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":17,\"sku\":\"SlhMPD3FD2UPD1EFMFLDM-Black\",\"qty\":1},{\"type\":\"Silver\",\"price\":16,\"sku\":\"SlhMPD3FD2UPD1EFMFLDM-Silver\",\"qty\":0}]', 0, 17, 20, '0', 'percent', 'include', '5', 'percent', 1, 1, '<p>Sell like hot Mini Portable Drive 3.0 Flash Drive 2TB USB PEN DRIVE 1tb External Flash Memory For Laptop Desktop Mechanical</p>', 0, NULL, '2023-11-20 17:16:02', '2024-01-25 12:12:50', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '169719', NULL, NULL),
(179, 'seller', 3, '2022 New Fashion Female Shoulder Bag Rhombus Embroidered Solid Color Chain Women', '2022-new-fashion-female-shoulder-bag-rhombus-embroidered-solid-color-chain-women-shoulder-crossbody-casual-trendy-phone-', 'physical', '[{\"id\":\"259\",\"position\":1},{\"id\":\"77\",\"position\":2},{\"id\":\"85\",\"position\":3}]', '259', '77', '85', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-20-655b6e4223c5c.webp\",\"2023-11-20-655b6e423af70.webp\",\"2023-11-20-655b6e425089e.webp\",\"2023-11-20-655b6e4267dad.webp\",\"2023-11-20-655b6e427def4.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-20-655b6e4223c5c.webp\"},{\"color\":\"A52A2A\",\"image_name\":\"2023-11-20-655b6e423af70.webp\"},{\"color\":\"8B0000\",\"image_name\":\"2023-11-20-655b6e425089e.webp\"},{\"color\":\"FFB6C1\",\"image_name\":\"2023-11-20-655b6e4267dad.webp\"},{\"color\":\"FFFFFF\",\"image_name\":\"2023-11-20-655b6e427def4.webp\"}]', '2023-11-20-655b6e429d30b.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\",\"#A52A2A\",\"#8B0000\",\"#FFB6C1\",\"#FFFFFF\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":6,\"sku\":\"2NFFSBRESCCWSCCTPB-Black\",\"qty\":100},{\"type\":\"Brown\",\"price\":5,\"sku\":\"2NFFSBRESCCWSCCTPB-Brown\",\"qty\":100},{\"type\":\"DarkRed\",\"price\":6,\"sku\":\"2NFFSBRESCCWSCCTPB-DarkRed\",\"qty\":100},{\"type\":\"LightPink\",\"price\":5,\"sku\":\"2NFFSBRESCCWSCCTPB-LightPink\",\"qty\":100},{\"type\":\"White\",\"price\":6,\"sku\":\"2NFFSBRESCCWSCCTPB-White\",\"qty\":100}]', 0, 6, 9, '0', 'percent', 'include', '5', 'percent', 500, 1, '<p>2022 New Fashion Female Shoulder Bag Rhombus Embroidered Solid Color Chain Women Shoulder Crossbody Casual Trendy Phone Bag<br />\r\n&nbsp;</p>\r\n\r\n<p>PRODUCT INFORMATION</p>\r\n\r\n<p>Item Name: women&#39;s shoulder bag</p>\r\n\r\n<p>Size:20*6*12cm</p>\r\n\r\n<p>Color:white,red,black,brown,pink</p>\r\n\r\n<p>Material:PU leather</p>\r\n\r\n<p>Feature:</p>\r\n\r\n<p>This bag will make you more fashionable, sexy, elegant and confident.</p>\r\n\r\n<p>Perfect for weddings, Party, Prom, Ball, and evening events.</p>\r\n\r\n<p>Best gifts for lovers and friends</p>\r\n\r\n<p>Fit for all styles of clothes.<br />\r\nTips:</p>\r\n\r\n<p>1. Chromatic aberration</p>\r\n\r\n<p>Due to the shooting camera and lighting, some model pictures may have chromatic aberration, the horizontally placed pictures are toned closer to the actual display effect.</p>', 0, NULL, '2023-11-20 17:33:38', '2024-01-16 02:48:08', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '118354', 'All', NULL);
INSERT INTO `products` (`id`, `added_by`, `user_id`, `name`, `slug`, `product_type`, `category_ids`, `category_id`, `sub_category_id`, `sub_sub_category_id`, `brand_id`, `unit`, `min_qty`, `refundable`, `digital_product_type`, `digital_file_ready`, `images`, `color_image`, `thumbnail`, `featured`, `flash_deal`, `video_provider`, `video_url`, `colors`, `variant_product`, `attributes`, `choice_options`, `variation`, `published`, `unit_price`, `purchase_price`, `tax`, `tax_type`, `tax_model`, `discount`, `discount_type`, `current_stock`, `minimum_order_qty`, `details`, `free_shipping`, `attachment`, `created_at`, `updated_at`, `status`, `featured_status`, `meta_title`, `meta_description`, `meta_image`, `request_status`, `denied_note`, `shipping_cost`, `multiply_qty`, `temp_shipping_cost`, `is_shipping_cost_updated`, `code`, `shipping_country`, `origin`) VALUES
(180, 'seller', 3, 'Dental Spatula Plaster Knife Practical Stainless Steel Versatile Teeth Wax Carvi', 'dental-spatula-plaster-knife-practical-stainless-steel-versatile-teeth-wax-carving-tool-set-dental-instrument-dentist-to', 'physical', '[{\"id\":\"5\",\"position\":1},{\"id\":\"95\",\"position\":2},{\"id\":\"233\",\"position\":3}]', '5', '95', '233', 1, 'pc', 1, 1, NULL, NULL, '[\"2023-11-20-655b708544c78.webp\",\"2023-11-20-655b70855a2e7.webp\",\"2023-11-20-655b70856979f.webp\",\"2023-11-20-655b708575391.webp\"]', '[{\"color\":\"000000\",\"image_name\":\"2023-11-20-655b708544c78.webp\"},{\"color\":null,\"image_name\":\"2023-11-20-655b70855a2e7.webp\"},{\"color\":null,\"image_name\":\"2023-11-20-655b70856979f.webp\"},{\"color\":null,\"image_name\":\"2023-11-20-655b708575391.webp\"}]', '2023-11-20-655b70858917b.webp', NULL, NULL, 'youtube', NULL, '[\"#000000\"]', 0, 'null', '[]', '[{\"type\":\"Black\",\"price\":10,\"sku\":\"DSPKPSSVTWCTSDIDT-Black\",\"qty\":100}]', 0, 10, 13, '0', 'percent', 'include', '5', 'percent', 100, 1, '<p>Dental Spatula Plaster Knife Practical Stainless Steel Versatile Teeth Wax Carving Tool Set Dental Instrument Dentist Tools.<br />\r\n100% brand new &amp; high quality.<br />\r\nDental Lab Stainless Steel Kit Wax Carving Tool Set Instrument<br />\r\nMaterial: High-quality Stainless Steel<br />\r\nQuantity: 10 Pieces Of Different Styles<br />\r\nColor: Silver Box size: open 20x18.5cm, put together 20X8.5X2.5cm<br />\r\nFeature:<br />\r\n1. Made of high-quality stainless steel, hygienic, sharp, and durable;<br />\r\n2. Essential oral care tools for daily cleaning and examination of teeth;<br />\r\n3. including knives, scalers, probes, toothpicks, tartar, plaque scraping, etc.;<br />\r\n4. non-slip handle, safer, more convenient to use.<br />\r\n5. with PU bag, easy to carry and store.<br />\r\n6. soft and comfortable, thoroughly clean, easy to use, and comfortable to hold.</p>', 0, NULL, '2023-11-20 17:43:17', '2023-11-20 18:41:11', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '133857', NULL, NULL),
(181, 'seller', 3, 'Sırma Natural Mineral Water 12x1 L', 'sirma-natural-mineral-water-12x1-l-dRfx0o', 'physical', '[{\"id\":\"124\",\"position\":1},{\"id\":\"207\",\"position\":2},{\"id\":\"218\",\"position\":3}]', '124', '207', '218', 1, 'ltrs', 1, 1, NULL, NULL, '[\"2023-11-20-655b842f14241.webp\"]', '[{\"color\":null,\"image_name\":\"2023-11-20-655b842f14241.webp\"}]', '2023-11-20-655b842f2c206.webp', '0', NULL, 'youtube', NULL, '[]', 0, 'null', '[]', '[]', 0, 6, 7, '0', 'percent', 'include', '5', 'percent', 0, 1, '<p>Sırma Natural Mineral Water 12x1 L</p>', 0, NULL, '2023-11-20 19:07:11', '2023-11-20 22:30:15', 1, 1, NULL, NULL, 'def.webp', 1, NULL, 0.00, 0, NULL, NULL, '128653', NULL, NULL),
(183, 'seller', 12, 'Shad Beasley', 'shad-beasley-lceqAe', 'physical', '[{\"id\":\"10\",\"position\":1},{\"id\":\"147\",\"position\":2},{\"id\":\"155\",\"position\":3}]', '10', '147', '155', 7, 'kg', 1, 1, NULL, NULL, '[\"2024-01-13-65a1ab4b3135b.webp\"]', '[]', '2024-01-13-65a1ab4b94d58.webp', NULL, NULL, 'youtube', 'In tempore optio i', '[]', 0, 'null', '[]', '[]', 0, 962, 741, '54', 'percent', 'include', '55', 'flat', 240, 50, '<p>dfdsfdsf</p>', 0, NULL, '2024-01-13 00:12:43', '2024-01-13 00:13:07', 1, 1, 'Nam aliquid laboris', 'Est ad sint dolore', 'def.webp', 1, NULL, 70.00, 0, NULL, NULL, '175832', NULL, 'Turkey');

-- --------------------------------------------------------

--
-- Table structure for table `product_compares`
--

CREATE TABLE `product_compares` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'customer_id',
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `variant` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00,
  `qty` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tag`
--

CREATE TABLE `product_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_tag`
--

INSERT INTO `product_tag` (`id`, `product_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 111, 1, NULL, NULL),
(2, 112, 2, NULL, NULL),
(3, 112, 3, NULL, NULL),
(4, 112, 1, NULL, NULL),
(5, 113, 1, NULL, NULL),
(6, 113, 4, NULL, NULL),
(7, 113, 5, NULL, NULL),
(8, 113, 6, NULL, NULL),
(9, 114, 7, NULL, NULL),
(10, 114, 8, NULL, NULL),
(11, 114, 9, NULL, NULL),
(12, 115, 10, NULL, NULL),
(13, 115, 9, NULL, NULL),
(14, 115, 11, NULL, NULL),
(15, 116, 12, NULL, NULL),
(16, 116, 13, NULL, NULL),
(17, 117, 14, NULL, NULL),
(18, 117, 15, NULL, NULL),
(19, 117, 16, NULL, NULL),
(20, 118, 17, NULL, NULL),
(21, 118, 18, NULL, NULL),
(22, 118, 14, NULL, NULL),
(23, 119, 19, NULL, NULL),
(24, 119, 20, NULL, NULL),
(25, 120, 19, NULL, NULL),
(26, 120, 21, NULL, NULL),
(27, 121, 19, NULL, NULL),
(28, 121, 22, NULL, NULL),
(29, 122, 23, NULL, NULL),
(30, 122, 24, NULL, NULL),
(31, 123, 23, NULL, NULL),
(32, 123, 25, NULL, NULL),
(33, 124, 23, NULL, NULL),
(34, 124, 26, NULL, NULL),
(35, 125, 23, NULL, NULL),
(36, 125, 27, NULL, NULL),
(37, 125, 28, NULL, NULL),
(38, 126, 29, NULL, NULL),
(39, 126, 30, NULL, NULL),
(40, 127, 31, NULL, NULL),
(41, 127, 32, NULL, NULL),
(42, 127, 33, NULL, NULL),
(43, 128, 34, NULL, NULL),
(44, 128, 35, NULL, NULL),
(45, 128, 36, NULL, NULL),
(46, 129, 37, NULL, NULL),
(47, 129, 38, NULL, NULL),
(48, 130, 39, NULL, NULL),
(49, 130, 40, NULL, NULL),
(50, 130, 41, NULL, NULL),
(51, 131, 42, NULL, NULL),
(52, 131, 43, NULL, NULL),
(53, 132, 44, NULL, NULL),
(54, 132, 45, NULL, NULL),
(55, 133, 46, NULL, NULL),
(56, 133, 47, NULL, NULL),
(57, 133, 48, NULL, NULL),
(58, 134, 49, NULL, NULL),
(59, 134, 50, NULL, NULL),
(60, 134, 51, NULL, NULL),
(61, 135, 52, NULL, NULL),
(62, 135, 53, NULL, NULL),
(63, 136, 54, NULL, NULL),
(64, 136, 55, NULL, NULL),
(65, 137, 56, NULL, NULL),
(66, 137, 57, NULL, NULL),
(67, 137, 58, NULL, NULL),
(68, 138, 59, NULL, NULL),
(69, 138, 60, NULL, NULL),
(70, 138, 61, NULL, NULL),
(71, 139, 62, NULL, NULL),
(72, 139, 63, NULL, NULL),
(73, 139, 41, NULL, NULL),
(74, 140, 64, NULL, NULL),
(75, 140, 65, NULL, NULL),
(76, 141, 66, NULL, NULL),
(77, 141, 48, NULL, NULL),
(78, 141, 47, NULL, NULL),
(79, 142, 67, NULL, NULL),
(80, 142, 68, NULL, NULL),
(81, 143, 24, NULL, NULL),
(82, 143, 69, NULL, NULL),
(83, 143, 70, NULL, NULL),
(84, 143, 71, NULL, NULL),
(85, 144, 72, NULL, NULL),
(86, 144, 73, NULL, NULL),
(87, 145, 54, NULL, NULL),
(88, 145, 74, NULL, NULL),
(89, 146, 75, NULL, NULL),
(90, 146, 76, NULL, NULL),
(91, 147, 77, NULL, NULL),
(92, 147, 78, NULL, NULL),
(93, 148, 79, NULL, NULL),
(94, 148, 80, NULL, NULL),
(95, 149, 81, NULL, NULL),
(96, 149, 82, NULL, NULL),
(97, 150, 83, NULL, NULL),
(98, 150, 84, NULL, NULL),
(99, 150, 85, NULL, NULL),
(100, 151, 86, NULL, NULL),
(101, 151, 87, NULL, NULL),
(102, 152, 88, NULL, NULL),
(103, 152, 89, NULL, NULL),
(104, 152, 90, NULL, NULL),
(105, 153, 91, NULL, NULL),
(106, 153, 92, NULL, NULL),
(107, 154, 93, NULL, NULL),
(108, 154, 94, NULL, NULL),
(109, 155, 95, NULL, NULL),
(110, 155, 96, NULL, NULL),
(111, 156, 97, NULL, NULL),
(112, 156, 98, NULL, NULL),
(113, 156, 99, NULL, NULL),
(114, 157, 100, NULL, NULL),
(115, 157, 42, NULL, NULL),
(116, 158, 101, NULL, NULL),
(117, 158, 102, NULL, NULL),
(118, 159, 83, NULL, NULL),
(119, 159, 84, NULL, NULL),
(120, 159, 103, NULL, NULL),
(121, 160, 104, NULL, NULL),
(122, 160, 105, NULL, NULL),
(123, 161, 106, NULL, NULL),
(124, 161, 107, NULL, NULL),
(125, 162, 108, NULL, NULL),
(126, 162, 109, NULL, NULL),
(127, 162, 110, NULL, NULL),
(128, 163, 111, NULL, NULL),
(129, 163, 112, NULL, NULL),
(130, 163, 113, NULL, NULL),
(131, 164, 114, NULL, NULL),
(132, 164, 115, NULL, NULL),
(133, 165, 116, NULL, NULL),
(134, 165, 117, NULL, NULL),
(135, 166, 118, NULL, NULL),
(136, 166, 119, NULL, NULL),
(137, 167, 120, NULL, NULL),
(138, 167, 121, NULL, NULL),
(139, 167, 122, NULL, NULL),
(140, 168, 123, NULL, NULL),
(141, 168, 124, NULL, NULL),
(142, 169, 29, NULL, NULL),
(143, 169, 125, NULL, NULL),
(144, 170, 31, NULL, NULL),
(145, 170, 126, NULL, NULL),
(146, 170, 99, NULL, NULL),
(147, 171, 106, NULL, NULL),
(148, 171, 127, NULL, NULL),
(149, 171, 128, NULL, NULL),
(150, 172, 129, NULL, NULL),
(151, 172, 130, NULL, NULL),
(152, 173, 131, NULL, NULL),
(153, 173, 132, NULL, NULL),
(154, 174, 39, NULL, NULL),
(155, 174, 40, NULL, NULL),
(156, 175, 133, NULL, NULL),
(157, 175, 134, NULL, NULL),
(158, 176, 135, NULL, NULL),
(159, 176, 136, NULL, NULL),
(160, 176, 137, NULL, NULL),
(161, 177, 88, NULL, NULL),
(162, 177, 89, NULL, NULL),
(163, 178, 67, NULL, NULL),
(164, 178, 138, NULL, NULL),
(165, 179, 31, NULL, NULL),
(166, 179, 139, NULL, NULL),
(167, 179, 99, NULL, NULL),
(168, 180, 54, NULL, NULL),
(169, 180, 140, NULL, NULL),
(170, 181, 111, NULL, NULL),
(171, 181, 141, NULL, NULL),
(172, 182, 142, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_details_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(191) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `refund_reason` longtext NOT NULL,
  `images` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `approved_note` longtext DEFAULT NULL,
  `rejected_note` longtext DEFAULT NULL,
  `payment_info` longtext DEFAULT NULL,
  `change_by` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refund_requests`
--

INSERT INTO `refund_requests` (`id`, `order_details_id`, `customer_id`, `status`, `amount`, `product_id`, `order_id`, `refund_reason`, `images`, `created_at`, `updated_at`, `approved_note`, `rejected_note`, `payment_info`, `change_by`) VALUES
(1, 10, 2, 'approved', 20.37, 123, 100008, 'NOT GOOOD', '[\"2023-11-26-656263c9da807.webp\"]', '2023-11-26 00:14:49', '2023-11-26 00:16:49', 'OKKK', NULL, NULL, 'admin'),
(2, 9, 2, 'approved', 57.00, 173, 100007, 'NOT GEEOD', '[\"2023-11-26-656263f84a7f6.webp\"]', '2023-11-26 00:15:36', '2023-11-26 00:21:00', 'okks', NULL, NULL, 'admin'),
(3, 5, 2, 'approved', 12.00, 149, 100004, 'ty', '[\"2023-11-26-656265cf62cea.webp\"]', '2023-11-26 00:23:27', '2023-11-27 00:26:55', 'ok dsfdsfdsfds dsddsf', NULL, NULL, 'admin'),
(4, 22, 5, 'pending', 15.20, 178, 100019, 'fdfgj', NULL, '2024-01-25 12:17:26', '2024-01-25 12:17:26', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `refund_statuses`
--

CREATE TABLE `refund_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `refund_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `change_by` varchar(191) DEFAULT NULL,
  `change_by_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(191) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refund_statuses`
--

INSERT INTO `refund_statuses` (`id`, `refund_request_id`, `change_by`, `change_by_id`, `status`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 1, 'approved', 'OKKK', '2023-11-26 00:16:49', '2023-11-26 00:16:49'),
(2, 2, 'admin', 1, 'approved', 'okks', '2023-11-26 00:21:00', '2023-11-26 00:21:00'),
(3, 3, 'admin', 1, 'approved', 'ok dsfdsfdsfds dsddsf', '2023-11-27 00:26:55', '2023-11-27 00:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `refund_transactions`
--

CREATE TABLE `refund_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_for` varchar(191) DEFAULT NULL,
  `payer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `paid_by` varchar(191) DEFAULT NULL,
  `paid_to` varchar(191) DEFAULT NULL,
  `payment_method` varchar(191) DEFAULT NULL,
  `payment_status` varchar(191) DEFAULT NULL,
  `amount` double(8,2) DEFAULT NULL,
  `transaction_type` varchar(191) DEFAULT NULL,
  `order_details_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `refund_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `delivery_man_id` bigint(20) DEFAULT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `comment` mediumtext DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_saved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `customer_id`, `delivery_man_id`, `order_id`, `comment`, `attachment`, `rating`, `status`, `is_saved`, `created_at`, `updated_at`) VALUES
(1, 178, 5, NULL, NULL, 'ggg', '[]', 5, 1, 0, '2024-01-25 12:18:08', '2024-01-25 12:18:46');

-- --------------------------------------------------------

--
-- Table structure for table `search_functions`
--

CREATE TABLE `search_functions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(150) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `visible_for` varchar(191) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `search_functions`
--

INSERT INTO `search_functions` (`id`, `key`, `url`, `visible_for`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'admin/dashboard', 'admin', NULL, NULL),
(2, 'Order All', 'admin/orders/list/all', 'admin', NULL, NULL),
(3, 'Order Pending', 'admin/orders/list/pending', 'admin', NULL, NULL),
(4, 'Order Processed', 'admin/orders/list/processed', 'admin', NULL, NULL),
(5, 'Order Delivered', 'admin/orders/list/delivered', 'admin', NULL, NULL),
(6, 'Order Returned', 'admin/orders/list/returned', 'admin', NULL, NULL),
(7, 'Order Failed', 'admin/orders/list/failed', 'admin', NULL, NULL),
(8, 'Brand Add', 'admin/brand/add-new', 'admin', NULL, NULL),
(9, 'Brand List', 'admin/brand/list', 'admin', NULL, NULL),
(10, 'Banner', 'admin/banner/list', 'admin', NULL, NULL),
(11, 'Category', 'admin/category/view', 'admin', NULL, NULL),
(12, 'Sub Category', 'admin/category/sub-category/view', 'admin', NULL, NULL),
(13, 'Sub sub category', 'admin/category/sub-sub-category/view', 'admin', NULL, NULL),
(14, 'Attribute', 'admin/attribute/view', 'admin', NULL, NULL),
(15, 'Product', 'admin/product/list', 'admin', NULL, NULL),
(16, 'Coupon', 'admin/coupon/add-new', 'admin', NULL, NULL),
(17, 'Custom Role', 'admin/custom-role/create', 'admin', NULL, NULL),
(18, 'Employee', 'admin/employee/add-new', 'admin', NULL, NULL),
(19, 'Seller', 'admin/sellers/seller-list', 'admin', NULL, NULL),
(20, 'Contacts', 'admin/contact/list', 'admin', NULL, NULL),
(21, 'Flash Deal', 'admin/deal/flash', 'admin', NULL, NULL),
(22, 'Deal of the day', 'admin/deal/day', 'admin', NULL, NULL),
(23, 'Language', 'admin/business-settings/language', 'admin', NULL, NULL),
(24, 'Mail', 'admin/business-settings/mail', 'admin', NULL, NULL),
(25, 'Shipping method', 'admin/business-settings/shipping-method/add', 'admin', NULL, NULL),
(26, 'Currency', 'admin/currency/view', 'admin', NULL, NULL),
(27, 'Payment method', 'admin/business-settings/payment-method', 'admin', NULL, NULL),
(28, 'SMS Gateway', 'admin/business-settings/sms-gateway', 'admin', NULL, NULL),
(29, 'Support Ticket', 'admin/support-ticket/view', 'admin', NULL, NULL),
(30, 'FAQ', 'admin/helpTopic/list', 'admin', NULL, NULL),
(31, 'About Us', 'admin/business-settings/about-us', 'admin', NULL, NULL),
(32, 'Terms and Conditions', 'admin/business-settings/terms-condition', 'admin', NULL, NULL),
(33, 'Web Config', 'admin/business-settings/web-config', 'admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `f_name` varchar(30) DEFAULT NULL,
  `l_name` varchar(30) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `image` varchar(30) DEFAULT 'def.png',
  `email` varchar(80) NOT NULL,
  `password` varchar(80) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'pending',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_name` varchar(191) DEFAULT NULL,
  `branch` varchar(191) DEFAULT NULL,
  `account_no` varchar(191) DEFAULT NULL,
  `holder_name` varchar(191) DEFAULT NULL,
  `auth_token` text DEFAULT NULL,
  `sales_commission_percentage` double(8,2) DEFAULT NULL,
  `gst` varchar(191) DEFAULT NULL,
  `cm_firebase_token` varchar(191) DEFAULT NULL,
  `pos_status` tinyint(1) NOT NULL DEFAULT 0,
  `minimum_order_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `free_delivery_status` int(11) NOT NULL DEFAULT 0,
  `free_delivery_over_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `swift` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `street_address` varchar(200) DEFAULT NULL,
  `house_number` varchar(100) DEFAULT NULL,
  `postal_code` varchar(100) DEFAULT NULL,
  `date_of_birth` varchar(100) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `sex` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `f_name`, `l_name`, `phone`, `image`, `email`, `password`, `status`, `remember_token`, `created_at`, `updated_at`, `bank_name`, `branch`, `account_no`, `holder_name`, `auth_token`, `sales_commission_percentage`, `gst`, `cm_firebase_token`, `pos_status`, `minimum_order_amount`, `free_delivery_status`, `free_delivery_over_amount`, `swift`, `country`, `city`, `street_address`, `house_number`, `postal_code`, `date_of_birth`, `nationality`, `sex`) VALUES
(1, 'SEVFE', 'IMPORT', '0564646540', '2023-11-14-65536510a5938.webp', 'ginsengkianpipil.online@gmail.com', '$2y$10$dR5C.VuD/2eXyufH5.BZG.I2a0ORQ.s0bSSQVZ5AqyRdbfD3XE0Am', 'approved', 'XyBNUYHHZHT8FTU9x2QhBOuyOguxOyvk9oXVWz2YcqcjqmxI6enQEbuKjzFj', '2023-11-14 15:16:16', '2023-11-26 00:42:18', 'Ak bank', 'Branch  holida', '51616516516156165', 'abdulkader', NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'ZERDAHOME', 'HOME', '05464064506', '2023-11-15-65549c3e1ee91.webp', 'aadll4app@gmail.com', '$2y$10$egnD7jZXtwkwLHFk5Yr5G.Odcmj4Ib5G2ZM03.FGT4XqIPodpYHxK', 'approved', 'dVeORrrqiwb6saMC3oxrQSSsHT5OVOfgykJSyPAIQUAerX18uIjOX7pqB5XY', '2023-11-15 13:23:58', '2023-11-15 13:25:06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Lufian', 'Lufian', '0564654654', '2023-11-16-65565df7987ae.webp', 'drzstar.92@gmail.com', '$2y$10$m7uNCThEubbXFqRvssKHxeVBtfMIbPGa1FOZIjKuJeE9RnaOVpJ1e', 'approved', 'URQ2XIsCpRiz0kOkPTMadpCUXkrwDKKwb34bC3g0Q490HnegT4gUfrVgtMdq', '2023-11-16 21:22:47', '2023-11-16 21:24:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Almunir', 'Almunir', '0564564065', '2023-11-22-655dca680e590.webp', 'tvsoso1994@gmail.com', '$2y$10$A8CfU/rwGlg4Ugn7EZeTSOKdpAms4r9zjmTdniXqcRDVMcNeiUOki', 'approved', NULL, '2023-11-22 12:31:20', '2023-11-22 12:31:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'zahii', 'alsar', '0614370766', '2023-12-28-658cb5014c70d.webp', 'zahii7700@gmail.com', '$2y$10$MIf1E8CaPjkHdY7OSH8.AuviSoYA72p6UKCa9Nj2RsY6OsDj1VhJC', 'approved', NULL, '2023-12-28 02:36:33', '2023-12-29 00:16:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'abdulkader', 'tarrabrefaee', '0568494454', '2024-01-05-6598035f850aa.webp', 'abdulkadertarrabrefaee@gmail.com', '$2y$10$aILZTS2ofzcplcJikh9N7uYJ.DY2E0g3VvH/xbjGSgwlVq78ld1ea', 'pending', NULL, '2024-01-05 16:25:51', '2024-01-05 16:25:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Amena', 'Roman', '+1 (806) 114-3449', '2024-01-08-659c52bbf12fd.webp', 'tevetu@mailinator.com', '$2y$10$kfElf.bL9/HNQP4NtejGCOFhfZXOoxOdtt0Sak3NuLwniVkqYw4ZC', 'approved', 'dhWhASaeUXkRWPiIf4JHSJ5WcUeIekxdqg7wdkQAFfuHypfiGiiGklx1d8tb', '2024-01-08 22:53:32', '2024-01-08 22:54:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Helen', 'Hart', '+1 (207) 792-8699', '2024-01-09-659c6d6eea4e8.webp', 'vawyhecy@mailinator.com', '$2y$10$DEHPDuACY0SThiAYIi8fPuHAqi8rTSGFLjiLQ87GLrvKulLvaMfUi', 'approved', NULL, '2024-01-09 00:47:27', '2024-01-09 00:48:03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, 'MG', 'Ratione sint ut sunt', 'Dolores doloribus et', '247', 'Laborum dolorem debi', '1970-02-18', 'Asperiores ut aliqua', NULL),
(12, 'Brian', 'Buckner', '+1 (808) 338-2404', 'def.webp', 'nawazybopa@mailinator.com', '$2y$10$eqar/Te26UqW9RiWOPqw8.c/hB8AddwiRAL6AdAVvVzF.2y7.L82C', 'approved', NULL, '2024-01-11 23:27:22', '2024-01-26 21:27:02', NULL, NULL, NULL, NULL, 'IUx6X4NJjd1aUns3UgKYtf1bmvg89MpcXSWkvPHlEKDDfjvPPi', NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, 'GI', 'Neque omnis commodo', 'Vel aliquip consequa', '593', 'Fuga Fugiat molliti', '2012-06-05', 'Autem suscipit nostr', 'Female'),
(13, 'Colette', 'Jordan', '+1 (943) 845-5995', 'def.webp', 'pekajijexu@mailinator.com', '$2y$10$XmVF/v5NvYwNInbK2Xk8k.jwnaiQAbFTFYtkX/Gxkco8yXw7Rn7h.', 'approved', NULL, '2024-01-11 23:32:48', '2024-01-26 22:24:24', NULL, NULL, NULL, NULL, 'yjs5PC3pppPIsNgbdsyis3A2lpWIeDemZm9QhuyhpU0Do9zCiW', NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, 'EC', 'Labore ut fugit nul', 'Laboriosam qui atqu', '958', 'Nostrud aliqua Plac', '1983-04-25', 'Nobis facilis dolore', 'Female'),
(14, 'Cameron', 'Moreno', '+1 (221) 392-2119', 'def.webp', 'dipawat@mailinator.com', '$2y$10$bHH184AtjaoNaYfLaW5.NudJmmPC7I4tUIdFolMLcYG3C5XMSttJK', 'pending', NULL, '2024-01-17 18:35:49', '2024-01-17 18:35:49', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, 0, 0.00, NULL, 'KP', 'Voluptatem id incidu', 'Eos aliquip aute ei', '566', 'Impedit ad unde sed', '1980-11-21', 'Reprehenderit conseq', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `seller_wallets`
--

CREATE TABLE `seller_wallets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `total_earning` double NOT NULL DEFAULT 0,
  `withdrawn` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `commission_given` double(8,2) NOT NULL DEFAULT 0.00,
  `pending_withdraw` double(8,2) NOT NULL DEFAULT 0.00,
  `delivery_charge_earned` double(8,2) NOT NULL DEFAULT 0.00,
  `collected_cash` double(8,2) NOT NULL DEFAULT 0.00,
  `total_tax_collected` double(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_wallets`
--

INSERT INTO `seller_wallets` (`id`, `seller_id`, `total_earning`, `withdrawn`, `created_at`, `updated_at`, `commission_given`, `pending_withdraw`, `delivery_charge_earned`, `collected_cash`, `total_tax_collected`) VALUES
(1, 1, 0, 1.96, '2023-11-14 15:16:16', '2023-11-26 00:57:23', 0.00, 0.00, 0.00, 0.00, 0.00),
(2, 2, 0, 0, '2023-11-15 13:23:58', '2023-11-15 13:23:58', 0.00, 0.00, 0.00, 0.00, 0.00),
(3, 3, 299.35, 0, '2023-11-16 21:22:50', '2024-01-25 12:13:42', 74.00, 0.00, 0.00, 0.00, 0.00),
(4, 4, 0, 0, '2023-11-22 12:31:25', '2023-11-22 12:31:25', 0.00, 0.00, 0.00, 0.00, 0.00),
(5, 6, 0, 0, '2023-12-28 02:36:34', '2023-12-28 02:36:34', 0.00, 0.00, 0.00, 0.00, 0.00),
(6, 7, 0, 0, '2024-01-05 16:25:52', '2024-01-05 16:25:52', 0.00, 0.00, 0.00, 0.00, 0.00),
(7, 8, 0, 0, '2024-01-08 22:53:36', '2024-01-08 22:53:36', 0.00, 0.00, 0.00, 0.00, 0.00),
(8, 11, 0, 0, '2024-01-09 00:47:27', '2024-01-09 00:47:27', 0.00, 0.00, 0.00, 0.00, 0.00),
(9, 12, 0, 0, '2024-01-11 23:27:30', '2024-01-11 23:27:30', 0.00, 0.00, 0.00, 0.00, 0.00),
(10, 13, 0, 0, '2024-01-11 23:32:49', '2024-01-11 23:32:49', 0.00, 0.00, 0.00, 0.00, 0.00),
(11, 14, 0, 0, '2024-01-17 18:35:50', '2024-01-17 18:35:50', 0.00, 0.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `seller_wallet_histories`
--

CREATE TABLE `seller_wallet_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `order_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `payment` varchar(191) NOT NULL DEFAULT 'received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` varchar(15) DEFAULT NULL,
  `is_guest` tinyint(4) NOT NULL DEFAULT 0,
  `contact_person_name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address_type` varchar(20) NOT NULL DEFAULT 'home',
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `state` varchar(191) DEFAULT NULL,
  `country` varchar(191) DEFAULT NULL,
  `latitude` varchar(191) DEFAULT NULL,
  `longitude` varchar(191) DEFAULT NULL,
  `is_billing` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `customer_id`, `is_guest`, `contact_person_name`, `email`, `address_type`, `address`, `city`, `zip`, `phone`, `created_at`, `updated_at`, `state`, `country`, `latitude`, `longitude`, `is_billing`) VALUES
(1, '46', 1, 'sads', 'asdsad@sadda.com', 'home', 'awdewadasd asdas ', 'sdadas', '3213', '2343123', NULL, NULL, NULL, 'British Indian Ocean Territory', '', '', 0),
(2, '115', 1, 'rtwer', 'tvsoso1994@gmail.com', 'home', 'Randenbroekerweg 81, 3816 BE Amersfoort, Netherlands', 'istanbuk', '3242', '3242423', NULL, NULL, NULL, 'Albania', '52.15298801618823', '5.404981980517571', 0),
(3, '143', 1, 'sadas', 'asdsad@dasd.com', 'home', 'Pauwstraat 20, 3816 AV Amersfoort, Netherlands', 'eqwa', '2321', '3432423', NULL, NULL, NULL, 'Algeria', '52.15174550800625', '5.398115525439446', 0),
(4, '2', 0, 'abdulader', NULL, 'home', 'Üniversite, Bağcı Sokağı No:2, 34320 Avcılar/İstanbul, Türkiye', 'istanbul', '3424', '00905537608834', NULL, '2023-11-26 00:11:13', NULL, 'Turkey', '52.1558004', '5.3924507', 0),
(5, '0', 0, 'abdulader', NULL, 'home', 'Üniversite, Bağcı Sokağı No:2, 34320 Avcılar/İstanbul, Türkiye', 'istanbul', '3424', '00905537608834', NULL, NULL, NULL, 'Turkey', '52.1558004', '5.3924507', 0),
(6, '490', 1, 'Sas', 'aadll4app@gmail.com', 'home', 'Johannes Bosboomstraat 4, 3817 DR Amersfoort, Netherlands', 'sdfsd', '144156', '00456465456', NULL, NULL, NULL, 'Åland Islands', '52.14767452811479', '5.392772518739091', 0),
(7, '5', 0, 'abd tarab', NULL, 'home', 'P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA', 'fxvcxcv', '44444', '+880054154646', '2024-01-18 23:56:05', '2024-01-18 23:56:05', NULL, 'Bosnia and Herzegovina', '37.42199952052943', '-122.08400152623655', 0),
(8, '5', 0, 'abd tarab', NULL, 'home', 'P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA', 'tretre', '5555', '+880054154646', '2024-01-18 23:56:19', '2024-01-18 23:56:19', NULL, 'BD', '37.42199952052943', '-122.08400152623655', 1),
(9, '714', 1, 'Bdbdbb', 'abdulkadertarrabrefaee@gmail.com', 'home', 'hddbbdbd', 'bsbsbs', '63663', '+88058805585', '2024-01-22 14:23:32', '2024-01-22 14:23:32', NULL, 'Denmark', '0.0000016763806300685275', '-0.0000016763806343078613', 0),
(10, '714', 1, 'Vdvdbxb', 'abdulkadertarrabrefaee@gmail.com', 'home', 'Gürsel Mh., Namzet Sk No:15, 34400 Kâğıthane/İstanbul, Türkiye', 'hdhdhs', '63663', '+88096464686', '2024-01-22 14:24:04', '2024-01-22 14:24:04', NULL, 'de', '41.0653903103795', '28.97137340158224', 1),
(11, '712', 1, 'Gffjj', 'Dssgh@ggrr.Com', 'home', 'P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA', 'rsgg', '54444', '+88052255555', '2024-01-25 02:02:38', '2024-01-25 02:02:38', NULL, 'de', '37.42199952052943', '-122.08400152623655', 1),
(12, '712', 1, 'Ffffvv', 'Rwdgg@fdrh.Com', 'home', 'P1600 Amphitheatre Pkwy, Mountain View, CA 94043, USA', 'racc', '5433', '+244554555', '2024-01-25 02:03:15', '2024-01-25 02:03:15', NULL, 'de', '37.42199952052943', '-122.08400152623655', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) DEFAULT NULL,
  `creator_type` varchar(191) NOT NULL DEFAULT 'admin',
  `title` varchar(100) DEFAULT NULL,
  `cost` decimal(8,2) NOT NULL DEFAULT 0.00,
  `duration` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `creator_id`, `creator_type`, `title`, `cost`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'admin', 'Company Vehicle', '5.00', '2 Week', 1, '2021-05-25 20:57:04', '2021-05-25 20:57:04'),
(9, 1, 'admin', 'Free Shipping', '0.00', '4 to 6 Days', 1, '2023-11-07 23:47:14', '2023-11-07 23:47:14');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_types`
--

CREATE TABLE `shipping_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED DEFAULT NULL,
  `shipping_type` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(25) NOT NULL,
  `image` varchar(30) NOT NULL DEFAULT 'def.png',
  `bottom_banner` varchar(191) DEFAULT NULL,
  `offer_banner` varchar(255) DEFAULT NULL,
  `vacation_start_date` date DEFAULT NULL,
  `vacation_end_date` date DEFAULT NULL,
  `vacation_note` varchar(255) DEFAULT NULL,
  `vacation_status` tinyint(4) NOT NULL DEFAULT 0,
  `temporary_close` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `banner` varchar(191) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `product_category` varchar(100) DEFAULT NULL,
  `business_country` varchar(100) DEFAULT NULL,
  `business_city` varchar(100) DEFAULT NULL,
  `business_street_address` varchar(200) DEFAULT NULL,
  `business_place_number` varchar(100) DEFAULT NULL,
  `business_phone` varchar(100) DEFAULT NULL,
  `business_email` varchar(100) DEFAULT NULL,
  `optional_tax_number` varchar(100) DEFAULT NULL,
  `optional_commercial_register` varchar(100) DEFAULT NULL,
  `product_category_other` varchar(100) DEFAULT NULL,
  `business_model` varchar(150) DEFAULT NULL,
  `shipping_info` varchar(800) DEFAULT NULL,
  `company_type` varchar(100) DEFAULT NULL,
  `images_product` text DEFAULT NULL,
  `company_category_other` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `seller_id`, `name`, `address`, `contact`, `image`, `bottom_banner`, `offer_banner`, `vacation_start_date`, `vacation_end_date`, `vacation_note`, `vacation_status`, `temporary_close`, `created_at`, `updated_at`, `banner`, `company_name`, `product_category`, `business_country`, `business_city`, `business_street_address`, `business_place_number`, `business_phone`, `business_email`, `optional_tax_number`, `optional_commercial_register`, `product_category_other`, `business_model`, `shipping_info`, `company_type`, `images_product`, `company_category_other`) VALUES
(1, 1, 'SEVFE  IMPORT', 'istanbul avciler  gumus pala mh no 17 d 5', '0564646540', '2023-11-14-65536510bf830.webp', '2023-11-14-6553662b6408f.webp', NULL, NULL, NULL, NULL, 0, 0, '2023-11-14 15:16:16', '2023-11-14 15:20:59', '2023-11-14-65536510cacfb.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(2, 2, 'ZERDAHOME', 'germany no 14 d3', '05464064506', '2023-11-15-65549c3e3977f.webp', '2023-11-15-65549c3e812cd.webp', NULL, NULL, NULL, NULL, 0, 0, '2023-11-15 13:23:58', '2023-12-29 00:36:36', '2023-11-15-65549c3e423df.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(3, 3, 'Lufian', 'istanbul no23', '0564654654', '2023-11-16-65565df7af4e2.webp', '2023-11-16-65565dfaba69a.webp', NULL, NULL, NULL, NULL, 0, 0, '2023-11-16 21:22:50', '2023-11-16 21:22:50', '2023-11-16-65565df7b7626.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(4, 4, 'Almunir', 'istanbul', '0564564065', '2023-11-22-655dca6b3160b.webp', '2023-11-22-655dca6da4bed.webp', NULL, NULL, NULL, NULL, 0, 0, '2023-11-22 12:31:25', '2023-11-22 12:31:25', '2023-11-22-655dca6cb826a.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(5, 6, 'aleppo', 'Istanbul arzu sokak', '0614370766', '2023-12-28-658cb501c36eb.webp', '2023-12-28-658cb50202054.webp', NULL, NULL, NULL, NULL, 0, 0, '2023-12-28 02:36:34', '2023-12-28 02:36:34', '2023-12-28-658cb501ef15a.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(6, 7, 'Alrefaee', 'sadsa sadas', '0568494454', '2024-01-05-6598035fa029d.webp', '2024-01-05-65980360200ed.webp', NULL, NULL, NULL, NULL, 0, 0, '2024-01-05 16:25:52', '2024-01-05 16:25:52', '2024-01-05-6598035fd67be.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(7, 8, 'Vincent Knowles', 'Incidunt qui labori', '+1 (806) 114-3449', '2024-01-08-659c52bc22718.webp', '2024-01-08-659c52c06c924.webp', NULL, NULL, NULL, NULL, 0, 0, '2024-01-08 22:53:36', '2024-01-08 22:53:36', '2024-01-08-659c52bc546fb.webp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ''),
(8, 11, 'Cora Walsh', 'Excepturi labore dol', '', '2024-01-09-659c6d6f4e565.webp', '2024-01-09-659c6d6fbdbbd.webp', NULL, NULL, NULL, NULL, 0, 0, '2024-01-09 00:47:27', '2024-01-09 00:47:27', '2024-01-09-659c6d6f78279.webp', 'Clemons Bernard Co', '140', 'HT', 'Ipsum natus accusam', 'Est ipsam accusantiu', '442', '+1 (969) 516-6904', 'cogifu@mailinator.com', '421', NULL, NULL, 'Esse blanditiis ut', NULL, NULL, NULL, ''),
(9, 12, 'Hammett Mejia', 'Animi tempora iure', '', '2024-01-11-65a04f31def2c.webp', '2024-01-11-65a04f325437c.webp', NULL, NULL, NULL, NULL, 0, 0, '2024-01-11 23:27:30', '2024-01-11 23:27:30', '2024-01-11-65a04f3220655.webp', 'Armstrong Alvarado Plc', 'other', 'JP', 'Sint reprehenderit', 'Est provident vero', '581', '+1 (599) 978-1668', 'liwawaka@mailinator.com', '219', 'Necessitatibus ad de', NULL, 'Rem dicta commodo co', NULL, 'S Corporation', '[\"2024-01-11-65a04f304db23.webp\",\"2024-01-11-65a04f30b23a0.webp\",\"2024-01-11-65a04f310c3fe.webp\",\"2024-01-11-65a04f3164c2f.webp\",\"2024-01-11-65a04f31b2228.webp\"]', ''),
(10, 13, 'Nelle Sandoval', 'Maxime amet placeat', '', '2024-01-11-65a0507116ac5.webp', '2024-01-11-65a050715554a.webp', NULL, NULL, NULL, NULL, 0, 0, '2024-01-11 23:32:49', '2024-01-11 23:32:49', '2024-01-11-65a0507137481.webp', 'Horton and Petersen Trading', 'other', 'LT', 'Dolorem et eaque fac', 'Reiciendis adipisici', '527', '+1 (329) 819-5359', 'minazadyw@mailinator.com', '217', 'Illum dicta Nam ill', 'dsadasd', 'Ad dolor et et ad hi', 'Iste ut officia quis', 'Benefit Corporation', '[\"2024-01-11-65a050708108e.webp\",\"2024-01-11-65a050709ddc0.webp\",\"2024-01-11-65a05070b9a99.webp\"]', ''),
(11, 14, 'Sydney Davenport', 'Aut sunt explicabo', '', '2024-01-17-65a7f3d63e3e8.webp', '2024-01-17-65a7f3d6e83cc.webp', NULL, NULL, NULL, NULL, 0, 0, '2024-01-17 18:35:50', '2024-01-17 18:35:50', '2024-01-17-65a7f3d69502e.webp', 'Schmidt Reese Inc', '108', 'DO', 'Duis enim dolores do', 'Reprehenderit volup', '567', '+1 (822) 707-5693', 'siwasygihe@mailinator.com', '659', 'Et et esse quas volu', NULL, 'In cupiditate vero o', 'Eaque id neque quisq', 'other', '[\"2024-01-17-65a7f3d5d9bcc.webp\"]', 'sfsdfdsf');

-- --------------------------------------------------------

--
-- Table structure for table `shop_followers`
--

CREATE TABLE `shop_followers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Customer ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_medias`
--

CREATE TABLE `social_medias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `active_status` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_medias`
--

INSERT INTO `social_medias` (`id`, `name`, `link`, `icon`, `active_status`, `status`, `created_at`, `updated_at`) VALUES
(1, 'twitter', 'https://www.w3schools.com/howto/howto_css_table_responsive.asp', 'fa fa-twitter', 1, 1, '2020-12-31 21:18:03', '2020-12-31 21:18:25'),
(2, 'linkedin', 'https://dev.6amtech.com/', 'fa fa-linkedin', 1, 1, '2021-02-27 16:23:01', '2021-02-27 16:23:05'),
(3, 'google-plus', 'https://dev.6amtech.com/', 'fa fa-google-plus-square', 1, 1, '2021-02-27 16:23:30', '2021-02-27 16:23:33'),
(4, 'pinterest', 'https://dev.6amtech.com/', 'fa fa-pinterest', 1, 1, '2021-02-27 16:24:14', '2021-02-27 16:24:26'),
(5, 'instagram', 'https://dev.6amtech.com/', 'fa fa-instagram', 1, 1, '2021-02-27 16:24:36', '2021-02-27 16:24:41'),
(6, 'facebook', 'facebook.com', 'fa fa-facebook', 1, 1, '2021-02-27 19:19:42', '2021-06-11 17:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `soft_credentials`
--

CREATE TABLE `soft_credentials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `priority` varchar(15) NOT NULL DEFAULT 'low',
  `description` varchar(255) DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket_convs`
--

CREATE TABLE `support_ticket_convs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `customer_message` varchar(191) DEFAULT NULL,
  `admin_message` varchar(191) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(191) NOT NULL,
  `visit_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tag`, `visit_count`, `created_at`, `updated_at`) VALUES
(1, 'Wedding', 0, '2023-11-04 13:43:18', '2023-11-04 13:43:18'),
(2, 'Dress', 0, '2023-11-06 21:06:45', '2023-11-06 21:06:45'),
(3, 'Party', 0, '2023-11-06 21:06:45', '2023-11-06 21:06:45'),
(4, 'Jewelry Set', 0, '2023-11-07 15:35:08', '2023-11-07 15:35:08'),
(5, 'Wedding Accessories', 0, '2023-11-07 15:35:08', '2023-11-07 15:35:08'),
(6, 'Metal', 0, '2023-11-07 15:35:08', '2023-11-07 15:35:08'),
(7, 'Wedding Dress', 0, '2023-11-07 16:35:19', '2023-11-07 16:35:19'),
(8, 'Bespoke Wedding Dress', 0, '2023-11-07 16:35:19', '2023-11-07 16:35:19'),
(9, 'white', 0, '2023-11-07 16:35:19', '2023-11-07 16:35:19'),
(10, 'Shirts & Blouses', 0, '2023-11-07 17:58:08', '2023-11-07 17:58:08'),
(11, 'Top', 0, '2023-11-07 17:58:08', '2023-11-07 17:58:08'),
(12, 'Knitwears', 0, '2023-11-07 18:20:02', '2023-11-07 18:20:02'),
(13, 'blouse', 0, '2023-11-07 18:20:02', '2023-11-07 18:20:02'),
(14, 'Blouses', 0, '2023-11-07 18:27:48', '2023-11-07 18:27:48'),
(15, 'Long Sleeve Tees', 0, '2023-11-07 18:27:48', '2023-11-07 18:27:48'),
(16, 'Black', 0, '2023-11-07 18:27:48', '2023-11-07 18:27:48'),
(17, 'Pullovers', 0, '2023-11-07 21:11:34', '2023-11-07 21:11:34'),
(18, 'O-Neck Pullovers', 0, '2023-11-07 21:11:34', '2023-11-07 21:11:34'),
(19, 'Dresses', 0, '2023-11-08 19:40:09', '2023-11-08 19:40:09'),
(20, 'Long Dresses', 0, '2023-11-08 19:40:09', '2023-11-08 19:40:09'),
(21, 'Short dresses', 0, '2023-11-08 20:17:14', '2023-11-08 20:17:14'),
(22, 'Party dresses', 0, '2023-11-08 21:29:22', '2023-11-08 21:29:22'),
(23, 'Bottoms', 0, '2023-11-08 21:41:32', '2023-11-08 21:41:32'),
(24, 'pants', 0, '2023-11-08 21:41:32', '2023-11-08 21:41:32'),
(25, 'short', 0, '2023-11-08 21:49:34', '2023-11-08 21:49:34'),
(26, 'skirt', 0, '2023-11-08 22:05:44', '2023-11-08 22:05:44'),
(27, 'jeans', 0, '2023-11-08 23:56:46', '2023-11-08 23:56:46'),
(28, 'blue', 0, '2023-11-08 23:56:46', '2023-11-08 23:56:46'),
(29, 'Shirts', 0, '2023-11-09 21:40:09', '2023-11-09 21:40:09'),
(30, 'Cotton Shirt', 0, '2023-11-09 21:40:09', '2023-11-09 21:40:09'),
(31, 'Handbags', 0, '2023-11-09 21:50:10', '2023-11-09 21:50:10'),
(32, 'Bag', 0, '2023-11-09 21:50:10', '2023-11-09 21:50:10'),
(33, 'Bucket Bag', 0, '2023-11-09 21:50:10', '2023-11-09 21:50:10'),
(34, 'Massage & Relaxation', 0, '2023-11-09 22:02:39', '2023-11-09 22:02:39'),
(35, 'Relaxation', 0, '2023-11-09 22:02:39', '2023-11-09 22:02:39'),
(36, 'Relaxation Treatment', 0, '2023-11-09 22:02:39', '2023-11-09 22:02:39'),
(37, 'Kids\' Clothing', 0, '2023-11-09 22:11:56', '2023-11-09 22:11:56'),
(38, 'Kids shoes', 0, '2023-11-09 22:11:56', '2023-11-09 22:11:56'),
(39, 'Kids Gifts', 0, '2023-11-09 22:22:44', '2023-11-09 22:22:44'),
(40, 'Craft Toys', 0, '2023-11-09 22:22:44', '2023-11-09 22:22:44'),
(41, 'Toys', 0, '2023-11-09 22:22:44', '2023-11-09 22:22:44'),
(42, 'Furniture', 0, '2023-11-09 22:34:01', '2023-11-09 22:34:01'),
(43, 'Open Closets', 0, '2023-11-09 22:34:01', '2023-11-09 22:34:01'),
(44, 'Ear Piercing', 0, '2023-11-09 23:18:53', '2023-11-09 23:18:53'),
(45, 'Accessories', 0, '2023-11-09 23:18:53', '2023-11-09 23:18:53'),
(46, 'Car Seat Covers', 0, '2023-11-09 23:29:25', '2023-11-09 23:29:25'),
(47, 'Cover', 0, '2023-11-09 23:29:25', '2023-11-09 23:29:25'),
(48, 'Car', 0, '2023-11-09 23:29:25', '2023-11-09 23:29:25'),
(49, 'Blazer & Suits', 0, '2023-11-10 16:03:09', '2023-11-10 16:03:09'),
(50, 'Blazer', 0, '2023-11-10 16:03:09', '2023-11-10 16:03:09'),
(51, 'Suit Jackets', 0, '2023-11-10 16:03:09', '2023-11-10 16:03:09'),
(52, 'Wallet & ID Holder', 0, '2023-11-10 16:18:31', '2023-11-10 16:18:31'),
(53, 'Mens Wallet', 0, '2023-11-10 16:18:31', '2023-11-10 16:18:31'),
(54, 'Dental Supplies', 0, '2023-11-10 16:40:03', '2023-11-10 16:40:03'),
(55, 'Teeth Whitening Instrument', 0, '2023-11-10 16:40:03', '2023-11-10 16:40:03'),
(56, 'Feeding', 0, '2023-11-10 17:02:54', '2023-11-10 17:02:54'),
(57, 'Food', 0, '2023-11-10 17:02:54', '2023-11-10 17:02:54'),
(58, 'Baby Food', 0, '2023-11-10 17:02:54', '2023-11-10 17:02:54'),
(59, 'Living Room Furniture', 0, '2023-11-10 23:18:52', '2023-11-10 23:18:52'),
(60, 'Living Room Chairs', 0, '2023-11-10 23:18:52', '2023-11-10 23:18:52'),
(61, 'Chairs', 0, '2023-11-10 23:18:52', '2023-11-10 23:18:52'),
(62, 'Learning & Education', 0, '2023-11-10 23:29:03', '2023-11-10 23:29:03'),
(63, 'Drawing Toys', 0, '2023-11-10 23:29:03', '2023-11-10 23:29:03'),
(64, 'Necklaces', 0, '2023-11-10 23:53:23', '2023-11-10 23:53:23'),
(65, 'Women\'s Necklace', 0, '2023-11-10 23:53:23', '2023-11-10 23:53:23'),
(66, 'Car Covers', 0, '2023-11-11 00:01:45', '2023-11-11 00:01:45'),
(67, 'computer components', 0, '2023-11-11 14:25:46', '2023-11-11 14:25:46'),
(68, 'Graphics Cards', 0, '2023-11-11 14:25:46', '2023-11-11 14:25:46'),
(69, 'Leather Pants', 0, '2023-11-11 14:51:22', '2023-11-11 14:51:22'),
(70, 'Men\'s Clothing', 0, '2023-11-11 14:51:22', '2023-11-11 14:51:22'),
(71, '35', 0, '2023-11-11 14:51:22', '2023-11-11 14:51:22'),
(72, 'Travel Bags & Luggage', 0, '2023-11-11 15:41:55', '2023-11-11 15:41:55'),
(73, 'Travel Bag', 0, '2023-11-11 15:41:55', '2023-11-11 15:41:55'),
(74, 'Dental Chair Cover', 0, '2023-11-11 16:02:21', '2023-11-11 16:02:21'),
(75, 'Baby Clothing', 0, '2023-11-13 18:19:05', '2023-11-13 18:19:05'),
(76, 'Baby Bottoms', 0, '2023-11-13 18:19:05', '2023-11-13 18:19:05'),
(77, 'Dolls & Accessories', 0, '2023-11-13 18:30:03', '2023-11-13 18:30:03'),
(78, 'Dolls', 0, '2023-11-13 18:30:03', '2023-11-13 18:30:03'),
(79, 'Office Furniture', 0, '2023-11-13 18:45:58', '2023-11-13 18:45:58'),
(80, 'Filing Cabinets', 0, '2023-11-13 18:45:58', '2023-11-13 18:45:58'),
(81, 'Digital Watches', 0, '2023-11-13 19:03:01', '2023-11-13 19:03:01'),
(82, 'Watches', 0, '2023-11-13 19:03:01', '2023-11-13 19:03:01'),
(83, 'Car Repair Tools', 0, '2023-11-13 23:47:46', '2023-11-13 23:47:46'),
(84, 'Inspection Tools', 0, '2023-11-13 23:47:46', '2023-11-13 23:47:46'),
(85, 'Cars', 0, '2023-11-13 23:47:46', '2023-11-13 23:47:46'),
(86, 'Tablets', 0, '2023-11-14 00:02:49', '2023-11-14 00:02:49'),
(87, 'Drawing Tablet', 0, '2023-11-14 00:02:49', '2023-11-14 00:02:49'),
(88, 'Jackets', 0, '2023-11-14 22:30:05', '2023-11-14 22:30:05'),
(89, 'Leather Coat', 0, '2023-11-14 22:30:05', '2023-11-14 22:30:05'),
(90, 'Coat', 0, '2023-11-14 22:30:05', '2023-11-14 22:30:05'),
(91, 'Fascia gun', 0, '2023-11-14 22:57:37', '2023-11-14 22:57:37'),
(92, 'Message', 0, '2023-11-14 22:57:37', '2023-11-14 22:57:37'),
(93, 'Baby Care', 0, '2023-11-14 23:08:27', '2023-11-14 23:08:27'),
(94, 'Baby Wet Wipes', 0, '2023-11-14 23:08:27', '2023-11-14 23:08:27'),
(95, 'shoes', 0, '2023-11-14 23:35:58', '2023-11-14 23:35:58'),
(96, 'Women\'s Casual shoes', 0, '2023-11-14 23:35:58', '2023-11-14 23:35:58'),
(97, 'Stuffed Animals', 0, '2023-11-15 13:00:03', '2023-11-15 13:00:03'),
(98, 'Plush Backpacks', 0, '2023-11-15 13:00:03', '2023-11-15 13:00:03'),
(99, 'Bags', 0, '2023-11-15 13:00:03', '2023-11-15 13:00:03'),
(100, 'Tables', 0, '2023-11-15 14:32:39', '2023-11-15 14:32:39'),
(101, 'Body Jewelry', 0, '2023-11-15 14:56:57', '2023-11-15 14:56:57'),
(102, 'Dental Grill', 0, '2023-11-15 14:56:57', '2023-11-15 14:56:57'),
(103, 'Tools', 0, '2023-11-15 15:04:12', '2023-11-15 15:04:12'),
(104, 'smart phone', 0, '2023-11-15 15:21:50', '2023-11-15 15:21:50'),
(105, 'Samsung', 0, '2023-11-15 15:21:50', '2023-11-15 15:21:50'),
(106, 'Foods', 0, '2023-11-15 15:44:00', '2023-11-15 15:44:00'),
(107, 'Meat', 0, '2023-11-15 15:44:00', '2023-11-15 15:44:00'),
(108, 'Fruits', 0, '2023-11-15 18:18:28', '2023-11-15 18:18:28'),
(109, 'Mandarin', 0, '2023-11-15 18:18:28', '2023-11-15 18:18:28'),
(110, 'orange', 0, '2023-11-15 18:18:28', '2023-11-15 18:18:28'),
(111, 'beverages', 0, '2023-11-15 18:25:52', '2023-11-15 18:25:52'),
(112, 'water', 0, '2023-11-15 18:25:52', '2023-11-15 18:25:52'),
(113, 'Bottle', 0, '2023-11-15 18:25:52', '2023-11-15 18:25:52'),
(114, 'Laptop', 0, '2023-11-15 18:33:00', '2023-11-15 18:33:00'),
(115, 'computer', 0, '2023-11-15 18:33:00', '2023-11-15 18:33:00'),
(116, 'snacks', 0, '2023-11-16 18:08:49', '2023-11-16 18:08:49'),
(117, 'chips', 0, '2023-11-16 18:08:49', '2023-11-16 18:08:49'),
(118, 'milk & dairy', 0, '2023-11-16 18:45:09', '2023-11-16 18:45:09'),
(119, 'Milk', 0, '2023-11-16 18:45:09', '2023-11-16 18:45:09'),
(120, 'breakfast', 0, '2023-11-16 18:50:20', '2023-11-16 18:50:20'),
(121, 'Eggs', 0, '2023-11-16 18:50:20', '2023-11-16 18:50:20'),
(122, 'organic', 0, '2023-11-16 18:50:20', '2023-11-16 18:50:20'),
(123, 'Outdoor Furniture', 0, '2023-11-16 19:00:03', '2023-11-16 19:00:03'),
(124, 'Garden Furniture Sets', 0, '2023-11-16 19:00:03', '2023-11-16 19:00:03'),
(125, 'Shirt Jacket', 0, '2023-11-16 19:18:17', '2023-11-16 19:18:17'),
(126, 'Square Bag', 0, '2023-11-16 19:27:41', '2023-11-16 19:27:41'),
(127, 'chickens', 0, '2023-11-16 19:38:25', '2023-11-16 19:38:25'),
(128, 'ready to eat', 0, '2023-11-16 19:38:25', '2023-11-16 19:38:25'),
(129, 'Makeup', 0, '2023-11-17 21:59:31', '2023-11-17 21:59:31'),
(130, 'Makeup Brushes', 0, '2023-11-17 21:59:31', '2023-11-17 21:59:31'),
(131, 'Baby Shoes', 0, '2023-11-17 22:28:54', '2023-11-17 22:28:54'),
(132, 'Casual Shoes', 0, '2023-11-17 22:28:54', '2023-11-17 22:28:54'),
(133, 'Sunglasses', 0, '2023-11-18 19:22:27', '2023-11-18 19:22:27'),
(134, 'Women\'s Sunglasses', 0, '2023-11-18 19:22:27', '2023-11-18 19:22:27'),
(135, 'Motorcycle Parts', 0, '2023-11-18 19:33:48', '2023-11-18 19:33:48'),
(136, 'Engine Parts', 0, '2023-11-18 19:33:48', '2023-11-18 19:33:48'),
(137, '40', 0, '2023-11-18 19:33:48', '2023-11-18 19:33:48'),
(138, 'Advanced Storage & Ram', 0, '2023-11-20 17:16:02', '2023-11-20 17:16:02'),
(139, 'Messenger Bag', 0, '2023-11-20 17:33:38', '2023-11-20 17:33:38'),
(140, 'Dentist set', 0, '2023-11-20 17:43:17', '2023-11-20 17:43:17'),
(141, 'soda', 0, '2023-11-20 19:07:11', '2023-11-20 19:07:11'),
(142, 'Consequatur Ipsum v', 0, '2024-01-12 04:25:28', '2024-01-12 04:25:28');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `payment_for` varchar(100) DEFAULT NULL,
  `payer_id` bigint(20) DEFAULT NULL,
  `payment_receiver_id` bigint(20) DEFAULT NULL,
  `paid_by` varchar(15) DEFAULT NULL,
  `paid_to` varchar(15) DEFAULT NULL,
  `payment_method` varchar(15) DEFAULT NULL,
  `payment_status` varchar(10) NOT NULL DEFAULT 'success',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `transaction_type` varchar(191) DEFAULT NULL,
  `order_details_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `translationable_type` varchar(191) NOT NULL,
  `translationable_id` bigint(20) UNSIGNED NOT NULL,
  `locale` varchar(191) NOT NULL,
  `key` varchar(191) DEFAULT NULL,
  `value` text DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`translationable_type`, `translationable_id`, `locale`, `key`, `value`, `id`) VALUES
('App\\Model\\Category', 2, 'nl', 'name', 'Dameskleding', 1),
('App\\Model\\Category', 2, 'de', 'name', 'Damenbekleidung', 2),
('App\\Model\\Category', 3, 'nl', 'name', 'Herenkleding', 3),
('App\\Model\\Category', 3, 'de', 'name', 'Herrenbekleidung', 4),
('App\\Model\\Category', 4, 'nl', 'name', 'Schoenen', 5),
('App\\Model\\Category', 4, 'de', 'name', 'Schuhe', 6),
('App\\Model\\Category', 5, 'nl', 'name', 'Schoonheid & Gezondheid', 7),
('App\\Model\\Category', 5, 'de', 'name', 'Schönheit & Gesundheit', 8),
('App\\Model\\Category', 7, 'nl', 'name', 'Speelgoed & Spellen', 9),
('App\\Model\\Category', 7, 'de', 'name', 'Spielzeug & Spiele', 10),
('App\\Model\\Category', 8, 'nl', 'name', 'Meubilair', 11),
('App\\Model\\Category', 8, 'de', 'name', 'Möbel', 12),
('App\\Model\\Category', 9, 'nl', 'name', 'Sieraden, Horloges & Accessoires', 13),
('App\\Model\\Category', 9, 'de', 'name', 'Schmuck, Uhren & Accessoires', 14),
('App\\Model\\Category', 10, 'nl', 'name', 'Auto & Motorfiets', 15),
('App\\Model\\Category', 10, 'de', 'name', 'Auto & Motorrad', 16),
('App\\Model\\Category', 11, 'nl', 'name', 'Elektronica', 17),
('App\\Model\\Category', 11, 'de', 'name', 'Elektronik', 18),
('App\\Model\\Attribute', 1, 'nl', 'name', 'Maat', 21),
('App\\Model\\Attribute', 1, 'de', 'name', 'Größe', 22),
('App\\Model\\Attribute', 2, 'nl', 'name', 'Materiaal', 23),
('App\\Model\\Attribute', 2, 'de', 'name', 'Material', 24),
('App\\Model\\Attribute', 3, 'nl', 'name', 'Volume', 25),
('App\\Model\\Attribute', 3, 'de', 'name', 'Volumen', 26),
('App\\Model\\Attribute', 4, 'nl', 'name', 'Huidtype', 27),
('App\\Model\\Attribute', 4, 'de', 'name', 'Hauttyp', 28),
('App\\Model\\Attribute', 5, 'nl', 'name', 'Tint', 29),
('App\\Model\\Attribute', 5, 'de', 'name', 'Farbton', 30),
('App\\Model\\Attribute', 6, 'nl', 'name', 'Leeftijdsklasse', 31),
('App\\Model\\Attribute', 6, 'de', 'name', 'Altersgruppe', 32),
('App\\Model\\Attribute', 7, 'nl', 'name', 'Wattage', 33),
('App\\Model\\Attribute', 7, 'de', 'name', 'Wattzahl', 34),
('App\\Model\\Attribute', 8, 'nl', 'name', 'Motorinhoud', 35),
('App\\Model\\Attribute', 8, 'de', 'name', 'Motorgröße', 36),
('App\\Model\\Attribute', 9, 'nl', 'name', 'Bouwjaar', 37),
('App\\Model\\Attribute', 9, 'de', 'name', 'Baujahr', 38),
('App\\Model\\Attribute', 10, 'nl', 'name', 'Edelsteen', 39),
('App\\Model\\Attribute', 10, 'de', 'name', 'Edelstein', 40),
('App\\Model\\Attribute', 11, 'nl', 'name', 'Opslagcapaciteit', 41),
('App\\Model\\Attribute', 11, 'de', 'name', 'Speicherkapazität', 42),
('App\\Model\\Attribute', 12, 'nl', 'name', 'RAM', 43),
('App\\Model\\Attribute', 12, 'de', 'name', 'RAM', 44),
('App\\Model\\Attribute', 13, 'nl', 'name', 'Processor', 45),
('App\\Model\\Attribute', 13, 'de', 'name', 'Prozessor', 46),
('App\\Model\\Attribute', 14, 'nl', 'name', 'Lengte', 47),
('App\\Model\\Attribute', 14, 'de', 'name', 'Länge', 48),
('App\\Model\\Attribute', 15, 'nl', 'name', 'Type', 49),
('App\\Model\\Attribute', 15, 'de', 'name', 'Typ', 50),
('App\\Model\\Attribute', 16, 'nl', 'name', 'Hoogte', 51),
('App\\Model\\Attribute', 16, 'de', 'name', 'Höhe', 52),
('App\\Model\\Attribute', 18, 'nl', 'name', 'Human Hair Type', 53),
('App\\Model\\Attribute', 18, 'de', 'name', 'Human Hair Type', 54),
('App\\Model\\Attribute', 19, 'nl', 'name', 'Base Material', 55),
('App\\Model\\Attribute', 19, 'de', 'name', 'Base Material', 56),
('App\\Model\\Attribute', 20, 'nl', 'name', 'Color of Lace', 57),
('App\\Model\\Attribute', 20, 'de', 'name', 'Color of Lace', 58),
('App\\Model\\Attribute', 21, 'nl', 'name', 'Frame Color', 59),
('App\\Model\\Attribute', 21, 'de', 'name', 'Frame Color', 60),
('App\\Model\\Attribute', 22, 'nl', 'name', 'Lenses Color', 61),
('App\\Model\\Attribute', 22, 'de', 'name', 'Lenses Color', 62),
('App\\Model\\Attribute', 23, 'nl', 'name', 'Power (W)', 63),
('App\\Model\\Attribute', 23, 'de', 'name', 'Power (W)', 64),
('App\\Model\\Attribute', 24, 'nl', 'name', 'Voltage (V)', 65),
('App\\Model\\Attribute', 24, 'de', 'name', 'Voltage (V)', 66),
('App\\Model\\Attribute', 25, 'nl', 'name', 'Liter', 67),
('App\\Model\\Attribute', 25, 'de', 'name', 'Liter', 68),
('App\\Model\\Category', 14, 'nl', 'name', 'Overhemden', 69),
('App\\Model\\Category', 14, 'de', 'name', 'Hemden', 70),
('App\\Model\\Category', 15, 'nl', 'name', 'Blazers en Pakken', 71),
('App\\Model\\Category', 15, 'de', 'name', 'Blazer und Anzüge', 72),
('App\\Model\\Category', 16, 'nl', 'name', 'Bruidsjurk', 73),
('App\\Model\\Category', 16, 'de', 'name', 'Hochzeitskleid', 74),
('App\\Model\\Brand', 1, 'nl', 'name', 'Adidas', 75),
('App\\Model\\Brand', 1, 'de', 'name', 'Adidas', 76),
('App\\Model\\Product', 111, 'nl', 'name', 'Sierlijke off-the-shoulder bruidsjurk met lange mouwen en sprankelende kristallen kralen trouwjurk Luxe lange bruidsjurk Robe De Mariée', 77),
('App\\Model\\Product', 111, 'nl', 'description', '<p>Welkom bij DMDRS Bruiloftsfeestwinkel</p>\r\n\r\n<p>Warme tips:<br />\r\n1: De jurk wordt op bestelling gemaakt. We raden klanten aan om minimaal 2 maanden eerder te bestellen, zodat er meer tijd overblijft voor productie en verzending.<br />\r\n2.De levertijd is afhankelijk van de door u gekozen verzendmethoden.<br />\r\n3. Stuur mij van tevoren een bericht met uw deadline of vermeld eventuele tijdgevoelige verzoeken in het notitievak van de bestelling bij het afrekenen.<br />\r\n4.!!!Na het plaatsen van uw bestelling heeft u nog EEN DAG om van gedachten te veranderen of bevestig dit ruim voordat u de bestelling plaatst. Zodra het maatwerkproces is begonnen, kunnen de materialen niet meer worden hergebruikt. Het halverwege annuleren van bestellingen levert ons veel verliezen op, aangezien al onze jurken niet op voorraad zijn, maar gloednieuw en op maat gemaakt voor elke bestelling.<br />\r\n5.!!! Wij bieden spoedorderservice voor alle producten. Als er sprake is van een spoedbestelling, raden wij u ten zeerste aan contact met ons op te nemen voordat u de bestelling plaatst, om foutschattingen te voorkomen.</p>', 78),
('App\\Model\\Product', 111, 'de', 'name', 'Anmutiges, schulterfreies, langärmliges Brautgewand, funkelndes Kristallperlen-Hochzeitskleid, luxuriöses langes Brautkleid, Robe De Mariée', 79),
('App\\Model\\Product', 111, 'de', 'description', '<p>Willkommen im DMDRS Wedding Party Store</p>\r\n\r\n<p>Warme Tipps:<br />\r\n1: Das Kleid wird auf Bestellung gefertigt. Wir empfehlen Kunden, mindestens 2 Monate fr&uuml;her zu bestellen, um mehr Zeit f&uuml;r Produktion und Versand zu haben.<br />\r\n2. Die Lieferzeit h&auml;ngt von der von Ihnen gew&auml;hlten Versandart ab.<br />\r\n3. Bitte teilen Sie mir Ihre Frist im Voraus mit oder geben Sie zeitkritische W&uuml;nsche im Notizfeld der Bestellung an der Kasse an.<br />\r\n4.!!!Nachdem Sie Ihre Bestellung aufgegeben haben, haben Sie noch EINEN TAG Zeit, um Ihre Meinung zu &auml;ndern. Bitte best&auml;tigen Sie dies rechtzeitig, bevor Sie die Bestellung aufgeben. Sobald der Schneiderprozess begonnen hat, k&ouml;nnen die Materialien nicht wiederverwendet werden. Wenn wir Bestellungen auf halbem Weg stornieren, werden wir gro&szlig;e Verluste erleiden, da alle unsere Kleider nicht auf Lager sind, sondern brandneu und f&uuml;r jede Bestellung individuell angefertigt werden.<br />\r\n5.!!!Wir bieten einen Eilbestellservice f&uuml;r alle Produkte an. Wenn es sich um eine Eilbestellung handelt, empfehlen wir Ihnen dringend, vor der Bestellung Kontakt mit uns aufzunehmen, um Fehlersch&auml;tzungen zu vermeiden.</p>', 80),
('App\\Model\\Category', 17, 'nl', 'name', 'Woonkamermeubilair', 81),
('App\\Model\\Category', 17, 'de', 'name', 'Wohnzimmermöbel', 82),
('App\\Model\\Category', 18, 'nl', 'name', 'Woonkamerstoelen', 83),
('App\\Model\\Category', 18, 'de', 'name', 'Wohnzimmerstühle', 84),
('App\\Model\\Category', 19, 'nl', 'name', 'Onderkleding', 85),
('App\\Model\\Category', 19, 'de', 'name', 'Unterkleidung', 86),
('App\\Model\\Category', 20, 'nl', 'name', 'broek', 87),
('App\\Model\\Category', 20, 'de', 'name', 'Hose', 88),
('App\\Model\\Category', 21, 'nl', 'name', 'kort', 89),
('App\\Model\\Category', 21, 'de', 'name', 'kurz', 90),
('App\\Model\\Category', 22, 'nl', 'name', 'rok', 91),
('App\\Model\\Category', 22, 'de', 'name', 'Rock', 92),
('App\\Model\\Category', 23, 'nl', 'name', 'jeans', 93),
('App\\Model\\Category', 23, 'de', 'name', 'Jeans', 94),
('App\\Model\\Category', 24, 'nl', 'name', 'bruiloft feestjurk', 95),
('App\\Model\\Category', 24, 'de', 'name', 'Hochzeitsfestkleid', 96),
('App\\Model\\Category', 25, 'nl', 'name', 'trouwjurken', 97),
('App\\Model\\Category', 25, 'de', 'name', 'Hochzeitskleider', 98),
('App\\Model\\Category', 26, 'nl', 'name', 'Bruiloft accessoires', 99),
('App\\Model\\Category', 26, 'de', 'name', 'Hochzeitszubehör', 100),
('App\\Model\\Category', 27, 'nl', 'name', 'Op maat gemaakte trouwjurk', 101),
('App\\Model\\Category', 27, 'de', 'name', 'Maßgeschneidertes Hochzeitskleid', 102),
('App\\Model\\Category', 28, 'nl', 'name', 'Bovenkanten', 103),
('App\\Model\\Category', 28, 'de', 'name', 'Oberteile', 104),
('App\\Model\\Category', 29, 'nl', 'name', 'Overhemden en blouses', 105),
('App\\Model\\Category', 29, 'de', 'name', 'Hemden und Blusen', 106),
('App\\Model\\Category', 30, 'nl', 'name', 'Gebreide kleding', 107),
('App\\Model\\Category', 30, 'de', 'name', 'Strickwaren', 108),
('App\\Model\\Category', 31, 'nl', 'name', 'T-shirts met lange mouwen', 109),
('App\\Model\\Category', 31, 'de', 'name', 'Langarm-T-Shirts', 110),
('App\\Model\\Category', 32, 'nl', 'name', 'Truien met O-hals', 111),
('App\\Model\\Category', 32, 'de', 'name', 'Pullover mit O-Ausschnitt', 112),
('App\\Model\\Category', 33, 'nl', 'name', 'jurken', 113),
('App\\Model\\Category', 33, 'de', 'name', 'Kleider', 114),
('App\\Model\\Category', 34, 'nl', 'name', 'Lange jurken', 115),
('App\\Model\\Category', 34, 'de', 'name', 'Lange Kleider', 116),
('App\\Model\\Category', 35, 'nl', 'name', 'korte jurkjes', 117),
('App\\Model\\Category', 35, 'de', 'name', 'kurze Kleider', 118),
('App\\Model\\Category', 36, 'nl', 'name', 'Feestjurken', 119),
('App\\Model\\Category', 36, 'de', 'name', 'Party kleider', 120),
('App\\Model\\Category', 37, 'nl', 'name', 'Midi-jurken', 121),
('App\\Model\\Category', 37, 'de', 'name', 'Midi-Kleider', 122),
('App\\Model\\Category', 42, 'nl', 'name', 'Broek', 131),
('App\\Model\\Category', 42, 'de', 'name', 'Hose', 132),
('App\\Model\\Category', 43, 'nl', 'name', 'Jassen', 133),
('App\\Model\\Category', 43, 'de', 'name', 'Jacken', 134),
('App\\Model\\Category', 44, 'nl', 'name', 'Katoenen shirt', 135),
('App\\Model\\Category', 44, 'de', 'name', 'Baumwoll-Shirt', 136),
('App\\Model\\Category', 48, 'nl', 'name', 'Colberts', 137),
('App\\Model\\Category', 48, 'de', 'name', 'Anzugjacken', 138),
('App\\Model\\Category', 49, 'nl', 'name', 'Pakken', 139),
('App\\Model\\Category', 49, 'de', 'name', 'Anzüge', 140),
('App\\Model\\Category', 51, 'nl', 'name', 'Kostuumbroek', 143),
('App\\Model\\Category', 51, 'de', 'name', 'Anzughosen', 144),
('App\\Model\\Category', 52, 'nl', 'name', 'AnzughosenLeren broek', 145),
('App\\Model\\Category', 52, 'de', 'name', 'Lederhosen', 146),
('App\\Model\\Category', 53, 'nl', 'name', 'Potlood broek', 147),
('App\\Model\\Category', 53, 'de', 'name', 'Bleistifthosen', 148),
('App\\Model\\Category', 54, 'nl', 'name', 'Casual broek', 149),
('App\\Model\\Category', 54, 'de', 'name', 'Freizeithosen', 150),
('App\\Model\\Category', 55, 'nl', 'name', 'Rechte broek', 151),
('App\\Model\\Category', 55, 'de', 'name', 'Gerade Hosen', 152),
('App\\Model\\Category', 56, 'nl', 'name', 'Leren jas', 153),
('App\\Model\\Category', 56, 'de', 'name', 'Lederjacke', 154),
('App\\Model\\Category', 57, 'nl', 'name', 'Honkbaluniform', 155),
('App\\Model\\Category', 57, 'de', 'name', 'Baseballuniform', 156),
('App\\Model\\Category', 58, 'nl', 'name', 'Vest', 157),
('App\\Model\\Category', 58, 'de', 'name', 'Weste', 158),
('App\\Model\\Category', 59, 'nl', 'name', 'Geul', 159),
('App\\Model\\Category', 59, 'de', 'name', 'Graben', 160),
('App\\Model\\Category', 62, 'nl', 'name', 'Slaapkamermeubilair', 165),
('App\\Model\\Category', 62, 'de', 'name', 'Schlafzimmermöbel', 166),
('App\\Model\\Category', 63, 'nl', 'name', 'Kantoormeubelen', 167),
('App\\Model\\Category', 63, 'de', 'name', 'Büromöbel', 168),
('App\\Model\\Category', 64, 'nl', 'name', 'Buitenkmeubelen', 169),
('App\\Model\\Category', 64, 'de', 'name', 'Gartenmöbel', 170),
('App\\Model\\Category', 65, 'nl', 'name', 'Buitenmeubels', 171),
('App\\Model\\Category', 65, 'de', 'name', 'Gartenmöbel', 172),
('App\\Model\\Category', 66, 'nl', 'name', 'Woonkamerkasten', 173),
('App\\Model\\Category', 66, 'de', 'name', 'Wohnzimmerschränke', 174),
('App\\Model\\Category', 67, 'nl', 'name', 'Offene Schränke', 175),
('App\\Model\\Category', 67, 'de', 'name', 'Offene Schränke', 176),
('App\\Model\\Category', 68, 'nl', 'name', 'Hoofdborden', 177),
('App\\Model\\Category', 68, 'de', 'name', 'Kopfteile', 178),
('App\\Model\\Category', 69, 'nl', 'name', 'Nachtkastjes', 179),
('App\\Model\\Category', 69, 'de', 'name', 'Nachttische', 180),
('App\\Model\\Category', 70, 'nl', 'name', 'Dossierkasten', 181),
('App\\Model\\Category', 70, 'de', 'name', 'Aktenschränke', 182),
('App\\Model\\Category', 71, 'nl', 'name', 'Computerbureaus', 183),
('App\\Model\\Category', 71, 'de', 'name', 'Computertische', 184),
('App\\Model\\Category', 72, 'nl', 'name', 'Bureaustoelen', 185),
('App\\Model\\Category', 72, 'de', 'name', 'Bürostühle', 186),
('App\\Model\\Category', 73, 'nl', 'name', 'Tuinmeubelsets', 187),
('App\\Model\\Category', 73, 'de', 'name', 'Gartenmöbel-Sets', 188),
('App\\Model\\Category', 74, 'nl', 'name', 'Strandstoelen', 189),
('App\\Model\\Category', 74, 'de', 'name', 'Liegestühle', 190),
('App\\Model\\Category', 75, 'nl', 'name', 'Hangmatten', 191),
('App\\Model\\Category', 75, 'de', 'name', 'Hängematten', 192),
('App\\Model\\Product', 112, 'nl', 'name', 'XUIBOL Elegante korte mouw jurk V-hals blauw pailletten avondjurk tule bruiloft prom cocktailjurken voor vrouwen vestido', 193),
('App\\Model\\Product', 112, 'nl', 'description', '<p>XUIBOL Elegante korte mouw jurk V-hals blauw pailletten avondjurk tule bruiloft prom cocktailjurken voor vrouwen vestido</p>', 194),
('App\\Model\\Product', 112, 'de', 'name', 'XUIBOL Elegante Kurzarm Kleid V-ausschnitt Blau Pailletten Abendkleid Tüll Hochzeit Party Prom Cocktail Kleider Für Frauen Vestido', 195),
('App\\Model\\Product', 112, 'de', 'description', '<p>XUIBOL Elegante Kurzarm Kleid V-ausschnitt Blau Pailletten Abendkleid T&uuml;ll Hochzeit Party Prom Cocktail Kleider F&uuml;r Frauen Vestido</p>', 196),
('App\\Model\\Category', 76, 'nl', 'name', 'Handtassen', 197),
('App\\Model\\Category', 76, 'de', 'name', 'Handtaschen', 198),
('App\\Model\\Category', 77, 'nl', 'name', '\"Portemonnee en ID-Houder', 199),
('App\\Model\\Category', 77, 'de', 'name', 'Geldbörse und Ausweishülle', 200),
('App\\Model\\Category', 78, 'nl', 'name', 'Reistassen en bagage', 201),
('App\\Model\\Category', 78, 'de', 'name', 'Reisetaschen und Gepäck', 202),
('App\\Model\\Category', 80, 'nl', 'name', 'Emmer tas', 205),
('App\\Model\\Category', 80, 'de', 'name', 'Beuteltasche', 206),
('App\\Model\\Category', 81, 'nl', 'name', 'Vierkante tas', 207),
('App\\Model\\Category', 81, 'de', 'name', 'Quadratische Tasche', 208),
('App\\Model\\Category', 82, 'nl', 'name', 'Koerierstas', 209),
('App\\Model\\Category', 82, 'de', 'name', 'Umhängetasche', 210),
('App\\Model\\Category', 83, 'nl', 'name', 'Herenportemonnee met ritssluiting', 211),
('App\\Model\\Category', 83, 'de', 'name', 'Herren-Geldbörse mit Reißverschluss', 212),
('App\\Model\\Category', 84, 'nl', 'name', 'Reisportefeuilles', 213),
('App\\Model\\Category', 84, 'de', 'name', 'Reisebrieftaschen', 214),
('App\\Model\\Category', 85, 'nl', 'name', 'Opvouwbare portemonnee voor dames', 215),
('App\\Model\\Category', 85, 'de', 'name', 'Faltbrieftasche für Damen', 216),
('App\\Model\\Category', 86, 'nl', 'name', 'Reistas', 217),
('App\\Model\\Category', 86, 'de', 'name', 'Reisetasche', 218),
('App\\Model\\Category', 87, 'nl', 'name', 'Grote bagage', 219),
('App\\Model\\Category', 87, 'de', 'name', 'Großes Gepäck', 220),
('App\\Model\\Category', 88, 'nl', 'name', 'Grote bagage', 221),
('App\\Model\\Category', 88, 'de', 'name', 'Großes Gepäck', 222),
('App\\Model\\Category', 89, 'nl', 'name', 'Casual damesschoenen', 223),
('App\\Model\\Category', 89, 'de', 'name', 'Freizeitschuhe für Damen', 224),
('App\\Model\\Category', 90, 'nl', 'name', 'Casual schoenen voor heren', 225),
('App\\Model\\Category', 90, 'de', 'name', 'Freizeitschuhe für Herren', 226),
('App\\Model\\Category', 93, 'nl', 'name', 'Massage & Ontspanning', 231),
('App\\Model\\Category', 93, 'de', 'name', 'Massage & Entspannung', 232),
('App\\Model\\Category', 94, 'nl', 'name', 'Nagelkunst', 233),
('App\\Model\\Category', 94, 'de', 'name', 'Nagel Kunst', 234),
('App\\Model\\Category', 95, 'nl', 'name', 'Tandheelkundige Benodigdheden', 235),
('App\\Model\\Category', 95, 'de', 'name', 'Dentalbedarf', 236),
('App\\Model\\Category', 96, 'nl', 'name', 'Ontspanningsbehandeling', 237),
('App\\Model\\Category', 96, 'de', 'name', 'Entspannungsbehandlung', 238),
('App\\Model\\Category', 97, 'nl', 'name', 'Oogmassage-instrument', 239),
('App\\Model\\Category', 97, 'de', 'name', 'Augenmassageinstrument', 240),
('App\\Model\\Category', 98, 'nl', 'name', 'Massageroller', 241),
('App\\Model\\Category', 98, 'de', 'name', 'Massagerolle', 242),
('App\\Model\\Category', 100, 'nl', 'name', 'Nagel kunst', 245),
('App\\Model\\Category', 100, 'de', 'name', 'Nagel Kunst', 246),
('App\\Model\\Category', 101, 'nl', 'name', 'Nagelsets en -kits', 247),
('App\\Model\\Category', 101, 'de', 'name', 'Nagelsets und -kits', 248),
('App\\Model\\Category', 102, 'nl', 'name', 'Instrument voor het bleken van tanden', 249),
('App\\Model\\Category', 102, 'de', 'name', 'Instrument zur Zahnaufhellung', 250),
('App\\Model\\Category', 103, 'nl', 'name', 'Tandartsstoelhoes', 251),
('App\\Model\\Category', 103, 'de', 'name', 'Zahnarztstuhlbezug', 252),
('App\\Model\\Category', 105, 'nl', 'name', 'Kinderkleding', 255),
('App\\Model\\Category', 105, 'de', 'name', 'Kinderkleidung', 256),
('App\\Model\\Category', 106, 'nl', 'name', 'Voeding', 257),
('App\\Model\\Category', 106, 'de', 'name', 'Füttern', 258),
('App\\Model\\Category', 107, 'nl', 'name', 'Babykleding', 259),
('App\\Model\\Category', 107, 'de', 'name', 'Baby Kleidung', 260),
('App\\Model\\Category', 108, 'nl', 'name', 'Babyverzorging', 261),
('App\\Model\\Category', 108, 'de', 'name', 'Säuglingspflege', 262),
('App\\Model\\Category', 109, 'nl', 'name', 'Canvasschoen voor kinderen', 263),
('App\\Model\\Category', 109, 'de', 'name', 'Kinder-Leinenschuh', 264),
('App\\Model\\Category', 110, 'nl', 'name', 'Poloshirt', 265),
('App\\Model\\Category', 110, 'de', 'name', 'Polo-Shirts', 266),
('App\\Model\\Category', 111, 'nl', 'name', 'Bovenkleding', 267),
('App\\Model\\Category', 111, 'de', 'name', 'Oberbekleidung', 268),
('App\\Model\\Category', 112, 'nl', 'name', 'Babyvoedingfabrieken', 269),
('App\\Model\\Category', 112, 'de', 'name', 'Babynahrungsmühlen', 270),
('App\\Model\\Category', 113, 'nl', 'name', 'Kopjes', 271),
('App\\Model\\Category', 113, 'de', 'name', 'Tassen', 272),
('App\\Model\\Category', 114, 'nl', 'name', 'Flessen', 273),
('App\\Model\\Category', 114, 'de', 'name', 'Flaschen', 274),
('App\\Model\\Category', 115, 'nl', 'name', 'Babybroekjes', 275),
('App\\Model\\Category', 115, 'de', 'name', 'Babyhosen', 276),
('App\\Model\\Category', 116, 'nl', 'name', 'Babyzwemkleding', 277),
('App\\Model\\Category', 116, 'de', 'name', 'Babybadebekleidung', 278),
('App\\Model\\Category', 117, 'nl', 'name', 'Babytopjes', 279),
('App\\Model\\Category', 117, 'de', 'name', 'Babyoberteile', 280),
('App\\Model\\Category', 118, 'nl', 'name', 'Babydoekjes', 281),
('App\\Model\\Category', 118, 'de', 'name', 'Feuchttücher für Babys', 282),
('App\\Model\\Category', 119, 'nl', 'name', 'Hulpmiddelen voor babyverzorging', 283),
('App\\Model\\Category', 119, 'de', 'name', 'Babypflege-Tools', 284),
('App\\Model\\Category', 120, 'nl', 'name', 'Haarverzorging', 285),
('App\\Model\\Category', 120, 'de', 'name', 'Haarpflege', 286),
('App\\Model\\Category', 121, 'nl', 'name', 'Kinder cadeaus', 287),
('App\\Model\\Category', 121, 'de', 'name', 'Haarpflege', 288),
('App\\Model\\Category', 122, 'nl', 'name', 'Leren & Onderwijsv', 289),
('App\\Model\\Category', 122, 'de', 'name', 'Lernen und Bildung', 290),
('App\\Model\\Category', 123, 'nl', 'name', 'Poppen en Accessoires', 291),
('App\\Model\\Category', 123, 'de', 'name', 'Lernen und Bildung', 292),
('App\\Model\\Category', 124, 'nl', 'name', 'Voedsel & Drank', 293),
('App\\Model\\Category', 124, 'de', 'name', 'Lebensmittel & Getränke', 294),
('App\\Model\\Category', 125, 'nl', 'name', 'Magische trucs', 295),
('App\\Model\\Category', 125, 'de', 'name', 'Zaubertricks', 296),
('App\\Model\\Category', 126, 'nl', 'name', 'Ambachtelijk speelgoed', 297),
('App\\Model\\Category', 126, 'de', 'name', 'Bastelspielzeug', 298),
('App\\Model\\Category', 127, 'nl', 'name', 'Stempels speelgoed', 299),
('App\\Model\\Category', 127, 'de', 'name', 'Briefmarken Spielzeug', 300),
('App\\Model\\Category', 128, 'nl', 'name', 'Speelgoed tekenen', 301),
('App\\Model\\Category', 128, 'de', 'name', 'Zeichenspielzeug', 302),
('App\\Model\\Category', 129, 'nl', 'name', 'Rekenspeelgoed', 303),
('App\\Model\\Category', 129, 'de', 'name', 'Mathe-Spielzeug', 304),
('App\\Model\\Category', 130, 'nl', 'name', 'Puzzels', 305),
('App\\Model\\Category', 130, 'de', 'name', 'Rätsel', 306),
('App\\Model\\Category', 131, 'nl', 'name', 'Poppen', 307),
('App\\Model\\Category', 131, 'de', 'name', 'Puppen', 308),
('App\\Model\\Category', 132, 'nl', 'name', 'Poppenhuizen', 309),
('App\\Model\\Category', 132, 'de', 'name', 'Puppenhäuser', 310),
('App\\Model\\Category', 133, 'nl', 'name', 'Accessoires voor poppen', 311),
('App\\Model\\Category', 133, 'de', 'name', 'Puppenzubehör', 312),
('App\\Model\\Product', 113, 'nl', 'name', 'Luxe zilveren kleur kristal waterdruppel bruids sieraden sets strass tiara\'s kroon ketting oorbellen bruiloft Dubai sieraden set.', 313),
('App\\Model\\Product', 113, 'nl', 'description', '<p>Luxe zilveren kleur kristal waterdruppel bruids sieraden sets strass tiara&#39;s kroon ketting oorbellen bruiloft Dubai sieraden set.<br />\r\nmetaal</p>', 314),
('App\\Model\\Product', 113, 'de', 'name', 'Luxus Silber Farbe Kristall Wasser Tropfen Braut Schmuck Sets Strass Tiaras Krone Halskette Ohrringe Hochzeit Dubai Schmuck-Set.', 315),
('App\\Model\\Product', 113, 'de', 'description', '<p>Luxus Silber Farbe Kristall Wasser Tropfen Braut Schmuck Sets Strass Tiaras Krone Halskette Ohrringe Hochzeit Dubai Schmuck-Set.<br />\r\nMetall</p>', 316),
('App\\Model\\Product', 114, 'nl', 'name', 'Op maat gemaakte A-lijn trouwjurk met V-hals en spaghettibandjes Kapelsleep Abito Da Sposa Completamente in Pizzo Macramè Rugloos', 317),
('App\\Model\\Product', 114, 'nl', 'description', '<p>Op maat gemaakte A-lijn trouwjurk met V-hals en spaghettibandjes Kapelsleep Abito Da Sposa Completamente in Pizzo Macram&egrave; Rugloos</p>', 318),
('App\\Model\\Product', 114, 'de', 'name', 'Maßgeschneidertes Brautkleid in A-Linie mit V-Ausschnitt und Spaghettiträgern, Kapellenschleppe Abito Da Sposa Completamente in Pizzo Macramè, rückenfrei', 319),
('App\\Model\\Product', 114, 'de', 'description', '<p>Ma&szlig;geschneidertes Brautkleid in A-Linie mit V-Ausschnitt und Spaghettitr&auml;gern, Kapellenschleppe Abito Da Sposa Completamente in Pizzo Macram&egrave;, r&uuml;ckenfrei</p>', 320),
('App\\Model\\Product', 115, 'nl', 'name', 'Bloemblaadje Mouw Stand Kraag Hol Bloem Kant Patchwork Shirt Femme Blusas All-Match Vrouwen Kanten Blouse Knop Witte top 12419', 321),
('App\\Model\\Product', 115, 'nl', 'description', '<pre>\r\nBloemblaadje Mouw Stand Kraag Hol Bloem Kant Patchwork Shirt Femme Blusas All-Match Vrouwen Kanten Blouse Knop Witte top 12419</pre>', 322),
('App\\Model\\Product', 115, 'de', 'name', 'Blütenblatt Ärmel Stehkragen Aushöhlen Blume Spitze Patchwork Hemd Femme Blusas Allgleiches Frauen Spitze Bluse Taste Weiß Top 12419', 323),
('App\\Model\\Product', 115, 'de', 'description', '<pre>\r\nBl&uuml;tenblatt &Auml;rmel Stehkragen Aush&ouml;hlen Blume Spitze Patchwork Hemd Femme Blusas Allgleiches Frauen Spitze Bluse Taste Wei&szlig; Top 12419</pre>', 324),
('App\\Model\\Product', 116, 'nl', 'name', 'Herfst Winter Gestreepte Gebreide Trui Tops Voor Vrouwen Casual Lijnpatroon Oversized Truien Met Lange Mouwen Chic Street Knitwear', 325),
('App\\Model\\Product', 116, 'nl', 'description', '<pre>\r\nHerfst Winter Gestreepte Gebreide Trui Tops Voor Vrouwen Casual Lijnpatroon Oversized Truien Met Lange Mouwen Chic Street Knitwear\r\nMateriaal polyester\r\nPasvorm: LOS\r\n</pre>', 326),
('App\\Model\\Product', 116, 'de', 'name', 'Herbst Winter Gestreifte Gestrickte Pullover Tops Für Frauen Casual Linie Muster Langarm Übergroßen Pullover Chic Street Strickwaren', 327),
('App\\Model\\Product', 116, 'de', 'description', '<pre>\r\nHerbst Winter Gestreifte Gestrickte Pullover Tops F&uuml;r Frauen Casual Linie Muster Langarm &Uuml;bergro&szlig;en Pullover Chic Street Strickwaren\r\nMaterial: Polyester\r\nPassform: LOSE\r\n</pre>', 328),
('App\\Model\\Product', 117, 'nl', 'name', 'Dames Zomer T-shirts Sexy Transparante Mesh Crop Tops Lange Mouwen Y2K Dames Zwart Clubwear Skinny Slim Tees Kleding', 329),
('App\\Model\\Product', 117, 'nl', 'description', '<pre>\r\nDames Zomer T-shirts Sexy Transparante Mesh Crop Tops Lange Mouwen Y2K Dames Zwart Clubwear Skinny Slim Tees Kleding\r\nSpecificaties:\r\n\r\nArtikelnaam: damesshirt met lange mouwen\r\n\r\nGeslacht: vrouwen\r\n\r\nMateriaal: polyester\r\n\r\nMaat: S/M/L\r\n\r\nDe kleur zwart\r\n\r\nGewicht: 0,12 kg\r\n</pre>', 330),
('App\\Model\\Product', 117, 'de', 'name', 'Frauen Sommer T-shirts Sexy Transparent Mesh Crop Tops Langarm Shirts Y2K Damen Schwarz Clubwear Skinny Slim Tees Kleidung', 331),
('App\\Model\\Product', 117, 'de', 'description', '<pre>\r\nFrauen Sommer T-shirts Sexy Transparent Mesh Crop Tops Langarm Shirts Y2K Damen Schwarz Clubwear Skinny Slim Tees Kleidung\r\nSpezifikationen:\r\n\r\nArtikelbezeichnung: Damen-Langarmshirt\r\n\r\nGeschlecht: Frau\r\n\r\nMaterial: Polyester\r\n\r\nGr&ouml;&szlig;e: S/M/L\r\n\r\nFarbe: Schwarz\r\n\r\nGewicht: 0,12 kg\r\n</pre>', 332),
('App\\Model\\Product', 118, 'nl', 'name', 'Liefdeshart O-hals gebreide trui voor dames Borduurmode Trui met lange mouwen Vrouwelijke oversized high street-trui', 333),
('App\\Model\\Product', 118, 'nl', 'description', '<pre>\r\nLiefdeshart O-hals gebreide trui voor dames Borduurmode Trui met lange mouwen Vrouwelijke oversized high street-trui</pre>', 334),
('App\\Model\\Product', 118, 'de', 'name', 'Liebe Herz O Neck Strickpullover Für Frauen Stickerei Mode Langarm Pullover Pullover Weibliche Übergroßen High Street Jumper', 335),
('App\\Model\\Product', 118, 'de', 'description', '<pre>\r\nLiebe Herz O Neck Strickpullover F&uuml;r Frauen Stickerei Mode Langarm Pullover Pullover Weibliche &Uuml;bergro&szlig;en High Street Jumper</pre>', 336),
('App\\Model\\Brand', 2, 'nl', 'name', 'Samsung', 337),
('App\\Model\\Brand', 2, 'de', 'name', 'Samsung', 338),
('App\\Model\\Brand', 3, 'nl', 'name', 'Boss', 339),
('App\\Model\\Brand', 3, 'de', 'name', 'Boss', 340),
('App\\Model\\Brand', 4, 'nl', 'name', 'Chanel', 341),
('App\\Model\\Brand', 4, 'de', 'name', 'Chanel', 342),
('App\\Model\\Brand', 5, 'nl', 'name', 'Carter\'s', 343),
('App\\Model\\Brand', 5, 'de', 'name', 'Carter\'s', 344),
('App\\Model\\Brand', 6, 'nl', 'name', 'Calvin Klein', 345),
('App\\Model\\Brand', 6, 'de', 'name', 'Calvin Klein', 346),
('App\\Model\\Brand', 8, 'nl', 'name', 'Xiaomi', 347),
('App\\Model\\Brand', 8, 'de', 'name', 'Xiaomi', 348),
('App\\Model\\Category', 134, 'nl', 'name', 'Lichaamssieraden', 349),
('App\\Model\\Category', 134, 'de', 'name', 'Körperschmuck', 350),
('App\\Model\\Category', 135, 'nl', 'name', 'Kettingen', 351),
('App\\Model\\Category', 135, 'de', 'name', 'Halsketten', 352),
('App\\Model\\Category', 136, 'nl', 'name', 'Horloges', 353),
('App\\Model\\Category', 136, 'de', 'name', 'Uhren', 354),
('App\\Model\\Category', 137, 'nl', 'name', 'Oorpiercing', 355),
('App\\Model\\Category', 137, 'de', 'name', 'Ohrlochstechen', 356),
('App\\Model\\Category', 138, 'nl', 'name', 'Tandgrill', 357),
('App\\Model\\Category', 138, 'de', 'name', 'Dentalgrill', 358),
('App\\Model\\Category', 139, 'nl', 'name', 'Neus Nagel', 359),
('App\\Model\\Category', 139, 'de', 'name', 'Nasennagel', 360),
('App\\Model\\Category', 140, 'nl', 'name', 'Dames ketting', 361),
('App\\Model\\Category', 140, 'de', 'name', 'Damenhalskette', 362),
('App\\Model\\Category', 141, 'nl', 'name', 'Heren ketting', 363),
('App\\Model\\Category', 141, 'de', 'name', 'Herrenhalskette', 364),
('App\\Model\\Category', 142, 'nl', 'name', 'Zilveren ketting', 365),
('App\\Model\\Category', 142, 'de', 'name', 'Silberkette', 366),
('App\\Model\\Category', 143, 'nl', 'name', 'Digitale horloges', 367),
('App\\Model\\Category', 143, 'de', 'name', 'Digitale Uhren', 368),
('App\\Model\\Category', 144, 'nl', 'name', 'mechanische horloges', 369),
('App\\Model\\Category', 144, 'de', 'name', 'mechanische Uhren', 370),
('App\\Model\\Category', 145, 'nl', 'name', 'Horlogebanden', 371),
('App\\Model\\Category', 145, 'de', 'name', 'Uhrenarmbänder', 372),
('App\\Model\\Category', 146, 'nl', 'name', 'Horlogebanden', 373),
('App\\Model\\Category', 146, 'de', 'name', 'Uhrenarmbänder', 374),
('App\\Model\\Category', 147, 'nl', 'name', 'Exterieuraccessoires', 375),
('App\\Model\\Category', 147, 'de', 'name', 'Außenzubehör', 376),
('App\\Model\\Category', 148, 'nl', 'name', 'Auto Reparatie Gereedschap', 377),
('App\\Model\\Category', 148, 'de', 'name', 'Autoreparaturwerkzeuge', 378),
('App\\Model\\Category', 149, 'nl', 'name', 'Motoronderdelen', 379),
('App\\Model\\Category', 149, 'de', 'name', 'Motorradteile', 380),
('App\\Model\\Category', 150, 'nl', 'name', 'Autostoelhoezen', 381),
('App\\Model\\Category', 150, 'de', 'name', 'Autositzbezüge', 382),
('App\\Model\\Category', 151, 'nl', 'name', 'GPS-accessoires', 383),
('App\\Model\\Category', 151, 'de', 'name', 'GPS-Zubehör', 384),
('App\\Model\\Category', 152, 'nl', 'name', 'Accessoires', 385),
('App\\Model\\Category', 152, 'de', 'name', 'Zubehör', 386),
('App\\Model\\Category', 153, 'nl', 'name', 'Autohoezen', 387),
('App\\Model\\Category', 153, 'de', 'name', 'Autoabdeckungen', 388),
('App\\Model\\Category', 154, 'nl', 'name', 'Autostickers', 389),
('App\\Model\\Category', 154, 'de', 'name', 'Autoaufkleber', 390),
('App\\Model\\Category', 155, 'nl', 'name', 'Accessoires', 391),
('App\\Model\\Category', 155, 'de', 'name', 'Zubehör', 392),
('App\\Model\\Category', 156, 'nl', 'name', 'Inspectiehulpmiddelen', 393),
('App\\Model\\Category', 156, 'de', 'name', 'Inspektionswerkzeuge', 394),
('App\\Model\\Category', 157, 'nl', 'name', 'Gereedschap voor bandenreparatie', 395),
('App\\Model\\Category', 157, 'de', 'name', 'Reifenreparaturwerkzeuge', 396),
('App\\Model\\Category', 158, 'nl', 'name', 'Diagnostische hulpmiddelen', 397),
('App\\Model\\Category', 158, 'de', 'name', 'Diagnosewerkzeuge', 398),
('App\\Model\\Category', 159, 'nl', 'name', 'Motor onderdelen', 399),
('App\\Model\\Category', 159, 'de', 'name', 'Motorenteile', 400),
('App\\Model\\Category', 160, 'nl', 'name', 'Carrosserie & Frames', 401),
('App\\Model\\Category', 160, 'de', 'name', 'Körper & Rahmen', 402),
('App\\Model\\Category', 161, 'nl', 'name', 'Elektrisch en ontstekingen', 403),
('App\\Model\\Category', 161, 'de', 'name', 'Elektrik und Zündungen', 404),
('App\\Model\\Product', 119, 'nl', 'name', '2023 Nieuwe Vintage Bandage Maxi Jurk Vrouwen Lantaarn Mouw Lange Feestjurken Herfst Elegante Luxe Gast Bruiloft Avond Vestidos', 405),
('App\\Model\\Product', 119, 'nl', 'description', '<p>2023 Nieuwe Vintage Bandage Maxi Jurk Vrouwen Lantaarn Mouw Lange Feestjurken Herfst Elegante Luxe Gast Bruiloft Avond Vestidos<br />\r\nMateriaal Polyester</p>', 406),
('App\\Model\\Product', 119, 'de', 'name', '2023 neue Vintage Bandage Maxi Kleid Frauen Laterne Hülse Lange Party Kleider Herbst Elegante Luxus Gast Hochzeit Abend Vestidos', 407),
('App\\Model\\Product', 119, 'de', 'description', '<p>2023 neue Vintage Bandage Maxi Kleid Frauen Laterne H&uuml;lse Lange Party Kleider Herbst Elegante Luxus Gast Hochzeit Abend Vestidos<br />\r\nMaterial: Polyester</p>', 408),
('App\\Model\\Product', 120, 'nl', 'name', 'Sching Fake Tweedelige Hepburn Licht Volwassen Jurk Dames Zomer Nieuwe Franse Minderheid Taille Strakke Show Dunne Blk Jurk', 409),
('App\\Model\\Product', 120, 'nl', 'description', '<pre>\r\nVerzending: provincie Guang\r\nStof/materiaal: chemische vezels/polyester (polyestervezel)\r\nIngredi&euml;ntengehalte: 81% (inclusief) -90% (inclusief)\r\nStijl: nichekenmerken/minimalisme\r\nPopulair element/proces: driedimensionale decoratie, voile, ritssluiting\r\nCombinatievorm: twee nepstukken\r\nStijl: A-lijn rok\r\nMouwlengte: korte mouw\r\nRoklengte: middenrok\r\nKraagstijl: ronde hals\r\nMet/zonder fluweel: geen fluweel\r\nTijd tot markt: zomer 2021\r\nMouwtype: Conventioneel</pre>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 213px; top: -5.6px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 410),
('App\\Model\\Product', 120, 'de', 'name', 'Sching Fake Two-Piece Hepburn Lightly Mature Dress Damen Sommer New French Minority Waist-Enge Show Thin Blk Dress', 411),
('App\\Model\\Product', 120, 'de', 'description', '<pre>\r\nVersandart: Provinz Guang\r\nStoff/Material: Chemiefaser/Polyester (Polyesterfaser).\r\nInhaltsstoffgehalt: 81 % (einschlie&szlig;lich)&ndash;90 % (einschlie&szlig;lich)\r\nStil: Nischenmerkmale/Minimalismus\r\nBeliebtes Element/Verfahren: Dreidimensionale Dekoration, Voile, Rei&szlig;verschluss\r\nKombinationsform: Fake zwei Teile\r\nStil: A-Linien-Rock\r\n&Auml;rmell&auml;nge: Kurzarm\r\nRockl&auml;nge: mittlerer Rock\r\nKragenform: Rundhalsausschnitt\r\nMit/ohne Samt: kein Samt\r\nMarkteinf&uuml;hrungszeit: Sommer 2021\r\nH&uuml;lsentyp: Konventionell</pre>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 242px; top: 38.6px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 412),
('App\\Model\\Product', 121, 'nl', 'name', 'Vrouwen Elegante Luxe Jurk Avondfeest Prom Bruiloft Club Afstuderen Backless Mouwloos Een Schouder Maxi Jurken Sexy Vestido', 413),
('App\\Model\\Product', 121, 'nl', 'description', '<p>Vrouwen Elegante Luxe Jurk Avondfeest Prom Bruiloft Club Afstuderen Backless Mouwloos Een Schouder Maxi Jurken Sexy Vestido</p>', 414),
('App\\Model\\Product', 121, 'de', 'name', 'Frauen Elegante Luxus Kleid Abend Party Prom Hochzeit Club Graduation Backless Ärmel Eine Schulter Maxi Kleider Sexy Vestido', 415),
('App\\Model\\Product', 121, 'de', 'description', '<p>Frauen Elegante Luxus Kleid Abend Party Prom Hochzeit Club Graduation Backless &Auml;rmel Eine Schulter Maxi Kleider Sexy Vestido</p>', 416),
('App\\Model\\Product', 122, 'nl', 'name', 'Koreaanse Mode Casual Damesbroek Losse Rechte Wijde Pijpen Broek voor Vrouwen Office Lady Cargo Broek Vrouw Broek Baggy Kleding', 417),
('App\\Model\\Product', 122, 'nl', 'description', '<p>Koreaanse Mode Casual Damesbroek Losse Rechte Wijde Pijpen Broek voor Vrouwen Office Lady Cargo Broek Vrouw Broek Baggy Kleding</p>', 418),
('App\\Model\\Product', 122, 'de', 'name', 'Korean Fashion Casual frauen Hosen Lose Gerade Breite Bein Hosen für Frauen Büro Dame Cargo Hosen Frau Hosen Baggy kleidung', 419),
('App\\Model\\Product', 122, 'de', 'description', '<p>Korean Fashion Casual frauen Hosen Lose Gerade Breite Bein Hosen f&uuml;r Frauen B&uuml;ro Dame Cargo Hosen Frau Hosen Baggy kleidung</p>', 420),
('App\\Model\\Product', 123, 'nl', 'name', 'Zomer Hoge Taille Slanke Shorts Vrouwen Koreaanse Strakke Elastische Tas Hip Driepunts Hot Pants Casual Bovenkleding Bodems Vrouwelijke kleding', 421),
('App\\Model\\Product', 123, 'nl', 'description', '<p>Zomer Hoge Taille Slanke Shorts Vrouwen Koreaanse Strakke Elastische Tas Hip Driepunts Hot Pants Casual Bovenkleding Bodems Vrouwelijke kleding</p>', 422),
('App\\Model\\Product', 123, 'de', 'name', 'Sommer Hohe Taille Schlank Shorts Frauen Koreanische Enge Elastische Tasche Hüfte Drei-punkt Hot Hosen Casual Oberbekleidung Böden Weibliche kleidung', 423),
('App\\Model\\Product', 123, 'de', 'description', '<p>Sommer Hohe Taille Schlank Shorts Frauen Koreanische Enge Elastische Tasche H&uuml;fte Drei-punkt Hot Hosen Casual Oberbekleidung B&ouml;den Weibliche kleidung</p>', 424),
('App\\Model\\Product', 124, 'nl', 'name', 'Zoki Witte Vrouwen Geplooide Rokken Zomer Hoge Taille Rits Meisjes Dansen Jk Mini Rokken Zwarte Mode Student Een Lijn Faldas 2023', 425),
('App\\Model\\Product', 124, 'nl', 'description', '<p>Zoki Witte Vrouwen Geplooide Rokken Zomer Hoge Taille Rits Meisjes Dansen Jk Mini Rokken Zwarte Mode Student Een Lijn Faldas 2023</p>', 426),
('App\\Model\\Product', 124, 'de', 'name', 'ZOKI Weiße Frauen Faltenröcke Sommer Hohe Taille Zipper Mädchen Tanzen JK Mini Röcke Schwarz Mode Student EINE Linie Faldas 2023', 427),
('App\\Model\\Product', 124, 'de', 'description', '<p>ZOKI Wei&szlig;e Frauen Faltenr&ouml;cke Sommer Hohe Taille Zipper M&auml;dchen Tanzen JK Mini R&ouml;cke Schwarz Mode Student EINE Linie Faldas 2023</p>', 428),
('App\\Model\\Product', 125, 'nl', 'name', 'Damesjeans Hoge Taille 2023 Lente Zomer Mode Streetwear Rechte Wijde Pijpen Broek Losse Casual Vrouwelijke Denim Broek', 429),
('App\\Model\\Product', 125, 'nl', 'description', '<p>Damesjeans Hoge Taille 2023 Lente Zomer Mode Streetwear Rechte Wijde Pijpen Broek Losse Casual Vrouwelijke Denim Broek</p>', 430),
('App\\Model\\Product', 125, 'de', 'name', 'Frauen Jeans Hohe Taille 2023 Frühling Sommer Mode Streetwear Gerade Breite Bein Hosen Lose Beiläufige Weibliche Denim Hosen', 431),
('App\\Model\\Product', 125, 'de', 'description', '<p>Frauen Jeans Hohe Taille 2023 Fr&uuml;hling Sommer Mode Streetwear Gerade Breite Bein Hosen Lose Beil&auml;ufige Weibliche Denim Hosen</p>', 432),
('App\\Model\\Product', 126, 'nl', 'name', 'Heren Casual overhemd Katoen Linnen Lange mouwen Top Strand Vintage Opstaande kraag Ontwerp Stijlvolle stijl Losse tas Grote maten Vier seizoenen', 433),
('App\\Model\\Product', 126, 'nl', 'description', '<p>Heren Casual overhemd Katoen Linnen Lange mouwen Top Strand Vintage Opstaande kraag Ontwerp Stijlvolle stijl Losse tas Grote maten Vier seizoenen</p>', 434),
('App\\Model\\Product', 126, 'de', 'name', 'Herren Freizeithemd Baumwolle Leinen Langarm Top Strand Vintage Stehkragen Design Stilvoller Stil Lose Tasche Plus-Size Vier Jahreszeiten', 435),
('App\\Model\\Product', 126, 'de', 'description', '<p>Herren Freizeithemd Baumwolle Leinen Langarm Top Strand Vintage Stehkragen Design Stilvoller Stil Lose Tasche Plus-Size Vier Jahreszeiten</p>', 436),
('App\\Model\\Product', 127, 'nl', 'name', '2 stuk/set Fashion Designer Pu Leer vrouwen Handtassen Goede Casual Dames Tote Vrouwelijke Zwarte Emmer Vrouwen Schouder Crossbody Tas', 437),
('App\\Model\\Product', 127, 'nl', 'description', '<p>2 stuk/set Fashion Designer Pu Leer vrouwen Handtassen Goede Casual Dames Tote Vrouwelijke Zwarte Emmer Vrouwen Schouder Crossbody Tas<br />\r\nBovenbreedte 18CM, onderbreedte 24CM, hoogte 23CM, dikte 16CM</p>', 438),
('App\\Model\\Product', 127, 'de', 'name', '2 teil/satz Mode Designer Pu Leder frauen Handtaschen Gute Casual Damen Tote Weibliche Schwarz Eimer Frauen Schulter Umhängetasche', 439),
('App\\Model\\Product', 127, 'de', 'description', '<p>2 teil/satz Mode Designer Pu Leder frauen Handtaschen Gute Casual Damen Tote Weibliche Schwarz Eimer Frauen Schulter Umh&auml;ngetasche<br />\r\nObere Breite 18 cm, untere Breite 24 cm, H&ouml;he 23 cm, Dicke 16 cm</p>', 440),
('App\\Model\\Product', 128, 'nl', 'name', 'Mini Massage Gun Fitness Fascia Gun Vibrator Massager Voor Lichaamsvorming Terug Ontspanning Behandeling Pijnbestrijding Spiermassagepistolen', 441),
('App\\Model\\Product', 128, 'nl', 'description', '<p>Mini Massage Gun Fitness Fascia Gun Vibrator Massager Voor Lichaamsvorming Terug Ontspanning Behandeling Pijnbestrijding Spiermassagepistolen<br />\r\nDraaisnelheid: 4000 tpm<br />\r\nUSB-opladen<br />\r\nProductkracht: 30W<br />\r\nBatterij capaciteit: 1500 mAh</p>', 442),
('App\\Model\\Product', 128, 'de', 'name', 'Mini-Massagepistole Fitness Faszienpistole Vibrator-Massagegerät zur Körperformung Rückenentspannungsbehandlung Schmerzlinderung Muskelmassagepistolen', 443),
('App\\Model\\Product', 128, 'de', 'description', '<p>Mini-Massagepistole Fitness Faszienpistole Vibrator-Massageger&auml;t zur K&ouml;rperformung R&uuml;ckenentspannungsbehandlung Schmerzlinderung Muskelmassagepistolen<br />\r\nDrehzahl: 4000 U/min<br />\r\nUSB-Aufladung<br />\r\nProduktleistung: 30W<br />\r\nBatteriekapazit&auml;t: 1500 mAh</p>', 444),
('App\\Model\\Product', 129, 'nl', 'name', '2022 Ins Mode Kinderen Sneakers Kinderen Canvas Schoenen Kids Maat 25-37 Jongens Sneakers Meisjes Schoenen Hoge Laarzen Lace-up Denim', 445),
('App\\Model\\Product', 129, 'nl', 'description', '<p>2022 Ins Mode Kinderen Sneakers Kinderen Canvas Schoenen Kids Maat 25-37 Jongens Sneakers Meisjes Schoenen Hoge Laarzen Lace-up Denim</p>', 446),
('App\\Model\\Product', 129, 'de', 'name', '2022 Ins Mode Kinder Turnschuhe Kinder Leinwand Schuhe Kinder Größe 25-37 Jungen Turnschuhe Mädchen Schuhe Hohe Stiefel Spitze-up Denim', 447),
('App\\Model\\Product', 129, 'de', 'description', '<p>2022 Ins Mode Kinder Turnschuhe Kinder Leinwand Schuhe Kinder Gr&ouml;&szlig;e 25-37 Jungen Turnschuhe M&auml;dchen Schuhe Hohe Stiefel Spitze-up Denim</p>', 448),
('App\\Model\\Product', 130, 'nl', 'name', 'Kinderen Tekentafel Projectietafel Licht Speelgoed Voor Jongen Сoloring Pen Boek Tool Set Meisje Leren Educatief Kinderen 3 Jaar Geschenken', 449),
('App\\Model\\Product', 130, 'nl', 'description', '<p>Miniprojectie-tekenbordspeelgoed voor kinderen<br />\r\nFunctie:<br />\r\nMet de lichtprojectiefunctie kunt u het cartoonpatroon wijzigen door dia&#39;s te laden en dia&#39;s handmatig te draaien. Afhankelijk van het aantal gekochte dia&#39;s kunt u meer afbeeldingen hebben, maximaal 72 afbeeldingen, en elke afbeelding wordt niet herhaald.<br />\r\n&nbsp;<br />\r\nDe afbeeldingen zijn fruit, groenten, voertuigen, gezinnen, getallen, voedsel, dieren, en ze zijn allemaal prachtig!<br />\r\nCultiveer en verbeter het schildertalent en -vermogen van kinderen. Laten we tekenen met onze kinderen.<br />\r\n&nbsp;<br />\r\nUpgrade de set functies voor het plaatsen van gummen en de borstelaansluiting. Cre&euml;er een handige gewoonte voor kinderen.<br />\r\n&nbsp;<br />\r\nPakket lijst:<br />\r\nGiraffe tekentafel tafel: 1 STKS<br />\r\nKleurpotlood: 12 stuks<br />\r\nVerfboek: 1 STKS<br />\r\nPlaatgum: 1 STKS<br />\r\nGlijbaan: 3-9PCS (volgens de aankoophoeveelheid)<br />\r\n&nbsp;<br />\r\nMaat:<br />\r\nTafel: 24 cm * 16 cm * 28 cm (9,44 inch * 6,29 inch * 11,02 inch)<br />\r\nSchildergebied: 16 cm * 13 cm (6,29 inch * 5,11 inch)</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: -259px; top: -4.8px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 450),
('App\\Model\\Product', 130, 'de', 'name', 'Kinder Zeichenbrett Projektion Tisch Licht Spielzeug für Jungen Malstift Buch Werkzeug Set Mädchen lernen pädagogische Kinder 3 Jahre Geschenke', 451),
('App\\Model\\Product', 130, 'de', 'description', '<p>Mini-Projektions-Zeichenbrettspielzeug f&uuml;r Kinder<br />\r\nFunktion:<br />\r\nMit der Lichtprojektionsfunktion k&ouml;nnen Sie das Cartoon-Muster &auml;ndern, indem Sie Dias laden und Dias manuell drehen. Sie k&ouml;nnen je nach Anzahl der gekauften Folien weitere Bilder haben, bis zu 72 Bilder, und jedes Bild wird nicht wiederholt.<br />\r\n&nbsp;<br />\r\nDie Bilder zeigen Obst, Gem&uuml;se, Fahrzeuge, Familien, Zahlen, Essen, Tiere, und sie sind alle wundersch&ouml;n!<br />\r\nF&ouml;rdern und verbessern Sie das Maltalent und die F&auml;higkeiten von Kindern. Lasst uns mit unseren Kindern zeichnen.<br />\r\n&nbsp;<br />\r\nErweitern Sie die Funktionen f&uuml;r die Platzierung des Radiergummis und den B&uuml;rstensockel. Schaffen Sie eine bequeme Gewohnheit f&uuml;r Kinder.<br />\r\n&nbsp;<br />\r\nPaketliste:<br />\r\nGiraffen-Zeichenbretttisch: 1 St&uuml;ck<br />\r\nFarbstift: 12 St&uuml;ck<br />\r\nMalbuch: 1 St&uuml;ck<br />\r\nPlattenradierer: 1 St&uuml;ck<br />\r\nFolie: 3&ndash;9 St&uuml;ck (je nach Kaufmenge).<br />\r\n&nbsp;<br />\r\nGr&ouml;&szlig;e:<br />\r\nTisch: 24 cm * 16 cm * 28 cm (9,44 Zoll * 6,29 Zoll * 11,02 Zoll)<br />\r\nLackierfl&auml;che: 16 cm * 13 cm (6,29 Zoll * 5,11 Zoll)</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: -106px; top: -4.8px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 452),
('App\\Model\\Product', 131, 'nl', 'name', 'Vijflaagse slaapkamerkasten Thuis Kinderen Opbergkasten Lade Ontwerp Kleedkamer Veelzijdige praktische kledingkast', 453),
('App\\Model\\Product', 131, 'nl', 'description', '<p>Vijflaagse slaapkamerkasten Thuis Kinderen Opbergkasten Lade Ontwerp Kleedkamer Veelzijdige praktische kledingkast<br />\r\nAfmeting: 39x32x85cm<br />\r\nMateriaal: kunststof</p>', 454),
('App\\Model\\Product', 131, 'de', 'name', 'Fünfschichtige Schlafzimmerschränke, Heimkinder-Aufbewahrungsschränke, Schubladen-Design, Ankleidezimmer, vielseitiger praktischer Kleiderschrank', 455),
('App\\Model\\Product', 131, 'de', 'description', '<p>F&uuml;nfschichtige Schlafzimmerschr&auml;nke, Heimkinder-Aufbewahrungsschr&auml;nke, Schubladen-Design, Ankleidezimmer, vielseitiger praktischer Kleiderschrank<br />\r\nGr&ouml;&szlig;e: 39x32x85cm<br />\r\nMaterial: Kunststoff</p>', 456),
('App\\Model\\Product', 132, 'nl', 'name', 'Professioneel oorpiercingpistool Gereedschapset Stalen oorknopjes Veilig steriel kraakbeen Helix-piercingtool Oorsieradenmachinekit', 457),
('App\\Model\\Product', 132, 'nl', 'description', '<p>Professioneel oorpiercingpistool Gereedschapset Stalen oorknopjes Veilig steriel kraakbeen Helix-piercingtool Oorsieradenmachinekit</p>', 458),
('App\\Model\\Product', 132, 'de', 'name', 'Professionelles Ohrlochstechpistolen-Set, Stahl-Ohrstecker, sicher, steril, Knorpel-Helix-Piercing-Werkzeug, Ohrschmuck-Maschinen-Set', 459),
('App\\Model\\Product', 132, 'de', 'description', '<p>Professionelles Ohrlochstechpistolen-Set, Stahl-Ohrstecker, sicher, steril, Knorpel-Helix-Piercing-Werkzeug, Ohrschmuck-Maschinen-Set</p>', 460),
('App\\Model\\Product', 133, 'nl', 'name', 'Lederen Auto Stoelhoezen voor Renault Megane 2 3 Fluence Scenic Clio Captur Kadjar Logan 2 Stofdoek Arkana Kangoo voor Voertuig onderdelen', 461),
('App\\Model\\Product', 133, 'nl', 'description', '<p>Lederen Auto Stoelhoezen voor Renault Megane 2 3 Fluence Scenic Clio Captur Kadjar Logan 2 Stofdoek Arkana Kangoo voor Voertuig onderdelen</p>', 462),
('App\\Model\\Product', 133, 'de', 'name', 'Autositzbezüge aus Leder für Renault Megane 2 3 Fluence Scenic Clio Captur Kadjar Logan 2 Duster Arkana Kangoo für Fahrzeugteile', 463),
('App\\Model\\Product', 133, 'de', 'description', '<p>Autositzbez&uuml;ge aus Leder f&uuml;r Renault Megane 2 3 Fluence Scenic Clio Captur Kadjar Logan 2 Duster Arkana Kangoo f&uuml;r Fahrzeugteile</p>', 464),
('App\\Model\\Category', 164, 'nl', 'name', 'Computeronderdelen', 469),
('App\\Model\\Category', 164, 'de', 'name', 'Computerteile', 470),
('App\\Model\\Category', 165, 'nl', 'name', 'Tablets en Accessoires', 471),
('App\\Model\\Category', 165, 'de', 'name', 'Tablets und Zubehör', 472),
('App\\Model\\Category', 166, 'nl', 'name', 'Smartphone', 473),
('App\\Model\\Category', 166, 'de', 'name', 'Smartphone', 474),
('App\\Model\\Category', 167, 'nl', 'name', 'Laptop', 475),
('App\\Model\\Category', 167, 'de', 'name', 'Laptop', 476),
('App\\Model\\Category', 168, 'nl', 'name', 'Grafische kaarten', 477),
('App\\Model\\Category', 168, 'de', 'name', 'Grafikkarten', 478),
('App\\Model\\Category', 169, 'nl', 'name', 'Geavanceerde opslag & Ram', 479),
('App\\Model\\Category', 169, 'de', 'name', 'Erweiterter Speicher & Ram', 480),
('App\\Model\\Product', 134, 'nl', 'name', '2022 Lente 4 Kleur Blazer Mannen Slanke Mode Sociale Heren Jurk Jas Zakelijke Formele Jas Mannen Kantoor Jasje S-3XL', 481),
('App\\Model\\Product', 134, 'nl', 'description', '<p>Voordat u een bestelling plaatst, moet u de volgende winkeltips controleren, zodat u een succesvolle winkelervaring heeft:</p>\r\n\r\n<p>1. Grootte: dit is een Aziatische maat, ongeveer 3 maten kleiner dan de Amerikaanse / EU-maat. Als u bijvoorbeeld US/EU maat M draagt, raden wij u aan onze Aziatische maat XXL te kiezen.</p>\r\n\r\n<p>2. Kleur: Verschillende computerschermen kunnen verschillende kleuren weergeven, zelfs als het dezelfde kleur is. Houd dus rekening met een redelijk kleurverschil.</p>\r\n\r\n<p>3. Normaal gesproken regelen wij uw bestelling binnen 3 dagen. na de betaling</p>\r\n\r\n<p>4. Feedback is erg belangrijk voor ons, geef ons alstublieft? 4 of 5 sterren. positieve feedback. Als u problemen ondervindt, neem dan contact met ons op. Wij helpen u graag bij het oplossen van eventuele problemen</p>\r\n\r\n<p>Lees dit aandachtig door voordat u uw bestelling plaatst. Aziatische maat is? anders dan de Amerikaanse maat.</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 162px; top: -4.8px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 482),
('App\\Model\\Product', 134, 'de', 'name', '2022 frühling 4 Farbe Blazer Männer Schlank Mode Sozialen Herren Kleid Jacke Business Formale Jacke Männer Büro Anzug Jacke S-3XL', 483);
INSERT INTO `translations` (`translationable_type`, `translationable_id`, `locale`, `key`, `value`, `id`) VALUES
('App\\Model\\Product', 134, 'de', 'description', '<p>Bevor Sie eine Bestellung aufgeben, m&uuml;ssen Sie die folgenden Einkaufstipps pr&uuml;fen, damit Ihr Einkaufserlebnis erfolgreich ist:</p>\r\n\r\n<p>1. Gr&ouml;&szlig;e: Dies ist eine asiatische Gr&ouml;&szlig;e, etwa 3 Gr&ouml;&szlig;en kleiner als US/EU-Gr&ouml;&szlig;e. Wenn Sie beispielsweise die US-/EU-Gr&ouml;&szlig;e M tragen, empfehlen wir Ihnen, unsere asiatische Gr&ouml;&szlig;e XXL zu w&auml;hlen.</p>\r\n\r\n<p>2. Farbe: Verschiedene Computerbildschirme k&ouml;nnen unterschiedliche Farben anzeigen, selbst wenn es sich um dieselbe Farbe handelt. Bitte erlauben Sie daher einen angemessenen Farbunterschied.</p>\r\n\r\n<p>3. Normalerweise bearbeiten wir Ihre Bestellung innerhalb von 3 Tagen. nach der Zahlung</p>\r\n\r\n<p>4. Feedback ist uns sehr wichtig, bitte geben Sie uns bitte eine R&uuml;ckmeldung. 4 oder 5 Sterne. positives Feedback. Wenn Sie auf Probleme sto&szlig;en, versuchen Sie bitte, Kontakt zu uns aufzunehmen. Wir helfen Ihnen gerne bei der L&ouml;sung jedes Problems</p>\r\n\r\n<p>Bitte lesen Sie diese sorgf&auml;ltig durch, bevor Sie Ihre Bestellung aufgeben. Asiatische gr&ouml;&szlig;e ist? unterscheidet sich von der US-Gr&ouml;&szlig;e.</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 379px; top: -4.8px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 484),
('App\\Model\\Category', 170, 'nl', 'name', 'Gaming-moederbord', 485),
('App\\Model\\Category', 170, 'de', 'name', 'Gaming-Motherboard', 486),
('App\\Model\\Category', 171, 'nl', 'name', 'PC-voedingen', 487),
('App\\Model\\Category', 171, 'de', 'name', 'PC-Netzteile', 488),
('App\\Model\\Category', 172, 'nl', 'name', 'Tekentablet', 489),
('App\\Model\\Category', 172, 'de', 'name', 'Zeichentablett', 490),
('App\\Model\\Category', 173, 'nl', 'name', 'Digitale fototoestellen', 491),
('App\\Model\\Category', 173, 'de', 'name', 'Digitalkameras', 492),
('App\\Model\\Category', 174, 'nl', 'name', 'Wielen en vluchtjoysticks', 493),
('App\\Model\\Category', 174, 'de', 'name', 'Räder und Flug-Joysticks', 494),
('App\\Model\\Category', 175, 'nl', 'name', 'Tassen', 495),
('App\\Model\\Category', 175, 'de', 'name', 'Taschen', 496),
('App\\Model\\Category', 176, 'nl', 'name', 'Smartphones', 497),
('App\\Model\\Category', 176, 'de', 'name', 'Smartphones', 498),
('App\\Model\\Category', 177, 'nl', 'name', 'Telefoon hoesjes', 499),
('App\\Model\\Category', 177, 'de', 'name', 'Handyhüllen', 500),
('App\\Model\\Category', 178, 'nl', 'name', 'Opladers voor mobiele telefoons', 501),
('App\\Model\\Category', 178, 'de', 'name', 'Ladegeräte für Mobiltelefone', 502),
('App\\Model\\Category', 179, 'nl', 'name', 'Reparatiehulpmiddelen voor telefoons', 503),
('App\\Model\\Category', 179, 'de', 'name', 'Telefonreparaturwerkzeuge', 504),
('App\\Model\\Product', 135, 'nl', 'name', 'Luxe Design Bifold Korte Portefeuilles Mannelijke Hasp Vintage Portemonnee Muntzakje Multifunctionele kaartzak Echt lederen herenportemonnee RFID', 505),
('App\\Model\\Product', 135, 'nl', 'description', '<p>Echt leersoort Koeienleer Interieur Binnenvak met rits, Binnenvak met ritssluiting, Binnenvak met sleutelhanger, Binnenvak, Ritszakje, Muntvak, Passcardvak, Notitievak, Fotohouder, Kaarthouder</p>\r\n\r\n<p>&nbsp;</p>', 506),
('App\\Model\\Product', 135, 'de', 'name', 'Luxus Design Bifold Kurze Brieftaschen Männlichen Haspe Vintage Geldbörse Münzfach Multi-funktionale Karte Tasche Aus Echtem Leder Männer Brieftasche RFID', 507),
('App\\Model\\Product', 135, 'de', 'description', '<p>Innentasche aus echtem Rindsleder, Innenfach mit Rei&szlig;verschluss, Innentasche mit Rei&szlig;verschluss, Innenfach f&uuml;r Schl&uuml;sselanh&auml;nger, Innenfach, Rei&szlig;verschlusstasche, M&uuml;nzfach, Passkartenfach, Geldscheinfach, Fotohalter, Kartenhalter</p>\r\n\r\n<p>&nbsp;</p>', 508),
('App\\Model\\Category', 180, 'nl', 'name', 'Laptop', 509),
('App\\Model\\Category', 180, 'de', 'name', 'Laptop', 510),
('App\\Model\\Category', 181, 'nl', 'name', 'Laptop-macbook', 511),
('App\\Model\\Category', 181, 'de', 'name', 'Laptop-Macbook', 512),
('App\\Model\\Category', 182, 'nl', 'name', 'Laptopaccessoires', 513),
('App\\Model\\Category', 182, 'de', 'name', 'Laptop-Zubehör', 514),
('App\\Model\\Product', 136, 'nl', 'name', 'INSMART Monddouche Tandheelkundige Water Flosser Tanden Whitening Waterdichte Draagbare Tandheelkundige Waterstraal Floss 300ML Tanden Schoner', 515),
('App\\Model\\Product', 136, 'nl', 'description', '<p>INSMART Monddouche Tandheelkundige Water Flosser Tanden Whitening Waterdichte Draagbare Tandheelkundige Waterstraal Floss 300ML Tanden Schoner<br />\r\n4 of meer werkingsmodi: De SMART Mondirrigator heeft 4 of meer werkingsmodi, waardoor u uw tandenreinigingservaring kunt aanpassen.<br />\r\nTot 1199 pulsen/min: Met maximaal 1199 pulsen per minuut zorgt de INSMART monddouche voor een krachtige en effici&euml;nte tandreiniging.<br />\r\n5 of meer mondstukken: De INSMART monddouche wordt geleverd met 5 of meer mondstukken, waardoor u deze gemakkelijk kunt delen met familieleden of kunt vervangen wanneer dat nodig is.</p>', 516),
('App\\Model\\Product', 136, 'de', 'name', 'INSMART Oral Irrigator Dental Wasser Flosser Zähne Bleaching Wasserdichte Tragbare Dental Wasser Jet Floss 300ML Zähne Reiniger', 517),
('App\\Model\\Product', 136, 'de', 'description', '<p>INSMART Oral Irrigator Dental Wasser Flosser Z&auml;hne Bleaching Wasserdichte Tragbare Dental Wasser Jet Floss 300ML Z&auml;hne Reiniger<br />\r\n4 oder mehr Betriebsmodi: Der SMART Oral Irrigator verf&uuml;gt &uuml;ber 4 oder mehr Betriebsmodi, sodass Sie Ihr Zahnreinigungserlebnis individuell gestalten k&ouml;nnen.<br />\r\nBis zu 1199 Impulse/Minute: Mit bis zu 1199 Impulsen pro Minute sorgt die INSMART Munddusche f&uuml;r eine kraftvolle und effiziente Zahnreinigung.<br />\r\n5 oder mehr D&uuml;sen: Die INSMART Munddusche ist mit 5 oder mehr D&uuml;sen ausgestattet, sodass Sie sie problemlos mit Familienmitgliedern teilen oder bei Bedarf austauschen k&ouml;nnen.</p>', 518),
('App\\Model\\Product', 137, 'nl', 'name', 'Babyaanvullende voedselmolen, zesdelige set Babycartoon conditioneringsmaalkom', 519),
('App\\Model\\Product', 137, 'nl', 'description', '<p>Babyaanvullende voedselmolen, zesdelige set Babycartoon conditioneringsmaalkom</p>\r\n\r\n<p>Beschrijving<br />\r\n&bull; Zesdelige set: Deze set bevat zes verschillende soorten voeding, waardoor het een veelzijdige en complete oplossing is voor de maaltijden van uw baby.</p>\r\n\r\n<p>&bull; Cartoonontwerp: het schattige cartoonontwerp van de maalkom maakt etenstijd leuker voor uw baby en moedigt hem aan om meer te eten.<br />\r\n&bull; Gemakkelijk te gebruiken: Het eenvoudige ontwerp van de voedselmolen maakt hem gemakkelijk te gebruiken, zelfs voor ouders die het druk hebben of moe zijn.</p>\r\n\r\n<p>&bull; Gemaakt van veilige materialen: De voedselmolen is gemaakt van hoogwaardig plastic dat veilig is voor je baby en gemakkelijk schoon te maken is.</p>', 520),
('App\\Model\\Product', 137, 'de', 'name', 'Baby-Ergänzungsnahrungsmühle, sechsteiliges Set, Baby-Cartoon-Konditionierungs-Mahlschüssel', 521),
('App\\Model\\Product', 137, 'de', 'description', '<p>Baby-Erg&auml;nzungsnahrungsm&uuml;hle, sechsteiliges Set, Baby-Cartoon-Konditionierungs-Mahlsch&uuml;ssel</p>\r\n\r\n<p>Beschreibung<br />\r\n&bull; Sechsteiliges Set: Dieses Set enth&auml;lt sechs verschiedene Arten von Lebensmitteln und ist somit eine vielseitige und vollst&auml;ndige L&ouml;sung f&uuml;r die Mahlzeiten Ihres Babys.</p>\r\n\r\n<p>&bull; Cartoon-Design: Das niedliche Cartoon-Design der Mahlsch&uuml;ssel sorgt daf&uuml;r, dass die Mahlzeiten f&uuml;r Ihr Baby mehr Spa&szlig; machen und es dazu animiert, mehr zu essen.<br />\r\n&bull; Einfache Bedienung: Das schlichte Design des Fleischwolfs macht die Bedienung auch f&uuml;r besch&auml;ftigte oder m&uuml;de Eltern einfach.</p>\r\n\r\n<p>&bull; Hergestellt aus sicheren Materialien: Der Fleischwolf besteht aus hochwertigem Kunststoff, der f&uuml;r Ihr Baby sicher zu verwenden und leicht zu reinigen ist.</p>', 522),
('App\\Model\\Product', 138, 'nl', 'name', 'Wuli Home Luie woonkamerbank Scandinavische stijl Luie vrijetijdsschommelende fauteuil Lichte luxe woonkamer Balkon Enkele fauteuil', 523),
('App\\Model\\Product', 138, 'nl', 'description', '<p>Wuli Home Luie woonkamerbank Scandinavische stijl Luie vrijetijdsschommelende fauteuil Lichte luxe woonkamer Balkon Enkele fauteuil<br />\r\nOmslag: echt leer<br />\r\nMaat: 95*85*68cm</p>', 524),
('App\\Model\\Product', 138, 'de', 'name', 'Wuli Home Faules Wohnzimmer-Sofa, nordischer Stil, faule Freizeit, Schaukelstuhl, leichter Luxus, Wohnzimmer, Balkon, Einzelsofa, Stuhl', 525),
('App\\Model\\Product', 138, 'de', 'description', '<p>Wuli Home Faules Wohnzimmer-Sofa, nordischer Stil, faule Freizeit, Schaukelstuhl, leichter Luxus, Wohnzimmer, Balkon, Einzelsofa, Stuhl<br />\r\nBezug: Echtes Leder<br />\r\nGr&ouml;&szlig;e: 95*85*68cm</p>', 526),
('App\\Model\\Product', 139, 'nl', 'name', 'Engels leren klein laptopspeelgoed voor kinderen. Computer voor jongens en meisjes voor alfabet ABC.Numbers.Words.Spelling.Maths.Music', 527),
('App\\Model\\Product', 139, 'nl', 'description', '<p>Engels leren klein laptopspeelgoed voor kinderen. Computer voor jongens en meisjes voor alfabet ABC.Numbers.Words.Spelling.Maths.Music</p>\r\n\r\n<p>Productparameters<br />\r\nProductnaam: Leermachine voor vroeg onderwijs<br />\r\nProductkleur: roze/blauw<br />\r\nGebruikte batterij: nr. 5 batterij * 3<br />\r\nToepasselijke leeftijd: 3 jaar en ouder<br />\r\nPakketgrootte: 16*4*13cm/6.3*1.57 * 5.11in<br />\r\nProductgrootte: 15,2*12,5*14cm/5,98*4,92 * 5,51in</p>\r\n\r\n<p>OPMERKINGEN: Door verschillende monitoren en licht kunnen kleurverschillen niet volledig worden vermeden</p>', 528),
('App\\Model\\Product', 139, 'de', 'name', 'Kleines Laptop-Spielzeug zum Englischlernen für Kinder. Jungen- und Mädchencomputer für Alphabet ABC.Zahlen.Wörter.Rechtschreibung.Mathematik.Musik', 529),
('App\\Model\\Product', 139, 'de', 'description', '<p>Kleines Laptop-Spielzeug zum Englischlernen f&uuml;r Kinder. Jungen- und M&auml;dchencomputer f&uuml;r Alphabet ABC.Zahlen.W&ouml;rter.Rechtschreibung.Mathematik.Musik<br />\r\nProduktparameter<br />\r\nProduktname: Fr&uuml;hp&auml;dagogische Lernmaschine<br />\r\nProduktfarbe: rosa/blau<br />\r\nVerwendete Batterie: Nr. 5 Batterie * 3<br />\r\nAnwendbares Alter: 3 Jahre und &auml;lter<br />\r\nPackungsgr&ouml;&szlig;e: 16 x 4 x 13 cm<br />\r\nProduktgr&ouml;&szlig;e: 15,2 x 12,5 x 14 cm</p>\r\n\r\n<p>HINWEISE: Aufgrund unterschiedlicher Monitore und Lichtverh&auml;ltnisse k&ouml;nnen Farbunterschiede nicht vollst&auml;ndig vermieden werden</p>', 530),
('App\\Model\\Product', 140, 'nl', 'name', 'ENFASHION Para Mujer OT Gesp Geometrie Ovale Ketting Voor Dames Sieraden Kettingen Roestvrij staal Mode Trendy Cocktail 3412', 531),
('App\\Model\\Product', 140, 'nl', 'description', '<p>ENFASHION Para Mujer OT Gesp Geometrie Ovale Ketting Voor Dames Sieraden Kettingen Roestvrij staal Mode Trendy Cocktail 3412<br />\r\n&nbsp;</p>\r\n\r\n<p>MATERIAAL<br />\r\nRoestvrij staal</p>\r\n\r\n<p>FUNCTIES<br />\r\nNikkelvrij/loodvrij/chroomvrij/hypoallergeen</p>', 532),
('App\\Model\\Product', 140, 'de', 'name', 'ENFASHION Para Mujer OT Schnalle Geometrie Oval Halskette Für frauen Schmuck Halsketten Edelstahl Mode Trendy Cocktail 3412', 533),
('App\\Model\\Product', 140, 'de', 'description', '<p>ENFASHION Para Mujer OT Schnalle Geometrie Oval Halskette F&uuml;r frauen Schmuck Halsketten Edelstahl Mode Trendy Cocktail 3412<br />\r\n&nbsp;</p>\r\n\r\n<p>MATERIAL<br />\r\nEdelstahl</p>\r\n\r\n<p>MERKMALE<br />\r\nNickelfrei/Bleifrei/Chromfrei/Hypoallergen</p>', 534),
('App\\Model\\Product', 141, 'nl', 'name', 'Universele Volledige Autohoes Regen Vorst Sneeuw Stof Waterdichte Bescherming Exterieur Autobeschermer Covers Anti UV Outdoor Zon Reflecterend', 535),
('App\\Model\\Product', 141, 'nl', 'description', '<p>Universele Volledige Autohoes Regen Vorst Sneeuw Stof Waterdichte Bescherming Exterieur Autobeschermer Covers Anti UV Outdoor Zon Reflecterend</p>', 536),
('App\\Model\\Product', 141, 'de', 'name', 'Universal Volle Auto Abdeckung Regen Frost Schnee Staub Wasserdicht Schutz Außen Auto Schutz Abdeckungen Anti UV Outdoor Sonne Reflektierende', 537),
('App\\Model\\Product', 141, 'de', 'description', '<p>Universal Volle Auto Abdeckung Regen Frost Schnee Staub Wasserdicht Schutz Au&szlig;en Auto Schutz Abdeckungen Anti UV Outdoor Sonne Reflektierende</p>\r\n\r\n<p>&nbsp;</p>', 538),
('App\\Model\\Product', 142, 'nl', 'name', 'SOYO AMD Radeon RX5700XT 8GB Gaming Grafische Kaart GDDR6 Videogeheugen 256Bit PCIEx16 4.0 voor Desktop Computer Videokaarten', 539),
('App\\Model\\Product', 142, 'nl', 'description', '<p>SOYO AMD Radeon RX5700XT 8GB Gaming Grafische Kaart GDDR6 Videogeheugen 256Bit PCIEx16 4.0 voor Desktop Computer Videokaarten<br />\r\n&nbsp;</p>\r\n\r\n<p>Product beschrijving:</p>\r\n\r\n<p>* Streamprocessor: 2560</p>\r\n\r\n<p>* Kernfrequentie: 1755-1905 MHz</p>\r\n\r\n<p>* Geheugenfrequentie: 1750 MHz</p>\r\n\r\n<p>* Kerntechnologie: 7 nm</p>\r\n\r\n<p>* Geheugencapaciteit: 8 GB</p>', 540),
('App\\Model\\Product', 142, 'de', 'name', 'SOYO AMD Radeon RX5700XT 8 GB Gaming-Grafikkarte GDDR6-Videospeicher 256 Bit PCIEx16 4.0 für Desktop-Computer-Grafikkarten', 541),
('App\\Model\\Product', 142, 'de', 'description', '<p>SOYO AMD Radeon RX5700XT 8 GB Gaming-Grafikkarte GDDR6-Videospeicher 256 Bit PCIEx16 4.0 f&uuml;r Desktop-Computer-Grafikkarten<br />\r\n&nbsp;</p>\r\n\r\n<p>Produktbeschreibung:</p>\r\n\r\n<p>* Stream-Prozessor: 2560</p>\r\n\r\n<p>* Kernfrequenz: 1755&ndash;1905 MHz</p>\r\n\r\n<p>* Speicherfrequenz: 1750 MHz</p>\r\n\r\n<p>* Kerntechnologie: 7 nm</p>\r\n\r\n<p>* Speicherkapazit&auml;t: 8 GB</p>', 542),
('App\\Model\\Product', 143, 'nl', 'name', 'Leren broek heren stretch slim-fit winterfleece gevoerd verdikt rijden strakke voeten warme man lederen motorbroek waterdicht', 543),
('App\\Model\\Product', 143, 'nl', 'description', '<p>Leren broek heren stretch slim-fit winterfleece gevoerd verdikt rijden strakke voeten warme man lederen motorbroek waterdicht</p>', 544),
('App\\Model\\Product', 143, 'de', 'name', 'Lederhose Herren Stretch Slim-Fit Winter Fleece-gefüttert Verdickt Reiten Enge Füße Warme Herren Leder Motorradhose Wasserdicht', 545),
('App\\Model\\Product', 143, 'de', 'description', '<p>Lederhose Herren Stretch Slim-Fit Winter Fleece-gef&uuml;ttert Verdickt Reiten Enge F&uuml;&szlig;e Warme Herren Leder Motorradhose Wasserdicht</p>', 546),
('App\\Model\\Product', 144, 'nl', 'name', 'Militaire canvas duffle sporttas sport reisbagage handtas draagtas schoudertas bruin 22,0\"', 547),
('App\\Model\\Product', 144, 'nl', 'description', '<p>Functies:</p>\r\n\r\n<p>1. Hoge kwaliteit: gemaakt van hoogwaardig en duurzaam canvasmateriaal, bekleed met polyester-katoenen doek.</p>\r\n\r\n<p>2. Eenvoudig ontwerp: hoofdcompartiment met gemakkelijk toegankelijke U-vormige opening en tweewegritssluiting, soepel en duurzaam in gebruik.</p>\r\n\r\n<p>3. Multifunctioneel: kan worden gebruikt als draagtas/schoudertas of als messengertas met de afneembare en verstelbare schouderband.</p>\r\n\r\n<p>4. Grote capaciteit: 22 inch hoofdvak staat hoog voor het eenvoudig inpakken van uw kleding, schoenen, paraplu, waterfles, enz.</p>\r\n\r\n<p>5. Gelegenheid: Canvas duffel past bij veelzijdige gelegenheden, zoals dagelijks gebruik, weekendactiviteiten in de buitenlucht, zakenreis, overnachting, kamperen, wandelen, klimmen, sport, vissen, enz. Genoeg ruimte voor kleding en reisbenodigdheden.</p>\r\n\r\n<p><br />\r\nSpecificatie:</p>\r\n\r\n<p>Materiaal: canvas</p>\r\n\r\n<p>Sluiting: Rits</p>\r\n\r\n<p>Voering: gecoat katoen-polyestermengsel</p>\r\n\r\n<p>Kleur bruin</p>\r\n\r\n<p>22&quot; Afmetingen: 22,0&quot; x 11&quot; x 10,2&quot; (L x B x H)</p>\r\n\r\n<p><br />\r\nPakket bestaat uit:</p>\r\n\r\n<p>1 x plunjezak</p>\r\n\r\n<p>&nbsp;</p>', 548),
('App\\Model\\Product', 144, 'de', 'name', 'Militär-Canvas-Reisetasche, Sporttasche, Reisegepäck, Handtasche, Tragetasche, Schultertasche, Braun, 55,9 cm', 549),
('App\\Model\\Product', 144, 'de', 'description', '<p>Merkmale:</p>\r\n\r\n<p>1. Hohe Qualit&auml;t: Hergestellt aus hochwertigem und langlebigem Canvas-Material, gef&uuml;ttert mit Polyester-Baumwollstoff.</p>\r\n\r\n<p>2. Einfaches Design: Hauptfach mit leicht zug&auml;nglicher U-f&ouml;rmiger &Ouml;ffnung und Zwei-Wege-Rei&szlig;verschluss, glatt und langlebig im Gebrauch.</p>\r\n\r\n<p>3. Multifunktional: Kann mit dem abnehmbaren und verstellbaren Schultergurt als Tragetasche oder Umh&auml;ngetasche verwendet werden.</p>\r\n\r\n<p>4. Gro&szlig;es Fassungsverm&ouml;gen: 22 Zoll. Das Hauptfach ist hoch, sodass Sie Ihre Kleidung, Schuhe, Regenschirme, Wasserflaschen usw. problemlos verstauen k&ouml;nnen.</p>\r\n\r\n<p>5. Anlass: Die Reisetasche aus Segeltuch eignet sich f&uuml;r vielseitige Anl&auml;sse wie den t&auml;glichen Gebrauch, Outdoor-Aktivit&auml;ten am Wochenende, Gesch&auml;ftsreisen, &Uuml;bernachtungsausfl&uuml;ge, Camping, Wandern, Klettern, Sport, Angeln usw. Gen&uuml;gend Platz f&uuml;r Kleidung und Reiseutensilien.</p>\r\n\r\n<p><br />\r\nSpezifikation:</p>\r\n\r\n<p>Material: Leinwand</p>\r\n\r\n<p>Verschluss: Rei&szlig;verschluss</p>\r\n\r\n<p>Futter: Beschichtetes Baumwoll-Polyester-Mischgewebe</p>\r\n\r\n<p>Farbe braun</p>\r\n\r\n<p>22&quot; Gr&ouml;&szlig;e: 22,0&quot; x 11&quot; x 10,2&quot; (L x B x H)</p>\r\n\r\n<p><br />\r\nPaket beinhaltet:</p>\r\n\r\n<p>1 x Reisetasche</p>\r\n\r\n<p>&nbsp;</p>', 550),
('App\\Model\\Product', 145, 'nl', 'name', 'Tandartsstoel Cover Unit PU-leer 4 stks/set Tandheelkundige stoel Elastische waterdichte beschermende beschermer Tandarts Equipme Tandheelkunde Lab', 551),
('App\\Model\\Product', 145, 'nl', 'description', '<p>Tandartsstoel Cover Unit PU-leer 4 stks/set Tandheelkundige stoel Elastische waterdichte beschermende beschermer Tandarts Equipme Tandheelkunde Lab<br />\r\n&nbsp;</p>\r\n\r\n<p>Deze paragraaf voor de 4pcs/1set tandartsstoelen:</p>\r\n\r\n<p>1. Een kussen + een doktersstoelkussen + een rugleuning + een kussen</p>\r\n\r\n<p>2. Eigenschappen van de stof: elastische mondtrek, acht elastische tandstoelen voor verschillende soorten stof, comfortabele huidafschuring, niet-pluis, geen ophangdraad vervaagt niet en geen vervorming. De beste ecologische tandbedekkingen.</p>\r\n\r\n<p>3. Grootte: 112CM-118CM</p>\r\n\r\n<p>Verpakking: 4 stuks/1 set</p>\r\n\r\n<p>Opmerking !!! Vanwege het verschil in licht en scherminstellingen kan de kleur van het artikel enigszins afwijken van de afbeeldingen.</p>', 552),
('App\\Model\\Product', 145, 'de', 'name', 'Dental Stuhl Abdeckung Einheit PU Leder 4 teile/satz Dental Sitz Elastische Wasserdichte Schutz Protector Zahnarzt Ausrüstung Zahnmedizin Labor', 553),
('App\\Model\\Product', 145, 'de', 'description', '<p>Dental Stuhl Abdeckung Einheit PU Leder 4 teile/satz Dental Sitz Elastische Wasserdichte Schutz Protector Zahnarzt Ausr&uuml;stung Zahnmedizin Labor<br />\r\n&nbsp;</p>\r\n\r\n<p>Dieser Absatz f&uuml;r die 4 St&uuml;ck/1 Satz Zahnarztst&uuml;hle:</p>\r\n\r\n<p>1. Ein Kissen + ein Arztstuhlkissen + eine R&uuml;ckenlehne + ein Kissen</p>\r\n\r\n<p>2. Stoffeigenschaften: Mundzug elastisch, acht elastische Zahnst&uuml;hle f&uuml;r verschiedene Stoffarten, angenehmer Hautabrieb, kein Pilling, kein h&auml;ngender Draht verblasst nicht und keine Verformung. Die besten umweltfreundlichen Zahnbel&auml;ge.</p>\r\n\r\n<p>3. Gr&ouml;&szlig;e: 112CM-118CM</p>\r\n\r\n<p>Verpackung: 4 St&uuml;ck/1 Satz</p>\r\n\r\n<p>Notiz !!! Aufgrund der unterschiedlichen Licht- und Bildschirmeinstellungen kann die Farbe des Artikels geringf&uuml;gig von der Abbildung abweichen.</p>', 554),
('App\\Model\\Category', 183, 'nl', 'name', 'Jassen', 555),
('App\\Model\\Category', 183, 'de', 'name', 'Jacken', 556),
('App\\Model\\Category', 184, 'nl', 'name', 'Een stukje', 557),
('App\\Model\\Category', 184, 'de', 'name', 'ein Stück', 558),
('App\\Model\\Category', 185, 'nl', 'name', 'Jeans', 559),
('App\\Model\\Category', 185, 'de', 'name', 'Jeans', 560),
('App\\Model\\Category', 186, 'nl', 'name', 'Sportkleding', 561),
('App\\Model\\Category', 186, 'de', 'name', 'Sportkleidung', 562),
('App\\Model\\Category', 187, 'nl', 'name', 'Damesportemonnee', 563),
('App\\Model\\Category', 187, 'de', 'name', 'Damen-Geldbörse', 564),
('App\\Model\\Category', 188, 'nl', 'name', 'Rugzak', 565),
('App\\Model\\Category', 188, 'de', 'name', 'Rucksack', 566),
('App\\Model\\Category', 189, 'nl', 'name', 'Fascia Pistool', 567),
('App\\Model\\Category', 189, 'de', 'name', 'Faszienpistole', 568),
('App\\Model\\Category', 190, 'nl', 'name', 'Make-up', 569),
('App\\Model\\Category', 190, 'de', 'name', 'Bilden', 570),
('App\\Model\\Category', 191, 'nl', 'name', 'Huidverzorging', 571),
('App\\Model\\Category', 191, 'de', 'name', 'Hautpflege', 572),
('App\\Model\\Category', 192, 'nl', 'name', 'Babyschoenen', 573),
('App\\Model\\Category', 192, 'de', 'name', 'Baby Schuhe', 574),
('App\\Model\\Category', 193, 'nl', 'name', 'Activiteit & Uitrusting', 575),
('App\\Model\\Category', 193, 'de', 'name', 'Activiteit en uitrusting', 576),
('App\\Model\\Category', 194, 'nl', 'name', 'Knuffeldieren', 577),
('App\\Model\\Category', 194, 'de', 'name', 'Stofftiere', 578),
('App\\Model\\Category', 195, 'nl', 'name', 'Actiespellen', 579),
('App\\Model\\Category', 195, 'de', 'name', 'Action Figur', 580),
('App\\Model\\Category', 196, 'nl', 'name', 'Strand Zandspeelgoed', 581),
('App\\Model\\Category', 196, 'de', 'name', 'Sandspielzeug für den Strand', 582),
('App\\Model\\Category', 197, 'nl', 'name', 'Tafels', 583),
('App\\Model\\Category', 197, 'de', 'name', 'Tische', 584),
('App\\Model\\Category', 198, 'nl', 'name', 'Paraplu\'s', 585),
('App\\Model\\Category', 198, 'de', 'name', 'Regenschirme', 586),
('App\\Model\\Category', 199, 'nl', 'name', 'Zilver', 587),
('App\\Model\\Category', 199, 'de', 'name', 'Silber', 588),
('App\\Model\\Category', 200, 'nl', 'name', 'Gouden Oorbellen', 589),
('App\\Model\\Category', 200, 'de', 'name', 'goldene Ohrringe', 590),
('App\\Model\\Category', 201, 'nl', 'name', 'Zonnebrillen', 591),
('App\\Model\\Category', 201, 'de', 'name', 'Schlüsselanhänger', 592),
('App\\Model\\Category', 202, 'nl', 'name', 'Computerchips', 593),
('App\\Model\\Category', 202, 'de', 'name', 'Computer-Chips', 594),
('App\\Model\\Category', 203, 'nl', 'name', 'Auto Stickers', 595),
('App\\Model\\Category', 203, 'de', 'name', 'Autoaufkleber', 596),
('App\\Model\\Category', 204, 'nl', 'name', 'Batterijen', 597),
('App\\Model\\Category', 204, 'de', 'name', 'Batterien', 598),
('App\\Model\\Category', 205, 'nl', 'name', 'Slimme Woning', 599),
('App\\Model\\Category', 205, 'de', 'name', 'Intelligentes Zuhause', 600),
('App\\Model\\Category', 206, 'nl', 'name', 'Voedingsmiddelen', 601),
('App\\Model\\Category', 206, 'de', 'name', 'Lebensmittel', 602),
('App\\Model\\Category', 207, 'nl', 'name', 'Dranken', 603),
('App\\Model\\Category', 207, 'de', 'name', 'Getränke', 604),
('App\\Model\\Category', 208, 'nl', 'name', 'Fruit & Groenten', 605),
('App\\Model\\Category', 208, 'de', 'name', 'Früchte, Gemüse', 606),
('App\\Model\\Category', 209, 'nl', 'name', 'Snacks', 607),
('App\\Model\\Category', 209, 'de', 'name', 'Snacks', 608),
('App\\Model\\Category', 210, 'nl', 'name', 'Melk & Zuivel', 609),
('App\\Model\\Category', 210, 'de', 'name', 'Milch und Milchprodukte', 610),
('App\\Model\\Category', 211, 'nl', 'name', 'Ontbijt', 611),
('App\\Model\\Category', 211, 'de', 'name', 'Frühstück', 612),
('App\\Model\\Product', 146, 'nl', 'name', 'SheeCute Meisjes Winter Warme Broek Kinderen Fleece Gevoerde Legging voor 3-11 Jaar SCW7101', 613),
('App\\Model\\Product', 146, 'nl', 'description', '<p>SheeCute Meisjes Winter Warme Broek Kinderen Fleece Gevoerde Legging voor 3-11 Jaar SCW7101</p>', 614),
('App\\Model\\Product', 146, 'de', 'name', 'SheeCute Mädchen-Winter-warme Hose, Kinder-Leggings mit Fleece-Futter, für 3–11 Jahre, SCW7101', 615),
('App\\Model\\Product', 146, 'de', 'description', '<p>SheeCute M&auml;dchen-Winter-warme Hose, Kinder-Leggings mit Fleece-Futter, f&uuml;r 3&ndash;11 Jahre, SCW7101</p>', 616),
('App\\Model\\Product', 147, 'nl', 'name', 'JJ Grappige popfunctie Kruipende baby met batterijvoeding Lachend zingen Begeleiden met uw kinderen Maat 10,5 inch', 617),
('App\\Model\\Product', 147, 'nl', 'description', '<p>JJ Grappige popfunctie Kruipende baby met batterijvoeding Lachend zingen Begeleiden met uw kinderen Maat 10,5 inch</p>', 618),
('App\\Model\\Product', 147, 'de', 'name', 'JJ Lustige Puppenfunktion, Krabbelbaby mit batteriebetriebenem Lachen, Singen, Begleiten Sie Ihre Kinder, Größe 10,5 Zoll', 619),
('App\\Model\\Product', 147, 'de', 'description', '<p>JJ Lustige Puppenfunktion, Krabbelbaby mit batteriebetriebenem Lachen, Singen, Begleiten Sie Ihre Kinder, Gr&ouml;&szlig;e 10,5 Zoll</p>', 620),
('App\\Model\\Product', 148, 'nl', 'name', 'JJ Grappige popfunctie Kruipende baby met batterijvoeding Lachend zingen Begeleiden met uw kinderen Maat 10,5 inch', 621),
('App\\Model\\Product', 148, 'nl', 'description', '<p>JJ Grappige popfunctie Kruipende baby met batterijvoeding Lachend zingen Begeleiden met uw kinderen Maat 10,5 inch<br />\r\nLengte<br />\r\n15,75 inch D<br />\r\nBreedte<br />\r\n31,3&quot; W<br />\r\nHoogte<br />\r\n24,61&quot; H<br />\r\nMet rollen: Ja<br />\r\nMaat<br />\r\n15,75 inch D x 31,3 inch B x 24,61 inch H<br />\r\nMateriaal: Houten</p>', 622),
('App\\Model\\Product', 148, 'de', 'name', 'JJ Lustige Puppenfunktion, Krabbelbaby mit batteriebetriebenem Lachen, Singen, Begleiten Sie Ihre Kinder, Größe 10,5 Zoll', 623),
('App\\Model\\Product', 148, 'de', 'description', '<p>JJ Lustige Puppenfunktion, Krabbelbaby mit batteriebetriebenem Lachen, Singen, Begleiten Sie Ihre Kinder, Gr&ouml;&szlig;e 10,5 Zoll<br />\r\nL&auml;nge<br />\r\n15,75&quot;D<br />\r\nBreite<br />\r\n31,3&quot;B<br />\r\nH&ouml;he<br />\r\n24,61&quot;H<br />\r\nMit Rollen: Ja<br />\r\nGr&ouml;&szlig;e<br />\r\n15,75&quot;T x 31,3&quot;B x 24,61&quot;H<br />\r\nMaterial: Holz</p>', 624),
('App\\Model\\Product', 149, 'nl', 'name', 'Luik 2023 Smart Horloge Voor Mannen Vrouwen Gift Volledig Touchscreen Sport Fitness Horloges Bluetooth Oproepen Digitale Smartwatch Horloge', 625),
('App\\Model\\Product', 149, 'nl', 'description', '<p>Luik 2023 Smart Horloge Voor Mannen Vrouwen Gift Volledig Touchscreen Sport Fitness Horloges Bluetooth Oproepen Digitale Smartwatch Horloge<br />\r\n&nbsp;</p>\r\n\r\n<p>&bull; Volledig touchscreen: de Lige 2023 smartwatch beschikt over een volledig touchscreen dat eenvoudige en intu&iuml;tieve navigatie mogelijk maakt.</p>\r\n\r\n<p>&bull; Bloeddrukmeter: Met een ingebouwde bloeddrukmeter kan deze smartwatch u helpen uw gezondheids- en conditieniveaus bij te houden.</p>\r\n\r\n<p>&bull; Meerdere wijzerplaten: kies uit verschillende wijzerplaten om uw Lige 2023 smartwatch aan uw persoonlijke stijl aan te passen.</p>\r\n\r\n<p>&bull; Calorietracker: houd uw dagelijkse calorieverbranding bij met de calorietrackerfunctie van de Lige 2023 smartwatch.</p>\r\n\r\n<p>&bull; Volledig touchscreen: het horloge beschikt over een volledig touchscreen waarmee u eenvoudig kunt navigeren en alle functies kunt gebruiken.</p>\r\n\r\n<p>&bull; Bloeddrukmeter: het horloge wordt geleverd met een bloeddrukmeter, zodat u uw gezondheids- en conditieniveau kunt volgen.</p>\r\n\r\n<p>&bull; Meerdere wijzerplaten: het horloge heeft meerdere wijzerplaten, zodat u het uiterlijk van uw horloge kunt aanpassen aan uw persoonlijke stijl.<br />\r\n&bull; Calorie Tracker: het horloge houdt uw calorie-inname en -verbruik bij, zodat u op koers kunt blijven met uw fitnessdoelen.<br />\r\nProductparameters<br />\r\nScherm: 1,69 inch TFT 240*280<br />\r\nAanraakpaneel: volledig touchscreen<br />\r\nBatterij: 180 mAh<br />\r\nApp: FitPro<br />\r\nOplaadmethode: magnetisch opladen<br />\r\nWaterdicht: IP67</p>', 626),
('App\\Model\\Product', 149, 'de', 'name', 'LIGE 2023 Smart Uhr Für Männer Frauen Geschenk Full Touch Screen Sport Fitness Uhren Bluetooth Anrufe Digitale Smartwatch Armbanduhr', 627),
('App\\Model\\Product', 149, 'de', 'description', '<p>LIGE 2023 Smart Uhr F&uuml;r M&auml;nner Frauen Geschenk Full Touch Screen Sport Fitness Uhren Bluetooth Anrufe Digitale Smartwatch Armbanduhr<br />\r\n&nbsp;</p>\r\n\r\n<p>&bull; Vollst&auml;ndiger Touchscreen: Die Lige 2023 Smartwatch verf&uuml;gt &uuml;ber einen vollst&auml;ndigen Touchscreen, der eine einfache und intuitive Navigation erm&ouml;glicht.</p>\r\n\r\n<p>&bull; Blutdruckmessger&auml;t: Mit einem integrierten Blutdruckmessger&auml;t kann Ihnen diese Smartwatch dabei helfen, den &Uuml;berblick &uuml;ber Ihre Gesundheit und Fitness zu behalten.</p>\r\n\r\n<p>&bull; Mehrere Zifferbl&auml;tter: W&auml;hlen Sie aus einer Vielzahl von Zifferbl&auml;ttern, um Ihre Lige 2023 Smartwatch an Ihren pers&ouml;nlichen Stil anzupassen.</p>\r\n\r\n<p>&bull; Kalorien-Tracker: Verfolgen Sie Ihren t&auml;glichen Kalorienverbrauch mit der Kalorien-Tracker-Funktion der Lige 2023 Smartwatch.</p>\r\n\r\n<p>&bull; Vollst&auml;ndiger Touchscreen: Die Uhr verf&uuml;gt &uuml;ber einen vollst&auml;ndigen Touchscreen, der die Navigation und die Nutzung aller Funktionen erleichtert.</p>\r\n\r\n<p>&bull; Blutdruckmessger&auml;t: Die Uhr ist mit einem Blutdruckmessger&auml;t ausgestattet, mit dem Sie Ihre Gesundheit und Fitness im Auge behalten k&ouml;nnen.</p>\r\n\r\n<p>&bull; Mehrere Zifferbl&auml;tter: Die Uhr verf&uuml;gt &uuml;ber mehrere Zifferbl&auml;tter, sodass Sie das Aussehen und die Haptik Ihrer Uhr an Ihren pers&ouml;nlichen Stil anpassen k&ouml;nnen.<br />\r\n&bull; Kalorien-Tracker: Die Uhr verfolgt Ihre Kalorienaufnahme und Ihren Kalorienverbrauch und hilft Ihnen, Ihre Fitnessziele im Auge zu behalten.<br />\r\nProduktparameter<br />\r\nBildschirm: 1,69 Zoll TFT 240 x 280<br />\r\nTouchpanel: Vollst&auml;ndiger Touchscreen<br />\r\nBatterie: 180 mAh<br />\r\nApp:FitPro<br />\r\nLademethode: Magnetische Aufladung<br />\r\nWasserdicht: IP67</p>', 628),
('App\\Model\\Product', 150, 'nl', 'name', 'QUICKLYNKS T31 Auto Volledige OBD2/EOBD Scanner Controleer Auto Motor Systeem Diagnostische Hulpmiddelen Automotive Professionele Code Reader Scanner', 629),
('App\\Model\\Product', 150, 'nl', 'description', '<p>QUICKLYNKS T31 Auto Volledige OBD2/EOBD Scanner Controleer Auto Motor Systeem Diagnostische Hulpmiddelen Automotive Professionele Code Reader Scanner</p>', 630),
('App\\Model\\Product', 150, 'de', 'name', 'QUICKLYNKS T31 Auto-Voll-OBD2/EOBD-Scanner, überprüft Auto-Motorsystem-Diagnosewerkzeuge, professioneller Automotive-Codeleser-Scanner', 631),
('App\\Model\\Product', 150, 'de', 'description', '<p>QUICKLYNKS T31 Auto-Voll-OBD2/EOBD-Scanner, &uuml;berpr&uuml;ft Auto-Motorsystem-Diagnosewerkzeuge, professioneller Automotive-Codeleser-Scanner</p>', 632),
('App\\Model\\Product', 151, 'nl', 'name', '2023 Global Versie Nieuwe PAD 6 PRO Tablet Android12 11 Inch 16GB 1T 5G Dual SIM telefoongesprek GPS Bluetooth WiFi Google Tablet PC', 633),
('App\\Model\\Product', 151, 'nl', 'description', '<p>2023 Global Versie Nieuwe PAD 6 PRO Tablet Android12 11 Inch 16GB 1T 5G Dual SIM telefoongesprek GPS Bluetooth WiFi Google Tablet PC<br />\r\nSpecificatie:<br />\r\nModelnummer: Pad 6 Pro<br />\r\nCPU: Snapdragon870 Deca Core (nieuwste 10 core)<br />\r\nSIM/TF: 2 SIM-kaartsleuven (Nano SIM) + 1 TF-kaartsleuven (maximale ondersteuningsuitbreiding 128 GB)<br />\r\nScherm: 11 inch 4K-scherm<br />\r\nResolutie: 2560*1600<br />\r\nCamera: camera aan de voorkant 16 MP + camera aan de achterkant 32 MP<br />\r\nGeheugen: 16GB RAM+1T ROM/12GB RAM+512GB/ROM 6GB RAM+128GB ROM<br />\r\nSysteem: Android 12-systeem<br />\r\nBatterij: 10.000 mAh lithium-ionbatterij met hoge dichtheid<br />\r\nUnieke achterkant: Hot Bend 3D-plating gradi&euml;nt glazen achterkant. Het is kunst, het is ook technologie!<br />\r\nNetwerk: GSM850/900/1800/1900MHz, 3G: WCDMA850/1900/2100MHz, 4G,5G<br />\r\nTrillingen: ondersteuning<br />\r\nMultimedia: MP3/MP4/3GP/FM-radio/Bluetooth<br />\r\nMultifunctioneel: volledig scherm, gezichtsherkenning, schermvingerafdruk, Dual SIM, Wifi, GPS, zwaartekrachtsensor, alarm,<br />\r\nKalender, rekenmachine, audiorecorder, videorecorder, WAP/MMS/GPR, beeldviewer, e-book, wereldklok<br />\r\nTalen: ondersteuning voor meerdere talen<br />\r\nDe tablet ondersteunt T-mobile, AT&amp;T, Straight Talk, Cricket Wireless, Google Project Fi, Lycamobile, MetroPCS, MintMobile en ondersteunt het Telecom CDMA-netwerk niet. (Bijvoorbeeld Amerikaanse operators: Verizon, Sprint, U.S Cellular, Boost Mobile, FreedomPop, Ting)</p>', 634),
('App\\Model\\Product', 151, 'de', 'name', '2023 Globale Version Neues PAD 6 PRO Tablet Android12 11 Zoll 16 GB 1T 5G Dual SIM Telefonanruf GPS Bluetooth WiFi Google Tablet PC', 635),
('App\\Model\\Product', 151, 'de', 'description', '<p>2023 Globale Version Neues PAD 6 PRO Tablet Android12 11 Zoll 16 GB 1T 5G Dual SIM Telefonanruf GPS Bluetooth WiFi Google Tablet PC<br />\r\nSpezifikation:<br />\r\nModellnummer: Pad 6 Pro<br />\r\nCPU: Snapdragon870 Deca Core (neueste 10 Core)<br />\r\nSIM/TF: 2 SIM-Kartensteckpl&auml;tze (Nano-SIM) + 1 TF-Kartensteckplatz (maximale Unterst&uuml;tzungserweiterung 128 GB)<br />\r\nBildschirm: 11 Zoll 4K-Bildschirm<br />\r\nAufl&ouml;sung: 2560 * 1600<br />\r\nKamera: Frontkamera 16 MP + R&uuml;ckkamera 32 MP<br />\r\nSpeicher: 16 GB RAM + 1T ROM/12 GB RAM + 512 GB/ ROM 6 GB RAM + 128 GB ROM<br />\r\nSystem: Android 12-System<br />\r\nBatterie: 10.000 mAh hochdichter Lithium-Ionen-Akku<br />\r\nEinzigartige R&uuml;ckseite: Hot Bend 3D-Beschichtung, R&uuml;ckseite aus Glas mit Farbverlauf. Es ist Kunst, es ist auch Technologie!<br />\r\nNetzwerk: GSM850/900/1800/1900 MHz, 3G: WCDMA850/1900/2100 MHz, 4G, 5G<br />\r\nVibration: Unterst&uuml;tzung<br />\r\nMultimedia: MP3/MP4/3GP/FM-Radio/Bluetooth<br />\r\nMultifunktion: Vollbild, Gesichtserkennung, Fingerabdruck auf dem Bildschirm, Dual-SIM, WLAN, GPS, Schwerkraftsensor, Alarm,<br />\r\nKalender, Rechner, Audiorecorder, Videorecorder, WAP/MMS/GPR, Bildbetrachter, E-Book, Weltzeituhr<br />\r\nSprachen: Mehrsprachige Unterst&uuml;tzung<br />\r\nDas Tablet unterst&uuml;tzt T-Mobile, AT&amp;T, Straight Talk, Cricket Wireless, Google Project Fi, Lycamobile, MetroPCS und MintMobile. Das Telekommunikations-CDMA-Netzwerk wird nicht unterst&uuml;tzt. (Zum Beispiel US-Betreiber: Verizon, Sprint, U.S. Cellular, Boost Mobile, FreedomPop, Ting)</p>', 636),
('App\\Model\\Product', 152, 'nl', 'name', 'Nieuw aangekomen 2023 Heren Winter Leren Jas Revers Fleece Motor Biker Leren Jas Heren Business Casual Lange Kunstleerjassen', 637),
('App\\Model\\Product', 152, 'nl', 'description', '<p>Nieuw aangekomen 2023 Heren Winter Leren Jas Revers Fleece Motor Biker Leren Jas Heren Business Casual Lange Kunstleerjassen</p>', 638),
('App\\Model\\Product', 152, 'de', 'name', 'Neu angekommen 2023 Männer Winter Leder Jacke Revers Fleece Motor Biker Leder Jacke Männer Business Casual Lange Faux Leder Mäntel', 639),
('App\\Model\\Product', 152, 'de', 'description', '<p>Neu angekommen 2023 M&auml;nner Winter Leder Jacke Revers Fleece Motor Biker Leder Jacke M&auml;nner Business Casual Lange Faux Leder M&auml;ntel</p>', 640),
('App\\Model\\Category', 212, 'nl', 'name', 'Fascia-pistool', 641),
('App\\Model\\Category', 212, 'de', 'name', 'Faszienpistole', 642),
('App\\Model\\Product', 153, 'nl', 'name', 'Nekmassageapparaat Elektrische roodlichttherapie Cervicales Vibrator Spierontspannen Schoudermassagegeweer Chiropractie Fasciageweer Nieuw', 643),
('App\\Model\\Product', 153, 'nl', 'description', '<p>Nekmassageapparaat Elektrische roodlichttherapie Cervicales Vibrator Spierontspannen Schoudermassagegeweer Chiropractie Fasciageweer Nieuw</p>', 644),
('App\\Model\\Product', 153, 'de', 'name', 'Nackenmassagegerät Elektrische Rotlichttherapie Zervikale Vibrator Muskel entspannen Schultermassagepistole Chiropraktik Faszienpistole Neu', 645),
('App\\Model\\Product', 153, 'de', 'description', '<p>Nackenmassageger&auml;t Elektrische Rotlichttherapie Zervikale Vibrator Muskel entspannen Schultermassagepistole Chiropraktik Faszienpistole Neu</p>', 646),
('App\\Model\\Product', 154, 'nl', 'name', 'EVA Baby Natte Doekjes Zak Bladpatroon Reinigingsdoekjes Draagtas Herbruikbare Milieuvriendelijke Flip Cover Tissue Box Babybenodigdheden', 647),
('App\\Model\\Product', 154, 'nl', 'description', '<p>✿ Premium kwaliteit bedkussen - zeer absorberende zachte voering houdt vocht weg van de babyhuid, ademend lekvrij EVA-compartiment aan de onderkant voorkomt dat vloeistof erdoorheen sijpelt.</p>\r\n\r\n<p>✿ Zuiniger en hygi&euml;nischer - Herbruikbaar en wasbaar en vervaagt niet, elk babyverschoonkussen heeft een kleine ingebouwde band voor gemakkelijk ophangen.</p>\r\n\r\n<p>✿ Geweldig voor in bed of onderweg - Het draagbare aankleedkussen kan worden gebruikt om de bedoppervlakken te beschermen, mocht uw baby zonder luier slapen. Hij kan ook worden opgevouwen, zodat u de luier van uw baby overal kunt verschonen.</p>\r\n\r\n<p>✿ Fluorescerend vrij - Er zijn geen schadelijke chemicali&euml;n die de babyhuid irriteren. Dit maakt onze inlegkruisjes een perfecte partner voor uw baby met een gevoelige huid.</p>\r\n\r\n<p>【Mat met patroon】Grootte van 70*50 cm, een mooi luieraankleedkussen met patroon beschermt uw baby tegen vuile oppervlakken en uw baby zal graag op dit wisselstation rusten.</p>', 648),
('App\\Model\\Product', 154, 'de', 'name', 'EVA Baby Feuchttücher Tasche Blatt Muster Reinigungstücher Tragetasche Wiederverwendbare Umweltfreundliche Flip Cover Tissue Box Säuglingsbedarf', 649),
('App\\Model\\Product', 154, 'de', 'description', '<p>✿ Hochwertige Bettunterlage &ndash; hochsaugf&auml;higes, weiches Futter h&auml;lt Feuchtigkeit von der Haut des Babys fern, atmungsaktives, auslaufsicheres EVA-Fach auf der Unterseite verhindert das Durchsickern von Fl&uuml;ssigkeit.</p>\r\n\r\n<p>✿ Sparsamer und hygienischer &ndash; wiederverwendbar, waschbar und verblasst nicht. Jede Wickelunterlage verf&uuml;gt &uuml;ber ein kleines Band zum bequemen Aufh&auml;ngen.</p>\r\n\r\n<p>✿ Ideal f&uuml;r im Bett oder unterwegs &ndash; die tragbare Wickelunterlage kann zum Schutz der Bettoberfl&auml;chen verwendet werden, falls Ihr Baby ohne Windel schl&auml;ft. Es l&auml;sst sich auch zusammenfalten, sodass Sie die Windel Ihres Babys &uuml;berall wechseln k&ouml;nnen.</p>\r\n\r\n<p>✿ Frei von Fluoreszenzmitteln &ndash; Es gibt keine sch&auml;dlichen Chemikalien, die die Haut des Babys reizen k&ouml;nnten. Das macht unsere Einlagen zum perfekten Partner f&uuml;r Ihr Baby mit empfindlicher Haut.</p>\r\n\r\n<p>【Gr&ouml;&szlig;e der gemusterten Matte】Gr&ouml;&szlig;e: 70 x 50 cm. Die sch&ouml;ne gemusterte Wickelunterlage sch&uuml;tzt Ihr Baby vor schmutzigen Oberfl&auml;chen und Ihr Baby wird es lieben, sich auf dieser Wickelstation auszuruhen.</p>', 650),
('App\\Model\\Product', 155, 'nl', 'name', 'BeauToday Chunky Sneakers Vrouwen Mesh Lederen Platform Schoenen Gemengde Kleuren Lace-Up Lady Trendy Trainers Dikke Zool Handgemaakte 29401', 651),
('App\\Model\\Product', 155, 'nl', 'description', '<p>BeauToday Chunky Sneakers Vrouwen Mesh Lederen Platform Schoenen Gemengde Kleuren Lace-Up Lady Trendy Trainers Dikke Zool Handgemaakte 29401</p>', 652),
('App\\Model\\Product', 155, 'de', 'name', 'BeauToday Chunky Sneakers Damen Mesh Leder Plateauschuhe Mischfarben Schnürung Lady Trendy Trainer Dicke Sohle Handgefertigt 29401', 653),
('App\\Model\\Product', 155, 'de', 'description', '<p>BeauToday Chunky Sneakers Damen Mesh Leder Plateauschuhe Mischfarben Schn&uuml;rung Lady Trendy Trainer Dicke Sohle Handgefertigt 29401</p>', 654),
('App\\Model\\Category', 213, 'nl', 'name', 'Tabel', 655),
('App\\Model\\Category', 213, 'de', 'name', 'Tabelle', 656),
('App\\Model\\Category', 214, 'nl', 'name', 'Vlees', 657),
('App\\Model\\Category', 214, 'de', 'name', 'Fleisch', 658),
('App\\Model\\Category', 215, 'nl', 'name', 'kippen', 659),
('App\\Model\\Category', 215, 'de', 'name', 'Hühner', 660),
('App\\Model\\Category', 216, 'nl', 'name', 'soep', 661),
('App\\Model\\Category', 216, 'de', 'name', 'Suppe', 662),
('App\\Model\\Category', 217, 'nl', 'name', 'water', 663),
('App\\Model\\Category', 217, 'de', 'name', 'Wasser', 664),
('App\\Model\\Category', 218, 'nl', 'name', 'Frisdrank', 665),
('App\\Model\\Category', 218, 'de', 'name', 'Limonade', 666),
('App\\Model\\Category', 219, 'nl', 'name', 'sap', 667),
('App\\Model\\Category', 219, 'de', 'name', 'Saft', 668),
('App\\Model\\Category', 220, 'nl', 'name', 'vruchten', 669),
('App\\Model\\Category', 220, 'de', 'name', 'Früchte', 670),
('App\\Model\\Category', 221, 'nl', 'name', 'groenten', 671),
('App\\Model\\Category', 221, 'de', 'name', 'Gemüse', 672),
('App\\Model\\Category', 222, 'nl', 'name', 'chips', 673),
('App\\Model\\Category', 222, 'de', 'name', 'Chips', 674),
('App\\Model\\Category', 223, 'nl', 'name', 'Nüsse', 675),
('App\\Model\\Category', 223, 'de', 'name', 'noten', 676),
('App\\Model\\Category', 224, 'nl', 'name', 'koekjes', 677),
('App\\Model\\Category', 224, 'de', 'name', 'Kekse', 678),
('App\\Model\\Category', 225, 'nl', 'name', 'Melk', 679),
('App\\Model\\Category', 225, 'de', 'name', 'Milch', 680),
('App\\Model\\Category', 226, 'nl', 'name', 'Kaas', 681),
('App\\Model\\Category', 226, 'de', 'name', 'Käse', 682),
('App\\Model\\Category', 227, 'nl', 'name', 'Yoghurt', 683),
('App\\Model\\Category', 227, 'de', 'name', 'Joghurt', 684),
('App\\Model\\Category', 228, 'nl', 'name', 'Eieren', 685),
('App\\Model\\Category', 228, 'de', 'name', 'Eier', 686),
('App\\Model\\Category', 229, 'nl', 'name', 'Bakkerij', 687),
('App\\Model\\Category', 229, 'de', 'name', 'Bäckerei', 688),
('App\\Model\\Category', 230, 'nl', 'name', 'Olijven', 689),
('App\\Model\\Category', 230, 'de', 'name', 'Oliven', 690),
('App\\Model\\Category', 231, 'nl', 'name', 'Films en pluche dieren', 691),
('App\\Model\\Category', 231, 'de', 'name', 'Filme und Plüschtiere', 692),
('App\\Model\\Category', 232, 'nl', 'name', 'Pluche rugzakken', 693),
('App\\Model\\Category', 232, 'de', 'name', 'Plüschrucksäcke', 694),
('App\\Model\\Product', 156, 'nl', 'name', 'Kawaii Sanrio Pluche Tas Cinnamoroll Rugzak Plushie My Melody Bag Anime Knuffels Leuke Rugzakken voor Meisjes Kerstcadeaus', 695),
('App\\Model\\Product', 156, 'nl', 'description', '<p>Kawaii Sanrio Pluche Tas Cinnamoroll Rugzak Plushie My Melody Bag Anime Knuffels Leuke Rugzakken voor Meisjes Kerstcadeaus<br />\r\nStijl: Fris en zoet<br />\r\nMateriaal: pluche<br />\r\nBagagetrendstijl: kleine vierkante tas<br />\r\nBagagegrootte: medium<br />\r\nPopulair element: borduurwerk<br />\r\nVoorraadtype: hele bestelling<br />\r\nVoeringtextuur: nylon<br />\r\nBagagevorm: verticale vierkante vorm<br />\r\nOpeningsmethode: ritssluiting<br />\r\nInterne structuur van de tas: tas voor mobiele telefoon<br />\r\nPatroon: Anime-cartoon<br />\r\nVerwerkingsmethode: zacht oppervlak<br />\r\nHardheid: zacht<br />\r\nMerk: Cartoon<br />\r\nMet of zonder tussenlaag: Nee<br />\r\nAantal schouderbanden: enkel<br />\r\nAfmeting: 26x20cm</p>', 696),
('App\\Model\\Product', 156, 'de', 'name', 'Kawaii Sanrio Plüschtasche Cinnamoroll Rucksack Plushie My Melody Bag Anime Stofftiere Niedliche Rucksäcke für Mädchen Weihnachtsgeschenke', 697),
('App\\Model\\Product', 156, 'de', 'description', '<p>Kawaii Sanrio Pl&uuml;schtasche Cinnamoroll Rucksack Plushie My Melody Bag Anime Stofftiere Niedliche Rucks&auml;cke f&uuml;r M&auml;dchen Weihnachtsgeschenke<br />\r\nStil: Frisch und s&uuml;&szlig;<br />\r\nMaterial: Pl&uuml;sch<br />\r\nGep&auml;ck-Trendstil: kleine quadratische Tasche<br />\r\nGep&auml;ckgr&ouml;&szlig;e: mittel<br />\r\nBeliebtes Element: Stickerei<br />\r\nInventartyp: ganze Bestellung<br />\r\nFutterstruktur: Nylon<br />\r\nGep&auml;ckform: vertikale quadratische Form<br />\r\n&Ouml;ffnungsmethode: Rei&szlig;verschluss<br />\r\nInterne Struktur der Tasche: Handytasche<br />\r\nMuster: Anime-Cartoon<br />\r\nVerarbeitungsart: weiche Oberfl&auml;che<br />\r\nH&auml;rte: weich<br />\r\nMarke: Cartoon<br />\r\nMit oder ohne Zwischenschicht: Nein<br />\r\nAnzahl der Schultergurte: einzeln<br />\r\nGr&ouml;&szlig;e: 26x20cm</p>', 698),
('App\\Model\\Product', 157, 'nl', 'name', 'Kleine familiewoonkamer in taillestijl, kleine salontafel, bijzettafel, eenvoudige hoektafel, hoektafel in snoepplaatstijl', 699),
('App\\Model\\Product', 157, 'nl', 'description', '<p>Kleine familiewoonkamer in taillestijl, kleine salontafel, bijzettafel, eenvoudige hoektafel, hoektafel in snoepplaatstijl</p>', 700),
('App\\Model\\Product', 157, 'de', 'name', 'Kleine Taille Stil Familie Wohnzimmer Schlafzimmer Kleiner Couchtisch Beistelltisch Einfacher Ecktisch Candy Plate Stil Ecktisch', 701),
('App\\Model\\Product', 157, 'de', 'description', '<p>Kleine Taille Stil Familie Wohnzimmer Schlafzimmer Kleiner Couchtisch Beistelltisch Einfacher Ecktisch Candy Plate Stil Ecktisch</p>', 702),
('App\\Model\\Product', 158, 'nl', 'name', 'Hip Hop 2 Stuks Iced CapsTeeth Grillz Kubieke Zirkoon Micro Pave Top & Bottom Charm Grills Voor Mannen Vrouwen Sieraden', 703),
('App\\Model\\Product', 158, 'nl', 'description', '<p>Hip Hop 2 Stuks Iced CapsTeeth Grillz Kubieke Zirkoon Micro Pave Top &amp; Bottom Charm Grills Voor Mannen Vrouwen Sieraden</p>', 704),
('App\\Model\\Product', 158, 'de', 'name', 'Hip Hop 2 Stück Iced CapsTeeth Grillz Kubikzircon Micro Pave Top & Bottom Charm Grills für Männer Frauen Schmuck', 705),
('App\\Model\\Product', 158, 'de', 'description', '<p>Hip Hop 2 St&uuml;ck Iced CapsTeeth Grillz Kubikzircon Micro Pave Top &amp; Bottom Charm Grills f&uuml;r M&auml;nner Frauen Schmuck</p>', 706),
('App\\Model\\Product', 159, 'nl', 'name', '46 Stuks Auto Reparatie Tool Kit 1/4-Inch Socket Set Auto Reparatie Tool Ratel Momentsleutel Combo Auto Repareren set Monteur Tool', 707),
('App\\Model\\Product', 159, 'nl', 'description', '<p>46 Stuks Auto Reparatie Tool Kit 1/4-Inch Socket Set Auto Reparatie Tool Ratel Momentsleutel Combo Auto Repareren set Monteur Tool<br />\r\n&nbsp;</p>\r\n\r\n<p>Beschrijving<br />\r\n&bull; 46-delige autoreparatieset: deze set bevat 46 essenti&euml;le gereedschappen voor het repareren van auto&#39;s, waardoor het een uitgebreide oplossing is voor al uw autoreparatiebehoeften.</p>\r\n\r\n<p>&bull; 1/4-inch doppenset: De 1/4-inch doppenset maakt eenvoudige en effici&euml;nte bevestiging aan diverse auto-onderdelen mogelijk, waardoor reparaties gemakkelijker worden.</p>\r\n\r\n<p>&bull; Combinatie van ratelmomentsleutels: De combinatie van ratelmomentsleutels zorgt ervoor dat de juiste hoeveelheid koppel op elke bout of moer wordt uitgeoefend, waardoor te vast of te weinig aandraaien wordt voorkomen.</p>\r\n\r\n<p>&bull; Mechanisch gereedschap: deze mechanische gereedschapsset is ontworpen om u te helpen elke autoreparatieklus met gemak en vertrouwen uit te voeren.</p>', 708),
('App\\Model\\Product', 159, 'de', 'name', '46-teiliges Auto-Reparatur-Werkzeug-Set, 1/4-Zoll-Steckschlüsselsatz, Auto-Reparatur-Werkzeug, Ratsche, Drehmomentschlüssel, Combo, Auto-Reparatur-Set, Mechaniker-Werkzeug', 709),
('App\\Model\\Product', 159, 'de', 'description', '<p>46-teiliges Auto-Reparatur-Werkzeug-Set, 1/4-Zoll-Steckschl&uuml;sselsatz, Auto-Reparatur-Werkzeug, Ratsche, Drehmomentschl&uuml;ssel, Combo, Auto-Reparatur-Set, Mechaniker-Werkzeug<br />\r\n&nbsp;</p>\r\n\r\n<p>Beschreibung<br />\r\n&bull; 46-teiliges Autoreparatur-Werkzeugset: Dieses Kit enth&auml;lt 46 wichtige Werkzeuge f&uuml;r die Autoreparatur und ist somit eine umfassende L&ouml;sung f&uuml;r alle Ihre Autoreparaturanforderungen.</p>\r\n\r\n<p>&bull; 1/4-Zoll-Steckschl&uuml;sselsatz: Der 1/4-Zoll-Steckschl&uuml;sselsatz erm&ouml;glicht eine einfache und effiziente Befestigung an verschiedenen Autoteilen und erleichtert so Reparaturen.</p>\r\n\r\n<p>&bull; Ratschen-Drehmomentschl&uuml;ssel-Kombination: Die Ratschen-Drehmomentschl&uuml;ssel-Kombination sorgt daf&uuml;r, dass auf jede Schraube oder Mutter das richtige Drehmoment ausge&uuml;bt wird, und verhindert so ein zu starkes oder zu geringes Anziehen.</p>\r\n\r\n<p>&bull; Mechaniker-Werkzeug: Dieses Mechaniker-Werkzeugset wurde entwickelt, um Ihnen dabei zu helfen, jede Autoreparaturaufgabe mit Leichtigkeit und Zuversicht zu bew&auml;ltigen.</p>\r\n\r\n<p>&nbsp;</p>', 710),
('App\\Model\\Product', 160, 'nl', 'name', 'Originele Samsung Galaxy A71 5G A716U/U1 mobiele telefoon 6,7 \"RAM 6GB ROM 128GB 4 camera vingerafdruk Android ontgrendeld smartphone', 711);
INSERT INTO `translations` (`translationable_type`, `translationable_id`, `locale`, `key`, `value`, `id`) VALUES
('App\\Model\\Product', 160, 'nl', 'description', '<p>Originele Samsung Galaxy A71 5G A716U/U1 mobiele telefoon 6,7 &quot;RAM 6GB ROM 128GB 4 camera vingerafdruk Android ontgrendeld smartphone<br />\r\n&nbsp;</p>\r\n\r\n<p>1. Over de versie: U/U1 is de Amerikaanse versie die geen OTA-update ondersteunt, maar U1 ondersteunt OTA-update, we sturen de U1-versie naar klanten. Over Globale versie met volledige talen en ondersteunt OTA-update.</p>\r\n\r\n<p>2. Over Taal: Voor de U/U1-versie zijn er, wanneer u de telefoon aanzet, mogelijk alleen de taalopties Duits/Frans/Spaans/Portugees/Italiaans/Japans/Koreaans/Vietnamees/Chinees, maar u kunt uw talen zelf toevoegen gemakkelijk. Als u niet weet hoe u dit moet doen, neem dan contact met ons op voor een video van de instelling.</p>\r\n\r\n<p>Voor de U/U1-versie zijn sommige talen (zoals Russisch, Arabisch, Hebreeuws, Pools, enz.) slechts gedeeltelijk beschikbaar op deze telefoon. Dat betekent dat zelfs als u de standaardtaal instelt op Russisch/Arabisch/Hebreeuws/Pools, er nog steeds ongeveer 50% van de menu&#39;s in het Engels wordt weergegeven. Maar de andere talen zijn voltooid.<br />\r\n3.Over geheugen: de interne opslag zal kleiner zijn dan de specificatie, omdat een deel ervan zal worden ingenomen door ingebouwde systemen en apps. Het ROM is bijvoorbeeld 128 GB, maar er kan slechts 110-123 GB worden gebruikt, dit is normaal.<br />\r\n4. Over de batterij: de batterijeffici&euml;ntie van de telefoon zal lager zijn dan de standaard. Normaal gesproken bedraagt de batterijcapaciteit ongeveer 80%-90%. We accepteren geen tests van de applicatie van derden.<br />\r\n5. Over de telefoon: TestDit is een gebruikte telefoon, niet gloednieuw. We zullen de telefoon testen om er zeker van te zijn dat deze goed werkt en ook in goede staat verkeert.</p>\r\n\r\n<p>6. Over waterdicht: de telefoons ondersteunen GEEN waterdichtheid meer, omdat de telefoon de nieuwe behuizing van de GEBRUIKTE telefoon verwisselt.<br />\r\n7.Over accessoires: alle accessoires zijn niet origineel, maar van goede kwaliteit. Elk geschil over &quot;nepaccessoires&quot; wordt niet geaccepteerd, we bieden geen garantie op de accessoires</p>', 712),
('App\\Model\\Product', 160, 'de', 'name', 'Original Samsung Galaxy A71 5G A716U/U1 Handy 6,7 Zoll RAM 6 GB ROM 128 GB 4 Kameras Fingerabdruck Android entsperrtes Smartphone', 713),
('App\\Model\\Product', 160, 'de', 'description', '<p>Original Samsung Galaxy A71 5G A716U/U1 Handy 6,7 Zoll RAM 6 GB ROM 128 GB 4 Kameras Fingerabdruck Android entsperrtes Smartphone<br />\r\n&nbsp;</p>\r\n\r\n<p>1.&Uuml;ber die Version: U/U1 ist die US-Version, die kein OTA-Update unterst&uuml;tzt, aber U1 unterst&uuml;tzt das OTA-Update. Wir senden die U1-Version an Kunden. &Uuml;ber die globale Version mit vollst&auml;ndigen Sprachen und unterst&uuml;tzt OTA-Updates.</p>\r\n\r\n<p>2. Informationen zur Sprache: Wenn Sie das Telefon f&uuml;r die U/U1-Version einschalten, stehen m&ouml;glicherweise nur die Sprachen Deutsch/Franz&ouml;sisch/Spanisch/Portugiesisch/Italienisch/Japanisch/Koreanisch/Vietnamesisch/Chinesisch zur Verf&uuml;gung, Sie k&ouml;nnen Ihre Sprachen jedoch selbst hinzuf&uuml;gen leicht. Wenn Sie nicht wissen, wie es geht, kontaktieren Sie uns bitte, um ein Video der Einstellung zu erhalten.</p>\r\n\r\n<p>Bei der U/U1-Version sind einige Sprachen (wie Russisch, Arabisch, Hebr&auml;isch, Polnisch usw.) in diesem Telefon nur teilweise verf&uuml;gbar. Das hei&szlig;t, selbst wenn Sie die Standardsprache auf Russisch / Arabisch / Hebr&auml;isch / Polnisch einstellen, werden immer noch etwa 50 % der Men&uuml;s auf Englisch angezeigt. Aber die anderen Sprachen sind fertig.<br />\r\n3.&Uuml;ber den Speicher: Der interne Speicher wird geringer sein als die Spezifikation, da ein Teil davon von integrierten Systemen und Apps belegt wird. Das ROM ist beispielsweise 128 GB gro&szlig;, aber es k&ouml;nnen nur 110-123 GB verwendet werden, das ist normal.<br />\r\n4. Informationen zum Akku: Die Akkuleistung des Telefons liegt unter dem Standard. Normalerweise betr&auml;gt die Batteriekapazit&auml;t etwa 80&ndash;90 %. Wir akzeptieren keine Tests von Drittanbieteranwendungen.<br />\r\n5. &Uuml;ber das Telefon: TestDies ist ein gebrauchtes Telefon, nicht ganz neu. Wir werden das Telefon testen, um sicherzustellen, dass es einwandfrei funktioniert und sich in gutem Zustand befindet.</p>\r\n\r\n<p>6. Informationen zur Wasserdichtigkeit: Die Telefone unterst&uuml;tzen KEINE Wasserdichtigkeit mehr, da das Telefon das neue Geh&auml;use des GEBRAUCHTEN Telefons austauscht.<br />\r\n7.&Uuml;ber Zubeh&ouml;r: Alle Zubeh&ouml;rteile sind nicht original, aber von guter Qualit&auml;t. Streitigkeiten wegen &bdquo;gef&auml;lschtem Zubeh&ouml;r&ldquo; werden nicht akzeptiert, wir bieten keine Garantie f&uuml;r das Zubeh&ouml;r</p>\r\n\r\n<p>&nbsp;</p>', 714),
('App\\Model\\Product', 161, 'nl', 'name', 'Fork In The Road Foods, kleine lekkernijen, 12 ounce', 715),
('App\\Model\\Product', 161, 'nl', 'description', '<p>Ingredi&euml;nten<br />\r\nRundvlees uit de wei, water, bevat 2% of minder van het volgende: ui, knoflook, mosterd, paprika, selderiepoeder, azijn, zout, suiker, extracten van paprika, piment, koriander, nootmuskaat, rode peper, rozemarijn.<br />\r\nOver dit artikel<br />\r\nMerk Fork In The Road Foods<br />\r\nMaat 12 ounce<br />\r\nSmaak Rundvlees<br />\r\nArtikelgewicht 12 gram<br />\r\nSpeciale tijdelijke aanduiding<br />\r\nNiet-uitgeharde rundvleescocktail Franks<br />\r\nGecertificeerd voor dierenwelzijn GAP Stap 4 Rundvlees met weiland<br />\r\nGemaakt in onze familiekeukens in Noord-Californi&euml;<br />\r\nGeen chemische nitraten of nitrieten<br />\r\nGluten-, soja- en zuivelvrij</p>', 716),
('App\\Model\\Product', 161, 'de', 'name', 'Fork In The Road Foods, kleine Leckereien, 12 Unzen', 717),
('App\\Model\\Product', 161, 'de', 'description', '<p>Fork In The Road Foods, kleine Leckereien, 12 Unzen<br />\r\nZutaten<br />\r\nWeiderindfleisch, Wasser, enth&auml;lt 2 % oder weniger der folgenden Bestandteile: Zwiebel, Knoblauch, Senf, Paprika, Selleriepulver, Essig, Salz, Zucker, Paprikaextrakte, Piment, Koriander, Muskatnuss, roter Pfeffer, Rosmarin.<br />\r\n&Uuml;ber diesen Artikel<br />\r\nMarke Fork In The Road Foods<br />\r\nGr&ouml;&szlig;e 12 Unzen<br />\r\nGeschmacksrichtung Rindfleisch<br />\r\nArtikelgewicht 12 Unzen<br />\r\nPlatzhalter f&uuml;r Spezialgebiete<br />\r\nCocktail-Franks aus ungep&ouml;keltem Weiderindfleisch<br />\r\nTierschutzzertifiziertes GAP Step 4 Weiderindfleisch<br />\r\nHergestellt in unseren familiengef&uuml;hrten K&uuml;chen in Nordkalifornien<br />\r\nKeine chemischen Nitrate oder Nitrite<br />\r\nGluten-, Soja- und Milchfrei</p>', 718),
('App\\Model\\Product', 162, 'nl', 'name', 'Bloedsinaasappelen - doos van 18 pond', 719),
('App\\Model\\Product', 162, 'nl', 'description', '<p>Bloedsinaasappelen - doos van 18 pond</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 200px; top: -4.8px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 720),
('App\\Model\\Product', 162, 'de', 'name', 'Blutorangen – 18-Pfund-Karton', 721),
('App\\Model\\Product', 162, 'de', 'description', '<p>Blutorangen &ndash; 18-Pfund-Karton</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 184px; top: -4.8px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 722),
('App\\Model\\Product', 163, 'nl', 'name', 'Kelm Int. Poland Spring 8 oz mini-waterflessen - 24-pack mini-flesjes bronwater voor onderweg en thuiskantoor - BPA-vrij en recyclebaar', 723),
('App\\Model\\Product', 163, 'nl', 'description', '<p>Kelm Int. Poland Spring 8 oz mini-waterflessen - 24-pack mini-flesjes bronwater voor onderweg en thuiskantoor - BPA-vrij en recyclebaar<br />\r\nBULLETPROOF FRESHNESS LOCKDOWN - Ervaar de perfectie van de verpakking met onze mini-waterflessen van 24 stuks. Elke fles is goed afgesloten voor een lekvrije levering, waardoor de versheid tot aan de eerste slok wordt gegarandeerd. Geniet van maximale tevredenheid met Poland Spring Water 24-pack, de ultieme oplossing. Blijf verfrist en blij met onze perfect bewaarde mini-waterflessen, verkrijgbaar in een handig pakket van 24 stuks. Vertrouw op het merk dat versheid beheerst &ndash; kies Poland Spring voor een onge&euml;venaarde drinkervaring.</p>', 724),
('App\\Model\\Product', 163, 'de', 'name', 'Kelm Int. Poland Spring 8 oz Mini-Wasserflaschen – 24er-Pack Mini-Quellwasser in Flaschen für unterwegs und im Heimbüro – BPA-frei und recycelbar', 725),
('App\\Model\\Product', 163, 'de', 'description', '<p>Kelm Int. Poland Spring 8 oz Mini-Wasserflaschen &ndash; 24er-Pack Mini-Quellwasser in Flaschen f&uuml;r unterwegs und im Heimb&uuml;ro &ndash; BPA-frei und recycelbar<br />\r\nKugelsichere Frische-Sperre &ndash; Erleben Sie Verpackungsperfektion mit unseren Mini-Wasserflaschen im 24er-Pack. Jede Flasche ist f&uuml;r eine auslaufsichere Lieferung dicht verschlossen und sorgt so f&uuml;r Frische bis zum ersten Schluck. Genie&szlig;en Sie h&ouml;chste Zufriedenheit mit der 24er-Packung von Poland Spring Water, der ultimativen L&ouml;sung. Bleiben Sie erfrischt und gl&uuml;cklich mit unseren perfekt konservierten Mini-Wasserflaschen, erh&auml;ltlich im praktischen 24er-Pack. Vertrauen Sie der Marke, die Frische meistert &ndash; entscheiden Sie sich f&uuml;r Poland Spring f&uuml;r ein unvergleichliches Trinkerlebnis.</p>', 726),
('App\\Model\\Product', 164, 'nl', 'name', 'Lenovo IdeaPad 3i 14 laptop, student en zakelijk, 14\" FHD scherm, Intel i3-1115G4 processor, 20GB RAM, 1TB SSD, HDMI, mediakaartlezer, webcam, Dolby Audio, Wi-Fi 6, Windows 11 Home, platinagrijs', 727),
('App\\Model\\Product', 164, 'nl', 'description', '<p>Lenovo IdeaPad 3i 14 laptop, student en zakelijk, 14&quot; FHD scherm, Intel i3-1115G4 processor, 20GB RAM, 1TB SSD, HDMI, mediakaartlezer, webcam, Dolby Audio, Wi-Fi 6, Windows 11 Home, platinagrijs<br />\r\nMerk Lenovo<br />\r\nModelnaam IdeaPad<br />\r\nSchermgrootte 14 inch<br />\r\nKleur Grijs<br />\r\nGrootte harde schijf 512 GB<br />\r\nCPU-model Core i3-familie<br />\r\nRam-geheugen Ge&iuml;nstalleerde grootte 12 GB<br />\r\nBesturingssysteem Windows 11 Home<br />\r\nSpeciale functie Dolby<br />\r\nGrafische kaart Beschrijving Ge&iuml;ntegreerd</p>', 728),
('App\\Model\\Product', 164, 'de', 'name', 'Lenovo IdeaPad 3i 14 Laptop, Student und Business, 14-Zoll-FHD-Bildschirm, Intel i3-1115G4-Prozessor, 20 GB RAM, 1 TB SSD, HDMI, Medienkartenleser, Webcam, Dolby Audio, Wi-Fi 6, Windows 11 Home, Platingrau', 729),
('App\\Model\\Product', 164, 'de', 'description', '<p>Lenovo IdeaPad 3i 14 Laptop, Student und Business, 14-Zoll-FHD-Bildschirm, Intel i3-1115G4-Prozessor, 20 GB RAM, 1 TB SSD, HDMI, Medienkartenleser, Webcam, Dolby Audio, Wi-Fi 6, Windows 11 Home, Platingrau<br />\r\nMarke Lenovo<br />\r\nModellname IdeaPad<br />\r\nBildschirmgr&ouml;&szlig;e 14 Zoll<br />\r\nFarbe Grau<br />\r\nFestplattengr&ouml;&szlig;e 512 GB<br />\r\nCPU-Modell der Core i3-Familie<br />\r\nInstallierter RAM-Speicher: 12 GB<br />\r\nBetriebssystem Windows 11 Home<br />\r\nBesonderheit Dolby<br />\r\nBeschreibung der Grafikkarte: Integriert</p>', 730),
('App\\Model\\Product', 165, 'nl', 'name', 'Papitas Margarita Con Limon-citroen gearomatiseerde chips', 731),
('App\\Model\\Product', 165, 'nl', 'description', '<p>Papitas Margarita Con Limon-citroen gearomatiseerde chips<br />\r\nMaat 12,28 ounce (pak van 1)<br />\r\nMerk Margarita<br />\r\nPakketgewicht 0,34 kilogram<br />\r\nAantal stuks 1<br />\r\nTemperatuur Conditie Vers</p>', 732),
('App\\Model\\Product', 165, 'de', 'name', 'Papitas Margarita Con Limon-Zitronen-Chips', 733),
('App\\Model\\Product', 165, 'de', 'description', '<p>Papitas Margarita Con Limon-Zitronen-Chips<br />\r\nGr&ouml;&szlig;e: 12,28 Unzen (1 St&uuml;ck)<br />\r\nMarke Margarita<br />\r\nPaketgewicht 0,34 Kilogramm<br />\r\nAnzahl der Teile 1<br />\r\nTemperaturzustand Frisch</p>', 734),
('App\\Model\\Product', 167, 'nl', 'name', 'Boerenerfmix Vruchtbare kippenbroedeieren grootgebracht op biologisch (12 eieren)', 735),
('App\\Model\\Product', 167, 'nl', 'description', '<p>Boerenerfmix Vruchtbare kippenbroedeieren grootgebracht op biologisch (12 eieren)</p>', 736),
('App\\Model\\Product', 167, 'de', 'name', 'Barnyard Mix Fruchtbare Hühnerbruteier aus biologischer Aufzucht (12 Eier)', 737),
('App\\Model\\Product', 167, 'de', 'description', '<p>Barnyard Mix Fruchtbare H&uuml;hnerbruteier aus biologischer Aufzucht (12 Eier)</p>', 738),
('App\\Model\\Product', 168, 'nl', 'name', 'Automatische Snelopening Klamboe Hangmat Outdoor Camping Pole Hangmat Schommel Anti-rollover Nylon Schommelstoel 260x140cm', 739),
('App\\Model\\Product', 168, 'nl', 'description', '<p>Automatische Snelopening Klamboe Hangmat Outdoor Camping Pole Hangmat Schommel Anti-rollover Nylon Schommelstoel 260x140cm<br />\r\n&nbsp;</p>\r\n\r\n<p>Naam: paal klamboe hangmat</p>\r\n\r\n<p>Stof: 210T gerimpeld nylon (algemeen bekend als parachutedoek) + polyester mesh<br />\r\nMaat: 260*140cm Handmatige meetfout 3%<br />\r\nVerpakking: dezelfde kleur stof + opp zakverpakking<br />\r\nLager: veilig lager 200 kg<br />\r\nAccessoires: 8 cm zilveren ijzeren gesp*2, zeer sterke polyester band*2, samengevoegde opbergtas*1</p>', 740),
('App\\Model\\Product', 168, 'de', 'name', 'Automatische, schnell öffnende Moskitonetz-Hängematte, Outdoor-Camping-Stange, Hängemattenschaukel, Anti-Überschlag-Nylon-Schaukelstuhl, 260 x 140 cm', 741),
('App\\Model\\Product', 168, 'de', 'description', '<p>Automatische, schnell &ouml;ffnende Moskitonetz-H&auml;ngematte, Outdoor-Camping-Stange, H&auml;ngemattenschaukel, Anti-&Uuml;berschlag-Nylon-Schaukelstuhl, 260 x 140 cm<br />\r\n&nbsp;</p>\r\n\r\n<p>Name: H&auml;ngematte mit Moskitonetz</p>\r\n\r\n<p>Stoff: 210T geknittertes Nylon (allgemein bekannt als Fallschirmtuch) + Polyesternetz<br />\r\nGr&ouml;&szlig;e: 260 x 140 cm. Manueller Messfehler 3 %.<br />\r\nVerpackung: gleichfarbiger Stoff + OPP-Beutelverpackung<br />\r\nLager: sicheres Lager 200 kg<br />\r\nZubeh&ouml;r: 8 cm silberne Eisenschnalle*2, hochfestes Polyestergewebe*2, verbundene Aufbewahrungstasche*1</p>', 742),
('App\\Model\\Product', 169, 'nl', 'name', 'Mode voor heren, ongepositioneerd, geruit overhemd met capuchon, gewatteerde voering, geruit overhemd met knopen, fluweel om warm te blijven, jas met capuchon', 743),
('App\\Model\\Product', 169, 'nl', 'description', '<p>Mode voor heren, ongepositioneerd, geruit overhemd met capuchon, gewatteerde voering, geruit overhemd met knopen, fluweel om warm te blijven, jas met capuchon</p>', 744),
('App\\Model\\Product', 169, 'de', 'name', 'Herren Unpositioned Fashion Hooded Plaid Kariertes, gestepptes, gefüttertes Button-Down-Karohemd für Herren Fügen Sie Samt hinzu, um warm zu bleiben Jacke mit Kapuze', 745),
('App\\Model\\Product', 169, 'de', 'description', '<p>Herren Unpositioned Fashion Hooded Plaid Kariertes, gestepptes, gef&uuml;ttertes Button-Down-Karohemd f&uuml;r Herren F&uuml;gen Sie Samt hinzu, um warm zu bleiben Jacke mit Kapuze</p>', 746),
('App\\Model\\Product', 170, 'nl', 'name', 'Handtassen Voor Vrouwen 2023 Designer Luxe Nieuwe Mode Veelzijdige High-End Crossbody Tas Gedrukt Een Schouder Kleine Vierkante Tas', 747),
('App\\Model\\Product', 170, 'nl', 'description', '<p>Handtassen Voor Vrouwen 2023 Designer Luxe Nieuwe Mode Veelzijdige High-End Crossbody Tas Gedrukt Een Schouder Kleine Vierkante Tas</p>', 748),
('App\\Model\\Product', 170, 'de', 'name', 'Handtaschen für Frauen 2023 Designer Luxus Neue Mode Vielseitige High-end-Umhängetasche Gedruckt Eine Schulter Kleine Quadratische Tasche', 749),
('App\\Model\\Product', 170, 'de', 'description', '<p>Handtaschen f&uuml;r Frauen 2023 Designer Luxus Neue Mode Vielseitige High-end-Umh&auml;ngetasche Gedruckt Eine Schulter Kleine Quadratische Tasche</p>', 750),
('App\\Model\\Product', 171, 'nl', 'name', 'Kosher Mre-vleesmaaltijden, klaar om te eten, verscheidenheid aan gevulde kippenborst, kalkoenshwarma, kip met been (bundel van 3 stuks) - bereid voorgerecht Volledig gekookt, houdbaar magnetrondiner', 751),
('App\\Model\\Product', 171, 'nl', 'description', '<p>Kosher Mre-vleesmaaltijden, klaar om te eten, verscheidenheid aan gevulde kippenborst, kalkoenshwarma, kip met been (bundel van 3 stuks) - bereid voorgerecht Volledig gekookt, houdbaar magnetrondiner<br />\r\nSmaak en voeding: Als u niet thuis bent of geen tijd heeft om te koken, zijn onze houdbare Glatt Kosher-vleesmaaltijden de perfecte oplossing om geweldige smaak en uitstekende voeding te bieden. Kwaliteit en zorg: Wij bereiden elke heerlijke, houdbare koosjere maaltijd met alleen de hoogste kwaliteit, ingredi&euml;nten en zorg. Vervolgens gesteriliseerd om de versheid en textuur te behouden, zonder toevoeging van bewaarmiddelen of MSG. Glatt Kosher: Alle maaltijden zijn Glatt Kosher en staan onder strikt rabbijns toezicht van de Orthodoxe Unie (OU) en rabbijn Getzel Berkowitz van Kiryas Joel. Houdbaar en gemakkelijk te bereiden: De houdbare maaltijden van KJ Poultry zijn al volledig bereid, dus u kunt ze snel en gemakkelijk bereiden en serveren. Gewoon uitpakken en in de magnetronschaal in de magnetron plaatsen gedurende ongeveer 2 minuten. Ideale gelegenheden: Of u nu de natuur verkent, in het leger dient, zich voorbereidt op een noodgeval of gewoon geen tijd heeft om een maaltijd te bereiden, de volledig bereide, houdbare maaltijden van KJ Poultry bieden de smakelijke voeding om u de dag door te helpen.</p>', 752),
('App\\Model\\Product', 171, 'de', 'name', 'Koschere Mre-Fleischgerichte, verzehrfertig, verschiedene gefüllte Hähnchenbrust, Puten-Shwarma, Hühnchen mit Knochen (3er-Packung) – fertig zubereitetes Hauptgericht, vollständig gegart, haltbares Mikrowellen-Abendessen', 753),
('App\\Model\\Product', 171, 'de', 'description', '<p>Koschere Mre-Fleischgerichte, verzehrfertig, verschiedene gef&uuml;llte H&auml;hnchenbrust, Puten-Shwarma, H&uuml;hnchen mit Knochen (3er-Packung) &ndash; fertig zubereitetes Hauptgericht, vollst&auml;ndig gegart, haltbares Mikrowellen-Abendessen<br />\r\nGeschmack und Ern&auml;hrung: Wenn Sie nicht zu Hause sind oder keine Zeit zum Kochen haben, sind unsere lagerstabilen Glatt-Koscher-Fleischmahlzeiten die perfekte L&ouml;sung f&uuml;r gro&szlig;artigen Geschmack und hervorragende Ern&auml;hrung. Qualit&auml;t und Sorgfalt: Wir bereiten jede k&ouml;stliche, haltbare koschere Mahlzeit nur mit h&ouml;chster Qualit&auml;t, Zutaten und Sorgfalt zu. Anschlie&szlig;end sterilisiert, um Frische und Textur zu bewahren, ohne Zusatz von Konservierungsmitteln oder MSG. Glatt koscher: Alle Mahlzeiten sind glatt koscher und stehen unter der strengen rabbinischen Aufsicht der Orthodoxen Union (OU) und Rabbi Getzel Berkowitz von Kiryas Joel. Lagerstabil und einfach zuzubereiten: Die lagerstabilen Mahlzeiten von KJ Poultry sind bereits vollst&auml;ndig gekocht, sodass Sie sie schnell und einfach zubereiten und servieren k&ouml;nnen. Einfach auspacken und in der mikrowellengeeigneten Schale etwa 2 Minuten lang in die Mikrowelle stellen. Ideale Anl&auml;sse: Ganz gleich, ob Sie die Natur erkunden, bei den Streitkr&auml;ften dienen, sich auf einen Notfall vorbereiten oder einfach keine Zeit haben, eine Mahlzeit zuzubereiten, die fertig gekochten, haltbaren Mahlzeiten von KJ Poultry sorgen f&uuml;r die leckere Ern&auml;hrung um Sie durch den Tag zu bringen.</p>\r\n\r\n<p>&nbsp;</p>', 754),
('App\\Model\\Product', 166, 'nl', 'name', 'Pacific Foods Organic Coconut Unsweetened Plant-Based Beverage, 32oz', 755),
('App\\Model\\Product', 166, 'nl', 'description', '<p>Pacific Foods Organic Coconut Unsweetened Plant-Based Beverage, 32oz</p>', 756),
('App\\Model\\Product', 166, 'de', 'name', 'Pacific Foods Organic Coconut Unsweetened Plant-Based Beverage, 32oz', 757),
('App\\Model\\Product', 166, 'de', 'description', '<p>Pacific Foods Organic Coconut Unsweetened Plant-Based Beverage, 32oz</p>', 758),
('App\\Model\\Category', 233, 'nl', 'name', 'Tandarts ingesteld', 759),
('App\\Model\\Category', 233, 'de', 'name', 'Zahnarzt-Set', 760),
('App\\Model\\Category', 234, 'nl', 'name', 'Make-upborstels en -hulpmiddelen', 761),
('App\\Model\\Category', 234, 'de', 'name', 'Make-up-Pinsel und -Werkzeuge', 762),
('App\\Model\\Category', 235, 'nl', 'name', 'gezicht en ogen', 763),
('App\\Model\\Category', 235, 'de', 'name', 'Gesicht und Augen', 764),
('App\\Model\\Category', 236, 'nl', 'name', 'Lippen', 765),
('App\\Model\\Category', 236, 'de', 'name', 'Lippen', 766),
('App\\Model\\Category', 237, 'nl', 'name', 'Vrijetijdsschoenen', 767),
('App\\Model\\Category', 237, 'de', 'name', 'Lässige Schuhe', 768),
('App\\Model\\Category', 238, 'nl', 'name', 'Sandalen', 769),
('App\\Model\\Category', 238, 'de', 'name', 'Sandalen', 770),
('App\\Model\\Category', 239, 'nl', 'name', 'Rugzakken en dragers', 771),
('App\\Model\\Category', 239, 'de', 'name', 'Rucksäcke und Tragetaschen', 772),
('App\\Model\\Category', 240, 'nl', 'name', 'Speelmatten', 773),
('App\\Model\\Category', 240, 'de', 'name', 'Spielmatten', 774),
('App\\Model\\Product', 173, 'nl', 'name', 'Babyschoen Jongens/Meisjes Peuterschoen 2023Zomer Nieuwe Jongen Ademend Mesh Sportschoen Meisjesschoen Zachte zool Vrijetijdsschoen Kinderschoen Tênis', 775),
('App\\Model\\Product', 173, 'nl', 'description', '<p>Babyschoen Jongens/Meisjes Peuterschoen 2023Zomer Nieuwe Jongen Ademend Mesh Sportschoen Meisjesschoen Zachte zool Vrijetijdsschoen Kinderschoen T&ecirc;nis</p>', 776),
('App\\Model\\Product', 173, 'de', 'name', 'Baby Schuh Jungen/Mädchen Kleinkind Schuh 2023 Sommer Neue Junge Atmungsaktive Mesh Sport Schuh Mädchen schuh Weiche Sohle Casual schuh Kinder Schuh Tênis', 777),
('App\\Model\\Product', 173, 'de', 'description', '<p>Baby Schuh Jungen/M&auml;dchen Kleinkind Schuh 2023 Sommer Neue Junge Atmungsaktive Mesh Sport Schuh M&auml;dchen schuh Weiche Sohle Casual schuh Kinder Schuh T&ecirc;nis</p>', 778),
('App\\Model\\Product', 174, 'nl', 'name', 'Montessori Baby Drukke Board 3D Peuters Verhaal Doek Boek Zintuiglijk speelgoed voor baby\'s Onderwijsgewoonten Speelgoed boeken voor kinderen van 0-3', 779),
('App\\Model\\Product', 174, 'nl', 'description', '<p>Montessori Baby Drukke Board 3D Peuters Verhaal Doek Boek Zintuiglijk speelgoed voor baby&#39;s Onderwijsgewoonten Speelgoed boeken voor kinderen van 0-3</p>', 780),
('App\\Model\\Product', 174, 'de', 'name', 'Montessori Baby Busy Board 3D-Stoffbuch für Kleinkinder, sensorisches Spielzeug für Babys, Bildung, Gewohnheiten, Spielzeug, Bücher für Kinder von 0–3 Jahren', 781),
('App\\Model\\Product', 174, 'de', 'description', '<p>Montessori Baby Busy Board 3D-Stoffbuch f&uuml;r Kleinkinder, sensorisches Spielzeug f&uuml;r Babys, Bildung, Gewohnheiten, Spielzeug, B&uuml;cher f&uuml;r Kinder von 0&ndash;3 Jahren</p>', 782),
('App\\Model\\Category', 241, 'nl', 'name', 'Dames zonnebril', 783),
('App\\Model\\Category', 241, 'de', 'name', 'Sonnenbrillen für Damen', 784),
('App\\Model\\Category', 242, 'nl', 'name', 'Heren zonnebril', 785),
('App\\Model\\Category', 242, 'de', 'name', 'Herren-Sonnenbrille', 786),
('App\\Model\\Category', 243, 'nl', 'name', 'Kinderbril', 787),
('App\\Model\\Category', 243, 'de', 'name', 'Kinderbrillen', 788),
('App\\Model\\Product', 175, 'nl', 'name', 'Vierkante zonnebril vrouw merkontwerper mode randloze gradiënt zonnebril tinten snijden lens dames frameloze brillen', 789),
('App\\Model\\Product', 175, 'nl', 'description', '<p>Vierkante zonnebril vrouw merkontwerper mode randloze gradi&euml;nt zonnebril tinten snijden lens dames frameloze brillen</p>\r\n\r\n<div id=\"gtx-trans\" style=\"position: absolute; left: 190px; top: 38.6px;\">\r\n<div class=\"gtx-trans-icon\">&nbsp;</div>\r\n</div>', 790),
('App\\Model\\Product', 175, 'de', 'name', 'Quadratische Sonnenbrille Frau Marke Designer Mode randlose Farbverlauf Sonnenbrille Shades Schneiden Objektiv Damen rahmenlose Brillen', 791),
('App\\Model\\Product', 175, 'de', 'description', '<p>Quadratische Sonnenbrille Frau Marke Designer Mode randlose Farbverlauf Sonnenbrille Shades Schneiden Objektiv Damen rahmenlose Brillen</p>', 792),
('App\\Model\\Product', 176, 'nl', 'name', 'Voor KTM 200 250 300 200EXC 250XC 250XCW 300XC 300XCW 410 W Elektrische Motor Onderdelen Startmotor 2008-2012 Starter motorfiets 12 V', 793),
('App\\Model\\Product', 176, 'nl', 'description', '<p>Voor KTM 200 250 300 200EXC 250XC 250XCW 300XC 300XCW 410 W Elektrische Motor Onderdelen Startmotor 2008-2012 Starter motorfiets 12 V<br />\r\nWerkende staat: Dit item is een gloednieuw, ongebruikt, ongeopend, onbeschadigd item in de originele verpakking (waar verpakking van toepassing is). zie de aanbieding van de verkoper voor volledige details.<br />\r\nAanbevolen verkoper: Het wordt aanbevolen om producten van hoge kwaliteit te leveren wanneer ze door de fabrikant zijn gekocht, en deze worden v&oacute;&oacute;r verzending strikt getest. Zolang u niet tevreden bent, kunt u er zeker van zijn dat u koopt.<br />\r\nConstructie van topkwaliteit: onze motoronderdelen zijn gemaakt van hoogwaardige materialen, die duurzaam en langdurig zijn.<br />\r\n&nbsp;</p>\r\n\r\n<p>Spline met 9 tanden<br />\r\n5 cm lichaamsbuitendiameter<br />\r\nTotale lengte 12,3 cm</p>\r\n\r\n<p>Controleer de afbeeldingen voordat u bestelt</p>', 794),
('App\\Model\\Product', 176, 'de', 'name', 'Für KTM 200 250 300 200EXC 250XC 250XCW 300XC 300XCW 410W Elektrische Motor Teile Starter Motor 2008-2012 Starter Motorrad 12V', 795),
('App\\Model\\Product', 176, 'de', 'description', '<p>F&uuml;r KTM 200 250 300 200EXC 250XC 250XCW 300XC 300XCW 410W Elektrische Motor Teile Starter Motor 2008-2012 Starter Motorrad 12V<br />\r\nFunktionierender Zustand: Bei diesem Artikel handelt es sich um einen brandneuen, unbenutzten, unge&ouml;ffneten und unbesch&auml;digten Artikel in der Originalverpackung (soweit eine Verpackung vorhanden ist). Ausf&uuml;hrliche Informationen finden Sie im Angebot des Verk&auml;ufers.<br />\r\nEmpfohlener Verk&auml;ufer: Es wird empfohlen, beim Kauf durch den Hersteller qualitativ hochwertige Produkte bereitzustellen, die vor dem Versand streng getestet werden. Solange Sie nicht zufrieden sind, k&ouml;nnen Sie beruhigt sein und kaufen.<br />\r\nHochwertige Konstruktion: Unsere Motorteile bestehen aus hochwertigen Materialien, die langlebig und langlebig sind.<br />\r\n&nbsp;</p>\r\n\r\n<p>9 Z&auml;hne Spline<br />\r\n5 cm K&ouml;rper-Au&szlig;endurchmesser<br />\r\n12,3 cm Gesamtl&auml;nge</p>\r\n\r\n<p>Bitte &uuml;berpr&uuml;fen Sie die Bilder vor der Bestellung</p>', 796),
('App\\Model\\Product', 177, 'nl', 'name', 'Nieuwe heren lederen jas mannelijke koeienhuid overjas herfst winter zakelijke jas geul stijl dubbele rij knopen kleding kalfsleer', 797),
('App\\Model\\Product', 177, 'nl', 'description', '<p>Nieuwe heren lederen jas mannelijke koeienhuid overjas herfst winter zakelijke jas geul stijl dubbele rij knopen kleding kalfsleer</p>', 798),
('App\\Model\\Product', 177, 'de', 'name', 'Neue männer Echte Leder Jacke Männlichen Rindsleder Mantel Herbst Winter Business Mantel Graben Stil Zweireiher Kleidung Kalbsleder', 799),
('App\\Model\\Product', 177, 'de', 'description', '<p>Neue m&auml;nner Echte Leder Jacke M&auml;nnlichen Rindsleder Mantel Herbst Winter Business Mantel Graben Stil Zweireiher Kleidung Kalbsleder</p>', 800),
('App\\Model\\Product', 178, 'nl', 'name', 'Verkopen als hot Mini Portable Drive 3.0 Flash Drive 2TB USB PEN DRIVE 1TB Externe Flash-geheugen voor Laptop Desktop Mechanische', 801),
('App\\Model\\Product', 178, 'nl', 'description', '<p>Verkopen als hot Mini Portable Drive 3.0 Flash Drive 2TB USB PEN DRIVE 1TB Externe Flash-geheugen voor Laptop Desktop Mechanische</p>', 802),
('App\\Model\\Product', 178, 'de', 'name', 'Verkaufe wie heiß Mini Portable Drive 3.0 Flash-Laufwerk 2 TB USB-Stick 1 TB externer Flash-Speicher für Laptop-Desktop mechanisch', 803),
('App\\Model\\Product', 178, 'de', 'description', '<p>Verkaufe wie hei&szlig; Mini Portable Drive 3.0 Flash-Laufwerk 2 TB USB-Stick 1 TB externer Flash-Speicher f&uuml;r Laptop-Desktop mechanisch</p>', 804),
('App\\Model\\Product', 179, 'nl', 'name', '2022 Nieuwe Mode Vrouwelijke Schoudertas Ruit Geborduurde Effen Kleur Ketting Vrouwen Schouder Crossbody Casual Trendy Telefoon Tas', 805),
('App\\Model\\Product', 179, 'nl', 'description', '<p>2022 Nieuwe Mode Vrouwelijke Schoudertas Ruit Geborduurde Effen Kleur Ketting Vrouwen Schouder Crossbody Casual Trendy Telefoon Tas<br />\r\n&nbsp;</p>\r\n\r\n<p>PRODUCTINFORMATIE</p>\r\n\r\n<p>Artikelnaam: schoudertas voor dames</p>\r\n\r\n<p>Maat: 20*6*12cm</p>\r\n\r\n<p>Kleur: wit, rood, zwart, bruin, roze</p>\r\n\r\n<p>Materiaal: PU-leer</p>\r\n\r\n<p>Functie:</p>\r\n\r\n<p>Deze tas maakt je modieuzer, sexy, eleganter en zelfverzekerder.</p>\r\n\r\n<p>Perfect voor bruiloften, feesten, prom-, bal- en avondevenementen.</p>\r\n\r\n<p>Beste cadeaus voor geliefden en vrienden</p>\r\n\r\n<p>Geschikt voor alle kledingstijlen.<br />\r\nTips:</p>\r\n\r\n<p>1. Chromatische aberratie</p>\r\n\r\n<p>Als gevolg van de opnamecamera en de verlichting kunnen sommige modelfoto&#39;s chromatische aberratie vertonen, de horizontaal geplaatste foto&#39;s zijn dichter bij het werkelijke weergave-effect getint.</p>', 806),
('App\\Model\\Product', 179, 'de', 'name', '2022 neue Mode Weibliche Schulter Tasche Raute Bestickte Feste Farbe Kette Frauen Schulter Umhängetasche Casual Trendy Telefon Tasche', 807),
('App\\Model\\Product', 179, 'de', 'description', '<p>2022 neue Mode Weibliche Schulter Tasche Raute Bestickte Feste Farbe Kette Frauen Schulter Umh&auml;ngetasche Casual Trendy Telefon Tasche<br />\r\n&nbsp;</p>\r\n\r\n<p>PRODUKTINFORMATION</p>\r\n\r\n<p>Artikelbezeichnung: Damen-Umh&auml;ngetasche</p>\r\n\r\n<p>Gr&ouml;&szlig;e: 20 x 6 x 12 cm</p>\r\n\r\n<p>Farbe: wei&szlig;, rot, schwarz, braun, rosa</p>\r\n\r\n<p>Material: PU-Leder</p>\r\n\r\n<p>Besonderheit:</p>\r\n\r\n<p>Diese Tasche macht Sie modischer, sexy, eleganter und selbstbewusster.</p>\r\n\r\n<p>Perfekt f&uuml;r Hochzeiten, Partys, Abschlussb&auml;lle, B&auml;lle und Abendveranstaltungen.</p>\r\n\r\n<p>Beste Geschenke f&uuml;r Liebhaber und Freunde</p>\r\n\r\n<p>Passend f&uuml;r alle Kleidungsstile.<br />\r\nTipps:</p>\r\n\r\n<p>1. Chromatische Aberration</p>\r\n\r\n<p>Aufgrund der Aufnahmekamera und der Beleuchtung k&ouml;nnen einige Modellbilder chromatische Aberrationen aufweisen, die horizontal platzierten Bilder entsprechen eher dem tats&auml;chlichen Anzeigeeffekt.</p>', 808),
('App\\Model\\Product', 180, 'nl', 'name', 'Tandheelkundige spatel Gipsmes Praktisch roestvrij staal Veelzijdige tanden Wax Carving Tool Set Tandheelkundig instrument Tandartsgereedschap', 809),
('App\\Model\\Product', 180, 'nl', 'description', '<p>Tandheelkundige spatel Gipsmes Praktisch roestvrij staal Veelzijdige tanden Wax Carving Tool Set Tandheelkundig instrument Tandartsgereedschap.<br />\r\n100% nieuw en hoge kwaliteit.<br />\r\nDental Lab roestvrijstalen kit Wax Carving Tool Set Instrument<br />\r\nMateriaal: hoogwaardig roestvrij staal<br />\r\nHoeveelheid: 10 stuks van verschillende stijlen<br />\r\nKleur: Zilver Afmeting doos: open 20x18,5cm, in elkaar gezet 20X8,5X2,5cm<br />\r\nFunctie:<br />\r\n1. Gemaakt van hoogwaardig roestvrij staal, hygi&euml;nisch, scherp en duurzaam;<br />\r\n2. Essenti&euml;le mondverzorgingshulpmiddelen voor de dagelijkse reiniging en onderzoek van de tanden;<br />\r\n3. inclusief messen, scalers, sondes, tandenstokers, tandsteen, tandplakschrapen, enz.;<br />\r\n4. antisliphandvat, veiliger, handiger in gebruik.<br />\r\n5. met PU-tas, gemakkelijk mee te nemen en op te bergen.<br />\r\n6. zacht en comfortabel, grondig schoon, gemakkelijk te gebruiken en comfortabel om vast te houden.</p>', 810),
('App\\Model\\Product', 180, 'de', 'name', 'Dental Spachtel Gips Messer Praktische Edelstahl Vielseitig Zähne Wachs Carving Werkzeug Set Dental Instrument Zahnarzt Werkzeuge', 811),
('App\\Model\\Product', 180, 'de', 'description', '<p>Dental Spachtel Gips Messer Praktische Edelstahl Vielseitig Z&auml;hne Wachs Carving Werkzeug Set Dental Instrument Zahnarzt Werkzeuge,<br />\r\n100 % brandneu und hochwertig.<br />\r\nDentallabor-Edelstahl-Set, Wachsschnitzwerkzeug-Set, Instrument<br />\r\nMaterial: Hochwertiger Edelstahl<br />\r\nMenge: 10 St&uuml;ck in verschiedenen Stilen<br />\r\nFarbe: Silber. Kartongr&ouml;&szlig;e: offen 20 x 18,5 cm, zusammengebaut 20 x 8,5 x 2,5 cm<br />\r\nBesonderheit:<br />\r\n1. Hergestellt aus hochwertigem Edelstahl, hygienisch, scharf und langlebig;<br />\r\n2. Unentbehrliche Mundpflegewerkzeuge f&uuml;r die t&auml;gliche Reinigung und Untersuchung der Z&auml;hne;<br />\r\n3. einschlie&szlig;lich Messer, Scaler, Sonden, Zahnstocher, Zahnstein, Plaque-Schaben usw.;<br />\r\n4. Rutschfester Griff, sicherer, bequemer zu bedienen.<br />\r\n5. Mit PU-Beutel, einfach zu tragen und aufzubewahren.<br />\r\n6. weich und bequem, gr&uuml;ndlich sauber, einfach zu bedienen und angenehm zu halten.</p>', 812),
('App\\Model\\Product', 181, 'nl', 'name', 'Sirma Doğal Maden Suyu 12x1 L', 813),
('App\\Model\\Product', 181, 'nl', 'description', '<p>Sirma Doğal Maden Suyu 12x1 L</p>', 814),
('App\\Model\\Product', 181, 'de', 'name', 'Sirma Doğal Maden Suyu 12x1 L', 815),
('App\\Model\\Product', 181, 'de', 'description', '<p>Sirma Doğal Maden Suyu 12x1 L</p>', 816),
('App\\Model\\DealOfTheDay', 1, 'nl', 'title', 'Black Friday', 817),
('App\\Model\\DealOfTheDay', 1, 'de', 'title', 'Black Friday', 818),
('App\\Model\\DealOfTheDay', 2, 'nl', 'title', 'Bespoke V-neck', 819),
('App\\Model\\DealOfTheDay', 2, 'de', 'title', 'Bespoke V-neck', 820),
('App\\Model\\FlashDeal', 2, 'nl', 'title', 'Functiedeal van de euromarkt', 821),
('App\\Model\\FlashDeal', 2, 'de', 'title', 'Feature-Deal vom Euro-Markt', 822),
('App\\Model\\Category', 6, 'nl', 'name', 'Kinderkleding', 823),
('App\\Model\\Category', 6, 'de', 'name', 'Kinderkleidung', 824),
('App\\Model\\Category', 244, 'nl', 'name', 'Machines en Apparatuur', 825),
('App\\Model\\Category', 244, 'de', 'name', 'Maschinen und Ausrüstungen', 826),
('App\\Model\\Category', 245, 'nl', 'name', 'Parfums en Geschenken', 827),
('App\\Model\\Category', 245, 'de', 'name', 'Parfums und Geschenke', 828),
('App\\Model\\Category', 246, 'nl', 'name', 'Agrarisch', 829),
('App\\Model\\Category', 246, 'de', 'name', 'Landwirtschaftlich', 830),
('App\\Model\\Category', 247, 'nl', 'name', 'Kleding', 831),
('App\\Model\\Category', 247, 'de', 'name', 'Bekleidung', 832),
('App\\Model\\Category', 248, 'nl', 'name', 'Schoonheid en persoonlijke verzorging', 833),
('App\\Model\\Category', 248, 'de', 'name', 'Schönheit und Körperpflege', 834),
('App\\Model\\Category', 249, 'nl', 'name', 'Chemicaliën', 835),
('App\\Model\\Category', 249, 'de', 'name', 'Chemikalien', 836),
('App\\Model\\Category', 250, 'nl', 'name', 'Bouw', 837),
('App\\Model\\Category', 250, 'de', 'name', 'Konstruktion', 838),
('App\\Model\\Category', 251, 'nl', 'name', 'Consumentenelektronica', 839),
('App\\Model\\Category', 251, 'de', 'name', 'Unterhaltungselektronik', 840),
('App\\Model\\Category', 252, 'nl', 'name', 'Elektrische apparatuur en benodigdheden', 841),
('App\\Model\\Category', 252, 'de', 'name', 'Elektrische Ausrüstung und Zubehör', 842),
('App\\Model\\Category', 253, 'nl', 'name', 'Energie', 843),
('App\\Model\\Category', 253, 'de', 'name', 'Energie', 844),
('App\\Model\\Category', 254, 'nl', 'name', 'Fabricagediensten', 845),
('App\\Model\\Category', 254, 'de', 'name', 'Fertigungsdienstleistungen', 846),
('App\\Model\\Category', 255, 'nl', 'name', 'Mode accessoires', 847),
('App\\Model\\Category', 255, 'de', 'name', 'Mode-Accessoires', 848),
('App\\Model\\Category', 256, 'nl', 'name', 'Gezondheid en medisch', 849),
('App\\Model\\Category', 256, 'de', 'name', 'Gesundheit und Medizin', 850),
('App\\Model\\Category', 257, 'nl', 'name', 'Huishoudartikelen', 851),
('App\\Model\\Category', 257, 'de', 'name', 'Haushaltswaren', 852),
('App\\Model\\Category', 258, 'nl', 'name', 'Textiel- en lederproducten', 853),
('App\\Model\\Category', 258, 'de', 'name', 'Textil- & Lederprodukte', 854),
('App\\Model\\Category', 259, 'nl', 'name', 'Tassen', 855),
('App\\Model\\Category', 259, 'de', 'name', 'Taschen', 856),
('App\\Model\\Category', 260, 'nl', 'name', 'Huis & Tuin', 857),
('App\\Model\\Category', 260, 'de', 'name', 'Haus & Garten', 858),
('App\\Model\\Category', 261, 'nl', 'name', 'Verlichting', 859),
('App\\Model\\Category', 261, 'de', 'name', 'Beleuchtung', 860),
('App\\Model\\Category', 262, 'nl', 'name', 'Mineralen & Metallurgie', 861),
('App\\Model\\Category', 262, 'de', 'name', 'Mineralien & Metallurgie', 862),
('App\\Model\\Category', 263, 'nl', 'name', 'Kantoor- en schoolbenodigdheden', 863),
('App\\Model\\Category', 263, 'de', 'name', 'Bürobedarf & Schulbedarf', 864),
('App\\Model\\Category', 264, 'nl', 'name', 'Verpakking & Druk', 865),
('App\\Model\\Category', 264, 'de', 'name', 'Verpackung & Druck', 866),
('App\\Model\\Category', 265, 'nl', 'name', 'Producten voor reductie & recycling', 867),
('App\\Model\\Category', 265, 'de', 'name', 'Produkte zur Reduzierung & Recycling', 868),
('App\\Model\\Category', 266, 'nl', 'name', 'Rubber & Kunststoffen', 869),
('App\\Model\\Category', 266, 'de', 'name', 'Gummi & Kunststoffe', 870),
('App\\Model\\Category', 267, 'nl', 'name', 'Beveiliging & Bescherming', 871),
('App\\Model\\Category', 267, 'de', 'name', 'Sicherheit & Schutz', 872),
('App\\Model\\Category', 268, 'nl', 'name', 'Dienstuitrusting', 873),
('App\\Model\\Category', 268, 'de', 'name', 'Dienstleistungsausstattung', 874),
('App\\Model\\Category', 269, 'nl', 'name', 'Sport & Entertainment', 875),
('App\\Model\\Category', 269, 'de', 'name', 'Sport & Unterhaltung', 876),
('App\\Model\\Category', 270, 'nl', 'name', 'Gereedschap & Hardware', 877),
('App\\Model\\Category', 270, 'de', 'name', 'Werkzeuge & Hardware', 878),
('App\\Model\\Category', 271, 'nl', 'name', 'Industriële accessoires', 879),
('App\\Model\\Category', 271, 'de', 'name', 'Industriezubehör', 880),
('App\\Model\\Category', 272, 'nl', 'name', 'Huishoudelijke apparaten', 881),
('App\\Model\\Category', 272, 'de', 'name', 'Haushaltsgeräte', 882),
('App\\Model\\Product', 183, 'nl', 'name', 'dfdsfsdf', 887),
('App\\Model\\Product', 183, 'nl', 'description', '<p>sdfdsf</p>', 888),
('App\\Model\\Product', 183, 'de', 'name', 'dfsfdsf', 889),
('App\\Model\\Product', 183, 'de', 'description', '<p>dssdfds</p>', 890),
('App\\Model\\Category', 273, 'nl', 'name', 'Heren schoenen', 891),
('App\\Model\\Category', 273, 'de', 'name', 'Herrenschuhe', 892),
('App\\Model\\Category', 274, 'nl', 'name', 'Damesschoenen', 893),
('App\\Model\\Category', 274, 'de', 'name', 'Frauenschuhe', 894),
('App\\Model\\Category', 275, 'nl', 'name', 'Casual Schoenen', 895),
('App\\Model\\Category', 275, 'de', 'name', 'Freizeitschuhe', 896),
('App\\Model\\Category', 276, 'nl', 'name', 'Formele Schoenen', 897),
('App\\Model\\Category', 276, 'de', 'name', 'Formale Schuhe', 898),
('App\\Model\\Category', 277, 'nl', 'name', 'Sportschoenen', 899),
('App\\Model\\Category', 277, 'de', 'name', 'Sportschuhe', 900),
('App\\Model\\Category', 278, 'nl', 'name', 'Hakken', 901),
('App\\Model\\Category', 278, 'de', 'name', 'Absätze', 902),
('App\\Model\\Category', 279, 'nl', 'name', 'Platte Schoenen', 903),
('App\\Model\\Category', 279, 'de', 'name', 'Flache Schuhe', 904),
('App\\Model\\Category', 280, 'nl', 'name', 'Laarzen', 905),
('App\\Model\\Category', 280, 'de', 'name', 'Stiefel', 906),
('App\\Model\\Category', 281, 'nl', 'name', 'Sneakers', 907),
('App\\Model\\Category', 281, 'de', 'name', 'Turnschuhe', 908),
('App\\Model\\Category', 282, 'nl', 'name', 'Sandalen', 909),
('App\\Model\\Category', 282, 'de', 'name', 'Sandalen', 910),
('App\\Model\\Category', 283, 'nl', 'name', 'Kinderschoenen', 911),
('App\\Model\\Category', 283, 'de', 'name', 'Kinderschuhe', 912),
('App\\Model\\Category', 284, 'nl', 'name', 'Sportschoenen', 913),
('App\\Model\\Category', 284, 'de', 'name', 'Sportschuhe', 914),
('App\\Model\\Category', 285, 'nl', 'name', 'Formele Schoenen', 915),
('App\\Model\\Category', 285, 'de', 'name', 'Festliche Schuhe', 916),
('App\\Model\\Category', 286, 'nl', 'name', 'Kinderlaarzen', 917),
('App\\Model\\Category', 286, 'de', 'name', 'Kinderstiefel', 918);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) DEFAULT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(255) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `image` varchar(30) NOT NULL DEFAULT 'def.png',
  `email` varchar(80) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(80) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `street_address` varchar(250) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `house_no` varchar(50) DEFAULT NULL,
  `apartment_no` varchar(50) DEFAULT NULL,
  `cm_firebase_token` varchar(191) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `payment_card_last_four` varchar(191) DEFAULT NULL,
  `payment_card_brand` varchar(191) DEFAULT NULL,
  `payment_card_fawry_token` text DEFAULT NULL,
  `login_medium` varchar(191) DEFAULT NULL,
  `social_id` varchar(191) DEFAULT NULL,
  `is_phone_verified` tinyint(1) NOT NULL DEFAULT 0,
  `temporary_token` varchar(191) DEFAULT NULL,
  `is_email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `wallet_balance` double(8,2) DEFAULT NULL,
  `loyalty_point` double(8,2) DEFAULT NULL,
  `login_hit_count` tinyint(4) NOT NULL DEFAULT 0,
  `is_temp_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `temp_block_time` timestamp NULL DEFAULT NULL,
  `referral_code` varchar(255) DEFAULT NULL,
  `referred_by` int(11) DEFAULT NULL,
  `shipping_to` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `f_name`, `l_name`, `phone`, `image`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `street_address`, `country`, `city`, `zip`, `house_no`, `apartment_no`, `cm_firebase_token`, `is_active`, `payment_card_last_four`, `payment_card_brand`, `payment_card_fawry_token`, `login_medium`, `social_id`, `is_phone_verified`, `temporary_token`, `is_email_verified`, `wallet_balance`, `loyalty_point`, `login_hit_count`, `is_temp_blocked`, `temp_block_time`, `referral_code`, `referred_by`, `shipping_to`) VALUES
(0, 'walking customer', 'walking', 'customer', '000000000000', 'def.png', 'walking@customer.com', NULL, '', NULL, NULL, '2022-02-03 03:46:01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(2, NULL, 'abdulkader tarrab', 'refaee', '', 'def.png', 'abdulkadertarrabrefaee@gmail.com', NULL, '$2y$10$Ls4PyK/Yrk6n5Bet6pWsnupMz7Er9w5BWjYWHIuaB6mLvXaiwfqim', 'hFQiJKBtQStwOt5Z6E30tMTzMJViI1b9DQV8tIz6IqgAgWiEu3NHIMVZKtan', '2023-11-14 17:13:45', '2023-11-25 23:09:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'google', '113583419312692864305', 0, 'LfhXwDFbX2Th7ncyl1ywkMDGRTinHDEk0yL6TMIl', 0, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(3, NULL, 'abdulkader', 'tarrab', '', 'def.png', 'abdulkader.tarrab.1992@gmail.com', NULL, '$2y$10$HwmzEeWKUUUvOprBREXO8eZ0aS0rxujP4CYizh6a5IKefWhyyIOB2', 'UHuwd3iTvUk1q0yl620OaAKKVppTKpcWJ1mWX6G66UsMeLZudV3UVtLz3Y6R', '2023-11-22 16:52:18', '2023-11-22 16:52:18', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'google', '106761058827907315038', 0, 'eYSmzxRocqOBIZqD2UX9z8YIp6RIFQACCnpieC5h', 0, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL),
(4, NULL, 'tvsoso', 'aaaa', '05537608834', 'def.png', 'tvsoso1994@gmail.com', NULL, '$2y$10$xrVSARn9vmTTcZ2vT9DuP.qTzHiK.W3L6zFn23sXdOBAlxlLcXM4m', 'UHgneMhkRbESkmWQjaUwvA9xCV6KsfQSFXkI75loSS2LJZdhciysjvmM4AO6', '2023-12-29 00:11:39', '2023-12-29 00:12:35', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, NULL, 0, 0, NULL, 'NI2L8LA6JHIYY6DAD1QO', NULL, 'AF'),
(5, NULL, 'abd', 'tarab', '054154646', 'def.png', 'aadll4app@gmail.com', NULL, '$2y$10$.1UxRLbKHs8sprkEfXyseOpjZfhSxzWXxIZxozmzCoRzevv3PymSK', NULL, '2023-12-29 00:55:00', '2024-01-22 14:25:24', NULL, NULL, NULL, NULL, NULL, NULL, 'ek4dcil8Q_SMggaHi5QAVi:APA91bGpi2zx1ycMubepmY6xB4x3Wn6kpXLLhyNOFvr-4Hx1y3xf7-DDoPivFVt3ynNCnpmsBqxih8VH00CIRDJ2Gj6tzPPtaHg9kJ135xNo7fcUxvI484BwGYk5xUEymvJbkGn7gXXM', 1, NULL, NULL, NULL, NULL, NULL, 0, 'FaFhmEURfhev7x3OyZpmiaRWDhVa3jT65nJb3lFs', 1, NULL, NULL, 0, 0, NULL, 'DWDSD3LHLYTRCZTG8OUH', NULL, NULL),
(6, NULL, 'euro', 'marketn', '', 'def.png', 'euromarketn0@gmail.com', NULL, '$2y$10$6Q9//Z.HcMP6TNoh0Ig7ueXDyRo4twsKvjaZoBK9u.U2ARabM36FK', '6yMDQuZdeZC224jQeBhX3aLGeuuoK45A2VJwZPxXxXSeZL7iZzThtefht2kY', '2023-12-31 02:29:02', '2024-01-11 03:47:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'google', '107519659080078653812', 0, 'Yn3qcu7iFwkolnAYIW59MaqBYINCo6xPHBw792fd', 0, NULL, NULL, 0, 0, NULL, NULL, NULL, 'AF');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` char(36) NOT NULL,
  `credit` decimal(24,3) NOT NULL DEFAULT 0.000,
  `debit` decimal(24,3) NOT NULL DEFAULT 0.000,
  `admin_bonus` decimal(24,3) NOT NULL DEFAULT 0.000,
  `balance` decimal(24,3) NOT NULL DEFAULT 0.000,
  `transaction_type` varchar(191) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `reference` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal_methods`
--

CREATE TABLE `withdrawal_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `method_name` varchar(191) NOT NULL,
  `method_fields` text NOT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdrawal_methods`
--

INSERT INTO `withdrawal_methods` (`id`, `method_name`, `method_fields`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Bank transfer', '[{\"input_type\":\"string\",\"input_name\":\"fullname\",\"placeholder\":\"Enter your name\",\"is_required\":1},{\"input_type\":\"string\",\"input_name\":\"iban\",\"placeholder\":\"ENTER BANKS IBAN\",\"is_required\":1},{\"input_type\":\"string\",\"input_name\":\"bank_name\",\"placeholder\":\"ENTER BANK NAME\",\"is_required\":1},{\"input_type\":\"string\",\"input_name\":\"country\",\"placeholder\":\"ENTER YOUR COUNTRY\",\"is_required\":1}]', 1, 1, '2023-11-26 00:56:08', '2023-11-26 00:56:08');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_requests`
--

CREATE TABLE `withdraw_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) DEFAULT NULL,
  `delivery_man_id` bigint(20) DEFAULT NULL,
  `admin_id` bigint(20) DEFAULT NULL,
  `amount` varchar(191) NOT NULL DEFAULT '0.00',
  `withdrawal_method_id` bigint(20) UNSIGNED DEFAULT NULL,
  `withdrawal_method_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `transaction_note` text DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdraw_requests`
--

INSERT INTO `withdraw_requests` (`id`, `seller_id`, `delivery_man_id`, `admin_id`, `amount`, `withdrawal_method_id`, `withdrawal_method_fields`, `transaction_note`, `approved`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '1.96', 1, '{\"method_name\":\"Bank transfer\",\"fullname\":\"ABDULKADR TARRAB\",\"iban\":\"2321312312312\",\"bank_name\":\"ASDA\",\"country\":\"STRR\"}', 'OK', 1, '2023-11-26 00:56:57', '2023-11-26 00:57:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addon_settings`
--
ALTER TABLE `addon_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_settings_id_index` (`id`);

--
-- Indexes for table `add_fund_bonus_categories`
--
ALTER TABLE `add_fund_bonus_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_wallets`
--
ALTER TABLE `admin_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_wallet_histories`
--
ALTER TABLE `admin_wallet_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_addresses`
--
ALTER TABLE `billing_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_settings`
--
ALTER TABLE `business_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_shippings`
--
ALTER TABLE `cart_shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_shipping_costs`
--
ALTER TABLE `category_shipping_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chattings`
--
ALTER TABLE `chattings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_wallets`
--
ALTER TABLE `customer_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_wallet_histories`
--
ALTER TABLE `customer_wallet_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deal_of_the_days`
--
ALTER TABLE `deal_of_the_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveryman_notifications`
--
ALTER TABLE `deliveryman_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveryman_wallets`
--
ALTER TABLE `deliveryman_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_country_codes`
--
ALTER TABLE `delivery_country_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_histories`
--
ALTER TABLE `delivery_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_man_transactions`
--
ALTER TABLE `delivery_man_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_men`
--
ALTER TABLE `delivery_men`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_zip_codes`
--
ALTER TABLE `delivery_zip_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `digital_product_otp_verifications`
--
ALTER TABLE `digital_product_otp_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature_deals`
--
ALTER TABLE `feature_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deals`
--
ALTER TABLE `flash_deals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_users`
--
ALTER TABLE `guest_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_topics`
--
ALTER TABLE `help_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `loyalty_point_transactions`
--
ALTER TABLE `loyalty_point_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `most_demandeds`
--
ALTER TABLE `most_demandeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_seens`
--
ALTER TABLE `notification_seens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `offline_payments`
--
ALTER TABLE `offline_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_payment_methods`
--
ALTER TABLE `offline_payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_delivery_verifications`
--
ALTER TABLE `order_delivery_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_expected_delivery_histories`
--
ALTER TABLE `order_expected_delivery_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status_histories`
--
ALTER TABLE `order_status_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_transactions`
--
ALTER TABLE `order_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `password_resets_email_index` (`identity`);

--
-- Indexes for table `paytabs_invoices`
--
ALTER TABLE `paytabs_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `phone_or_email_verifications`
--
ALTER TABLE `phone_or_email_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_compares`
--
ALTER TABLE `product_compares`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refund_statuses`
--
ALTER TABLE `refund_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refund_transactions`
--
ALTER TABLE `refund_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search_functions`
--
ALTER TABLE `search_functions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sellers_email_unique` (`email`);

--
-- Indexes for table `seller_wallets`
--
ALTER TABLE `seller_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seller_wallet_histories`
--
ALTER TABLE `seller_wallet_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_types`
--
ALTER TABLE `shipping_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop_followers`
--
ALTER TABLE `shop_followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_medias`
--
ALTER TABLE `social_medias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soft_credentials`
--
ALTER TABLE `soft_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_ticket_convs`
--
ALTER TABLE `support_ticket_convs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD UNIQUE KEY `transactions_id_unique` (`id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `translations_translationable_id_index` (`translationable_id`),
  ADD KEY `translations_locale_index` (`locale`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawal_methods`
--
ALTER TABLE `withdrawal_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_requests`
--
ALTER TABLE `withdraw_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_fund_bonus_categories`
--
ALTER TABLE `add_fund_bonus_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin_wallets`
--
ALTER TABLE `admin_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_wallet_histories`
--
ALTER TABLE `admin_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `billing_addresses`
--
ALTER TABLE `billing_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `business_settings`
--
ALTER TABLE `business_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `cart_shippings`
--
ALTER TABLE `cart_shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT for table `category_shipping_costs`
--
ALTER TABLE `category_shipping_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `chattings`
--
ALTER TABLE `chattings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `customer_wallets`
--
ALTER TABLE `customer_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_wallet_histories`
--
ALTER TABLE `customer_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deal_of_the_days`
--
ALTER TABLE `deal_of_the_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `deliveryman_notifications`
--
ALTER TABLE `deliveryman_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deliveryman_wallets`
--
ALTER TABLE `deliveryman_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_country_codes`
--
ALTER TABLE `delivery_country_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_histories`
--
ALTER TABLE `delivery_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_man_transactions`
--
ALTER TABLE `delivery_man_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_men`
--
ALTER TABLE `delivery_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_zip_codes`
--
ALTER TABLE `delivery_zip_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `digital_product_otp_verifications`
--
ALTER TABLE `digital_product_otp_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emergency_contacts`
--
ALTER TABLE `emergency_contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feature_deals`
--
ALTER TABLE `feature_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_deals`
--
ALTER TABLE `flash_deals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `flash_deal_products`
--
ALTER TABLE `flash_deal_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `guest_users`
--
ALTER TABLE `guest_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=783;

--
-- AUTO_INCREMENT for table `help_topics`
--
ALTER TABLE `help_topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loyalty_point_transactions`
--
ALTER TABLE `loyalty_point_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;

--
-- AUTO_INCREMENT for table `most_demandeds`
--
ALTER TABLE `most_demandeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notification_seens`
--
ALTER TABLE `notification_seens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `offline_payments`
--
ALTER TABLE `offline_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offline_payment_methods`
--
ALTER TABLE `offline_payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100020;

--
-- AUTO_INCREMENT for table `order_delivery_verifications`
--
ALTER TABLE `order_delivery_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_expected_delivery_histories`
--
ALTER TABLE `order_expected_delivery_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_status_histories`
--
ALTER TABLE `order_status_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order_transactions`
--
ALTER TABLE `order_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paytabs_invoices`
--
ALTER TABLE `paytabs_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phone_or_email_verifications`
--
ALTER TABLE `phone_or_email_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `product_compares`
--
ALTER TABLE `product_compares`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tag`
--
ALTER TABLE `product_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=173;

--
-- AUTO_INCREMENT for table `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `refund_statuses`
--
ALTER TABLE `refund_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `refund_transactions`
--
ALTER TABLE `refund_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `search_functions`
--
ALTER TABLE `search_functions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seller_wallets`
--
ALTER TABLE `seller_wallets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `seller_wallet_histories`
--
ALTER TABLE `seller_wallet_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `shipping_types`
--
ALTER TABLE `shipping_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `shop_followers`
--
ALTER TABLE `shop_followers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_medias`
--
ALTER TABLE `social_medias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `soft_credentials`
--
ALTER TABLE `soft_credentials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_ticket_convs`
--
ALTER TABLE `support_ticket_convs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=919;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawal_methods`
--
ALTER TABLE `withdrawal_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `withdraw_requests`
--
ALTER TABLE `withdraw_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
