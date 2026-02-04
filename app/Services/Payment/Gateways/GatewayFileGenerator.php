<?php

namespace App\Services\Payment\Gateways;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GatewayFileGenerator
{
    public static function generate(string $key): string
    {
        $classBase = self::normalizeClassName($key);
        $className = $classBase . 'Gateway';

        $directory = app_path('Services/Payment/Gateways/Gateways');
        $filePath = "{$directory}/{$className}.php";

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (File::exists($filePath)) {
            return "App\\Services\\Payment\\Gateways\\Gateways\\{$className}";
        }

        $fileContent = self::generateContent($className, $key);

        File::put($filePath, $fileContent);

        return "App\\Services\\Payment\\Gateways\\Gateways\\{$className}";
    }

    private static function normalizeClassName(string $key): string
    {
        if ($key === 'paypal') {
            return 'PayPal';
        }

        return Str::studly($key);
    }

    private static function generateContent(string $className, string $key): string
    {
        return <<<PHP
<?php

namespace App\\Services\\Payment\\Gateways\\Gateways;

use App\\Services\\Payment\\Gateways\\Contracts\\PaymentGatewayInterface;
use App\\DTOs\\V1\\Payment\\ProcessPaymentDTO;

class {$className} implements PaymentGatewayInterface
{
    public function key(): string
    {
        return '{$key}';
    }

    public function charge(ProcessPaymentDTO \$dto): array
    {
        // Simulate {$className} charge with success/failure
        \$success = (bool) random_int(0, 1);

        return [
            'success' => \$success,
            'meta' => [
                'provider' => '{$key}',
                'ref' => strtoupper('{$key}') . '-' . uniqid(),
            ],
        ];
    }
}
PHP;
    }
}
