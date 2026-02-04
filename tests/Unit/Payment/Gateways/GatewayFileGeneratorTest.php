<?php

namespace Tests\Unit\Payment\Gateways;

use App\Services\Payment\Gateways\GatewayFileGenerator;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class GatewayFileGeneratorTest extends TestCase
{
    protected function tearDown(): void
    {
        $files = [
            app_path('Services/Payment/Gateways/Gateways/StripeGateway.php'),
            app_path('Services/Payment/Gateways/Gateways/PayfastGateway.php'),
            app_path('Services/Payment/Gateways/Gateways/MollieGateway.php'),
        ];
        
        foreach ($files as $file) {
            if (File::exists($file)) {
                File::delete($file);
            }
        }
        
        parent::tearDown();
    }

    public function test_generates_gateway_file_with_correct_naming()
    {
        $class = GatewayFileGenerator::generate('stripe');

        $this->assertEquals('App\\Services\\Payment\\Gateways\\Gateways\\StripeGateway', $class);
        
        $this->assertTrue(File::exists(app_path('Services/Payment/Gateways/Gateways/StripeGateway.php')));
    }

    public function test_generated_file_is_valid_php()
    {
        $class = GatewayFileGenerator::generate('payfast');

        $filePath = app_path('Services/Payment/Gateways/Gateways/PayfastGateway.php');
        $content = File::get($filePath);

        $this->assertStringContainsString('<?php', $content);
        $this->assertStringContainsString('class PayfastGateway', $content);
        $this->assertStringContainsString('implements PaymentGatewayInterface', $content);
        $this->assertStringContainsString("return 'payfast'", $content);
        $this->assertStringContainsString('public function charge', $content);
    }

    public function test_does_not_recreate_existing_file()
    {
        $class1 = GatewayFileGenerator::generate('mollie');
        $filePath = app_path('Services/Payment/Gateways/Gateways/MollieGateway.php');
        $originalContent = File::get($filePath);

        $modifiedContent = str_replace('// Simulate', '// CUSTOM COMMENT - Simulate', $originalContent);
        File::put($filePath, $modifiedContent);

        $class2 = GatewayFileGenerator::generate('mollie');

        $this->assertEquals($class1, $class2);

        $currentContent = File::get($filePath);
        $this->assertStringContainsString('CUSTOM COMMENT', $currentContent);
    }

    public function test_converts_snake_case_to_pascal_case()
    {
        $cases = [
            'stripe' => 'StripeGateway',
            'pay_fast' => 'PayFastGateway',
            'pay_pal' => 'PayPalGateway',
            'my_custom_payment' => 'MyCustomPaymentGateway',
        ];

        foreach ($cases as $key => $expected) {
            $class = GatewayFileGenerator::generate($key);
            $this->assertStringEndsWith($expected, $class);
            
            $filePath = app_path("Services/Payment/Gateways/Gateways/{$expected}.php");
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
    }
}
