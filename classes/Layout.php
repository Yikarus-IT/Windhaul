<?php
class Layout
{
    private string $templatePath;
    private string $baseUrl;

    public function __construct()
    {
        // Absolute path to templates folder (no change)
        $this->templatePath = realpath(__DIR__ . '/../templates/') . DIRECTORY_SEPARATOR;

        // Dynamic base URL for assets: Extract project root from SCRIPT_NAME
        $this->baseUrl = $this->detectBaseUrl();
    }

    private function detectBaseUrl(): string
    {
        // Example: /Voldhaul/drivers/page.php → /Voldhaul/
        $scriptName = $_SERVER['SCRIPT_NAME'];      // /Voldhaul/drivers/page.php
        $scriptDir  = dirname($scriptName);         // /Voldhaul/drivers
        $parts = explode('/', trim($scriptDir, '/'));

        // Rebuild base URL using first part (the project folder)
        if (count($parts) > 0) {
            return '/' . $parts[0] . '/assets/';
        }

        // Default fallback (site root)
        return '/assets/';
    }

    public function isActive(string $pathPattern): string
    {
        $currentPath = $_SERVER['SCRIPT_NAME'];
        return (strpos($currentPath, $pathPattern) !== false) ? 'active' : '';
    }

    public function renderLogin(): void
    {
        include $this->templatePath . "login.php";
    }

    public function renderVehicleList(array $vehicles_list = []): void
    {
        $vehicles = $vehicles_list;
        include $this->templatePath . "vehicle_list.php";
    }

    public function renderContactList(array $contacts_list = []): void
    {
        $contacts = $contacts_list;
        include $this->templatePath . "contact_list.php";
    }

    public function renderVehicle(array $data = []): void
    {
        $vehicle = $data;
        include $this->templatePath . "vehicle.php";
    }

    public function renderContact(array $data = []): void
    {
        $contact = $data;
        include $this->templatePath . "contact.php";
    }

    public function renderHeader(): void
    {
        include $this->templatePath . "header.php";
    }

    public function renderSidebar(): void
    {
        $layout = $this;
        include $this->templatePath . "sidebar.php";
    }

    public function renderFooter(): void
    {
        $footerFile = $this->templatePath . "footer.php";
        if (file_exists($footerFile)) {
            include $footerFile;
        }
    }

    public function beginPage(string $title = "Dashboard"): void
    {
        $base = $this->baseUrl;
        $baseHref = '/' . explode('/', trim($_SERVER['SCRIPT_NAME'], '/'))[0] . '/';

        echo <<<HTML
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>{$title}</title>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="icon" type="image/x-icon" href="https://assets.squarespace.com/universal/default-favicon.ico">
                    <base href="{$baseHref}">
                    <link rel="stylesheet" href="{$base}plugins/fontawesome-free/css/all.min.css">
                    <link rel="stylesheet" href="{$base}plugins/bootstrap/css/bootstrap.min.css">
                    <link rel="stylesheet" href="{$base}css/adminlte.min.css">
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
                    <script src="{$base}plugins/jquery/jquery.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
                    <script src="{$base}plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
                    <script src="{$base}js/adminlte.min.js"></script>
                    <style>
                        /* Fix DataTables entries dropdown */
                        .dataTables_length select {
                            min-width: 60px;
                            padding-right: 20px; /* allows for arrow space */
                            appearance: none; /* optionally hide native arrows */
                        }
                    </style>
                </head>
                <body class="hold-transition sidebar-mini layout-fixed">
                <div class="wrapper">
            HTML;
    }

    public function endPage(): void
    {
        $base = $this->baseUrl;

        echo <<<HTML
</div> <!-- /.wrapper -->
</body>
</html>
HTML;
    }
}
