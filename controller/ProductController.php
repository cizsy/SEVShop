<?php
// Controller/ProductController.php
require_once __DIR__ . '/../Model/Product.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'list';
        $id     = $_GET['id'] ?? null;

        // Only validate CSRF on state-changing POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
        }

        switch ($action) {
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = $this->productModel->create($_POST);
                    if (!$result) {
                        $_SESSION['flash_error'] = 'Failed to create product.';
                    }
                    header("Location: admin.php?page=produk");
                    exit;
                }
                break;

            case 'update':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $result = $this->productModel->update($id, $_POST);
                    if (!$result) {
                        $_SESSION['flash_error'] = 'Failed to update product.';
                    }
                    header("Location: admin.php?page=produk");
                    exit;
                }
                break;

            case 'delete':
                // Delete uses GET, so protect it with a token in the URL instead
                $this->verifyDeleteToken($id);
                $result = $this->productModel->delete($id);
                if (!$result) {
                    $_SESSION['flash_error'] = 'Failed to delete product.';
                }
                header("Location: admin.php?page=produk");
                exit;
        }
    }

    // Call this in your form-rendering view to embed the token
    public static function generateCsrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    // --- Private helpers ---

    private function verifyCsrf(): void {
        $token = $_POST['csrf_token'] ?? '';
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            http_response_code(403);
            exit('Forbidden');
        }
        // Rotate the token after each use
        unset($_SESSION['csrf_token']);
    }

    private function verifyDeleteToken(?string $id): void {
        $token    = $_GET['token'] ?? '';
        $expected = $_SESSION['delete_token_' . $id] ?? '';
        if (empty($expected) || !hash_equals($expected, $token)) {
            http_response_code(403);
            exit('Forbidden');
        }
        unset($_SESSION['delete_token_' . $id]);
    }
}