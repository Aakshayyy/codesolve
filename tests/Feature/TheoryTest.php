<?php

namespace Tests\Feature;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TheoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Problem::create([
            'title' => 'Fizz Buzz',
            'slug' => 'fizz-buzz',
            'difficulty' => 'easy',
            'description' => 'Test fizz buzz description',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256
        ]);
    }

    public function test_theory_academy_index_is_accessible(): void
    {
        $response = $this->get(route('theory.index'));

        $response->assertStatus(200);
        $response->assertSee('C++');
        $response->assertSee('Java');
        $response->assertSee('DSA');
    }

    public function test_theory_category_redirects_to_first_topic(): void
    {
        $response = $this->get(route('theory.category', 'cpp'));

        $response->assertRedirect(route('theory.topic', ['cpp', 'intro']));
    }

    public function test_theory_topic_page_is_accessible_with_mapped_problems(): void
    {
        $response = $this->get(route('theory.topic', ['cpp', 'intro']));

        $response->assertStatus(200);
        $response->assertSee('Introduction to C++');
        // Check that the mapped problem is shown
        $response->assertSee('Fizz Buzz');
        $response->assertSee('Solve Challenge');
    }

    public function test_theory_invalid_category_returns_404(): void
    {
        $response = $this->get('/theory/invalid_category');

        $response->assertStatus(404);
    }

    public function test_theory_invalid_topic_returns_404(): void
    {
        $response = $this->get('/theory/cpp/invalid_topic');

        $response->assertStatus(404);
    }
}
