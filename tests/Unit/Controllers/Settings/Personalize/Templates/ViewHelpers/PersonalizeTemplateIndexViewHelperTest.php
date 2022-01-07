<?php

namespace Tests\Unit\Controllers\Settings\Personalize\Templates\ViewHelpers;

use function env;
use Tests\TestCase;
use App\Models\Template;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\Settings\Personalize\Templates\ViewHelpers\PersonalizeTemplateIndexViewHelper;

class PersonalizeTemplateIndexViewHelperTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_gets_the_data_needed_for_the_view(): void
    {
        $template = Template::factory()->create();
        $array = PersonalizeTemplateIndexViewHelper::data($template->account);
        $this->assertEquals(
            2,
            count($array)
        );
        $this->assertArrayHasKey('templates', $array);
        $this->assertEquals(
            [
                'settings' => env('APP_URL').'/settings',
                'personalize' => env('APP_URL').'/settings/personalize',
                'template_store' => env('APP_URL').'/settings/personalize/templates',
            ],
            $array['url']
        );
    }

    /** @test */
    public function it_gets_the_data_needed_for_the_data_transfer_object(): void
    {
        $template = Template::factory()->create();
        $array = PersonalizeTemplateIndexViewHelper::dtoTemplate($template);
        $this->assertEquals(
            [
                'id' => $template->id,
                'name' => $template->name,
                'url' => [
                    'update' => env('APP_URL').'/settings/personalize/templates/'.$template->id,
                    'destroy' => env('APP_URL').'/settings/personalize/templates/'.$template->id,
                ],
            ],
            $array
        );
    }
}