<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Problem;
use App\Services\SignatureService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignatureServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that starter codes are correctly generated for C++, Java, Python, and JS.
     */
    public function test_generate_starter_codes_for_known_problem(): void
    {
        $problem = Problem::create([
            'title' => 'Two Sum',
            'slug' => 'two-sum',
            'difficulty' => 'easy',
            'description' => 'Desc',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        $starters = SignatureService::generateStarterCodes($problem, []);

        $this->assertArrayHasKey('cpp', $starters);
        $this->assertArrayHasKey('java', $starters);
        $this->assertArrayHasKey('python', $starters);
        $this->assertArrayHasKey('javascript', $starters);

        $this->assertStringContainsString('class Solution', $starters['cpp']);
        $this->assertStringContainsString('vector<int>& nums', $starters['cpp']);
        $this->assertStringContainsString('int target', $starters['cpp']);
        $this->assertStringContainsString('vector<int> twoSum', $starters['cpp']);

        $this->assertStringContainsString('class Solution', $starters['java']);
        $this->assertStringContainsString('int[] nums', $starters['java']);
        $this->assertStringContainsString('int[] twoSum', $starters['java']);

        $this->assertStringContainsString('class Solution:', $starters['python']);
        $this->assertStringContainsString('def twoSum(self, nums: List[int], target: int) -> List[int]:', $starters['python']);

        $this->assertStringContainsString('class Solution', $starters['javascript']);
        $this->assertStringContainsString('twoSum(nums, target)', $starters['javascript']);
    }

    /**
     * Test fallback to defaults if signature is not found.
     */
    public function test_generate_starter_codes_fallback_for_unknown_problem(): void
    {
        $problem = Problem::create([
            'title' => 'Unknown problem',
            'slug' => 'unknown-problem',
            'difficulty' => 'easy',
            'description' => 'Desc',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        $defaults = [
            'cpp' => 'default cpp',
            'java' => 'default java',
        ];

        $starters = SignatureService::generateStarterCodes($problem, $defaults);
        $this->assertEquals($defaults, $starters);
    }

    /**
     * Test wrapping C++ code.
     */
    public function test_wrap_cpp_code(): void
    {
        $problem = Problem::create([
            'title' => 'Two Sum',
            'slug' => 'two-sum',
            'difficulty' => 'easy',
            'description' => 'Desc',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        $userCode = "class Solution {\npublic:\n    vector<int> twoSum(vector<int>& nums, int target) {\n        return {0, 1};\n    }\n};";
        $wrapped = SignatureService::wrapWithDriver($problem, 'cpp', $userCode);

        $this->assertStringContainsString($userCode, $wrapped);
        $this->assertStringContainsString('int main()', $wrapped);
        $this->assertStringContainsString('cin >> target', $wrapped);
        $this->assertStringContainsString('ob.twoSum', $wrapped);
    }

    /**
     * Test wrapping Python code.
     */
    public function test_wrap_python_code(): void
    {
        $problem = Problem::create([
            'title' => 'Two Sum',
            'slug' => 'two-sum',
            'difficulty' => 'easy',
            'description' => 'Desc',
            'constraints' => 'None',
            'input_format' => 'None',
            'output_format' => 'None',
            'time_limit' => 1000,
            'memory_limit' => 256,
        ]);

        $userCode = "class Solution:\n    def twoSum(self, nums, target):\n        return [0, 1]";
        $wrapped = SignatureService::wrapWithDriver($problem, 'python', $userCode);

        $this->assertStringContainsString($userCode, $wrapped);
        $this->assertStringContainsString("if __name__ == '__main__':", $wrapped);
        $this->assertStringContainsString("ob = Solution()", $wrapped);
        $this->assertStringContainsString("ans = ob.twoSum(nums, target)", $wrapped);
    }
}
