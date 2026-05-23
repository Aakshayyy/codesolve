<?php

namespace Database\Seeders;

use App\Models\Badge;
use App\Models\Contest;
use App\Models\Problem;
use App\Models\Tag;
use App\Models\User;
use App\Models\TestCase;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'CodeSolve Admin',
            'email' => 'admin@codesolve.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $user = User::create([
            'name' => 'Demo Solver',
            'email' => 'user@codesolve.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
            'points' => 50,
            'streak' => 2,
            'last_submission_at' => now()->subDay(),
        ]);

        // 2. Create Tags
        $tagMap = [];
        $tagsData = [
            'arrays' => 'Arrays',
            'strings' => 'Strings',
            'dynamic-programming' => 'Dynamic Programming',
            'graphs' => 'Graphs',
            'trees' => 'Trees',
            'mathematics' => 'Mathematics',
            'sorting' => 'Sorting',
            'searching' => 'Searching',
            'greedy' => 'Greedy Algorithms',
            'two-pointers' => 'Two Pointers',
            'sliding-window' => 'Sliding Window',
            'binary-search' => 'Binary Search'
        ];
        foreach ($tagsData as $slug => $name) {
            $tagMap[$slug] = Tag::create(['name' => $name, 'slug' => $slug]);
        }

        // 3. Create Badges
        Badge::create([
            'name' => 'First Blood',
            'description' => 'Solve your first coding problem successfully.',
            'icon' => 'trophy',
            'requirement_type' => 'solved_count',
            'requirement_value' => 1
        ]);
        Badge::create([
            'name' => 'Streak Starter',
            'description' => 'Maintain a coding streak of 3 consecutive days.',
            'icon' => 'fire',
            'requirement_type' => 'streak',
            'requirement_value' => 3
        ]);
        Badge::create([
            'name' => 'Code Cadet',
            'description' => 'Accrue a total of 100 competitive points.',
            'icon' => 'award',
            'requirement_type' => 'points',
            'requirement_value' => 100
        ]);
        Badge::create([
            'name' => 'Algorithm Knight',
            'description' => 'Accrue a total of 500 competitive points.',
            'icon' => 'shield',
            'requirement_type' => 'points',
            'requirement_value' => 500
        ]);

        // 4. Create Problems Collection (3 original + 20 new Easy, 1 original + 15 new Medium, 15 new Hard)
        $problemsData = [
            // --- ORIGINAL EASY PROBLEMS ---
            [
                'title' => 'Two Sum',
                'slug' => 'two-sum',
                'description' => "Given an array of integers `nums` and an integer `target`, return indices of the two numbers such that they add up to `target`.\n\nYou may assume that each input would have exactly one solution, and you may not use the same element twice.\n\nYou can return the answer in any order.",
                'difficulty' => 'easy',
                'constraints' => "2 <= nums.length <= 10^4\n-10^9 <= nums[i] <= 10^9\n-10^9 <= target <= 10^9\nOnly one valid answer exists.",
                'input_format' => "The input consists of three lines:\n1. The first line contains an integer N, the number of elements in the array.\n2. The second line contains N space-separated integers, representing the elements of the array.\n3. The third line contains an integer T, representing the target sum.",
                'output_format' => "Print the two space-separated indices of the numbers that add up to target. The indices should be printed in ascending order.",
                'time_limit' => 1000,
                'memory_limit' => 256,
                'tags' => ['arrays'],
                'test_cases' => [
                    ['input' => "4\n2 7 11 15\n9", 'expected_output' => "0 1", 'is_hidden' => false],
                    ['input' => "3\n3 2 4\n6", 'expected_output' => "1 2", 'is_hidden' => true],
                    ['input' => "2\n3 3\n6", 'expected_output' => "0 1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Reverse String',
                'slug' => 'reverse-string',
                'description' => "Write a program that takes a string input and prints its reversed representation.",
                'difficulty' => 'easy',
                'constraints' => "1 <= string.length <= 10^5\nThe string contains printable ASCII characters.",
                'input_format' => "A single line containing the input string.",
                'output_format' => "A single line containing the reversed string.",
                'time_limit' => 1000,
                'memory_limit' => 256,
                'tags' => ['strings'],
                'test_cases' => [
                    ['input' => "hello", 'expected_output' => "olleh", 'is_hidden' => false],
                    ['input' => "Hannah", 'expected_output' => "hannaH", 'is_hidden' => true],
                    ['input' => "CodeSolve", 'expected_output' => "evloSedoC", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Fibonacci Number',
                'slug' => 'fibonacci-number',
                'description' => "The Fibonacci numbers, commonly denoted F(n) form a sequence, called the Fibonacci sequence, such that each number is the sum of the two preceding ones, starting from 0 and 1.\n\nF(0) = 0, F(1) = 1\nF(n) = F(n - 1) + F(n - 2), for n > 1.\n\nGiven n, calculate F(n).",
                'difficulty' => 'easy',
                'constraints' => "0 <= n <= 30",
                'input_format' => "A single line containing an integer n.",
                'output_format' => "Print the value of F(n).",
                'time_limit' => 1000,
                'memory_limit' => 256,
                'tags' => ['dynamic-programming', 'mathematics'],
                'test_cases' => [
                    ['input' => "4", 'expected_output' => "3", 'is_hidden' => false],
                    ['input' => "0", 'expected_output' => "0", 'is_hidden' => true],
                    ['input' => "2", 'expected_output' => "1", 'is_hidden' => true],
                    ['input' => "10", 'expected_output' => "55", 'is_hidden' => true]
                ]
            ],

            // --- 20 NEW EASY PROBLEMS ---
            [
                'title' => 'Palindrome Number',
                'slug' => 'palindrome-number',
                'description' => "Given an integer `x`, return `true` if `x` is a palindrome, and `false` otherwise.",
                'difficulty' => 'easy',
                'constraints' => "-2^31 <= x <= 2^31 - 1",
                'input_format' => "A single line containing the integer x.",
                'output_format' => "Print 'true' if x is a palindrome, otherwise 'false'.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['mathematics'],
                'test_cases' => [
                    ['input' => "121", 'expected_output' => "true", 'is_hidden' => false],
                    ['input' => "-121", 'expected_output' => "false", 'is_hidden' => true],
                    ['input' => "10", 'expected_output' => "false", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Fizz Buzz',
                'slug' => 'fizz-buzz',
                'description' => "Given an integer `n`, print the numbers from 1 to `n`. For multiples of 3, print 'Fizz'. For multiples of 5, print 'Buzz'. For numbers which are multiples of both 3 and 5, print 'FizzBuzz'.",
                'difficulty' => 'easy',
                'constraints' => "1 <= n <= 10^4",
                'input_format' => "A single line containing the integer n.",
                'output_format' => "n lines containing the result output string for each number.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['mathematics'],
                'test_cases' => [
                    ['input' => "5", 'expected_output' => "1\n2\nFizz\n4\nBuzz", 'is_hidden' => false],
                    ['input' => "3", 'expected_output' => "1\n2\nFizz", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Valid Parentheses',
                'slug' => 'valid-parentheses',
                'description' => "Given a string `s` containing just the characters '(', ')', '{', '}', '[' and ']', determine if the input string is valid.",
                'difficulty' => 'easy',
                'constraints' => "1 <= s.length <= 10^4",
                'input_format' => "A single line containing the string s.",
                'output_format' => "Print 'true' if parenthesization is valid, otherwise 'false'.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings'],
                'test_cases' => [
                    ['input' => "()[]{}", 'expected_output' => "true", 'is_hidden' => false],
                    ['input' => "(]", 'expected_output' => "false", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Merge Two Sorted Lists',
                'slug' => 'merge-two-sorted-lists',
                'description' => "Given two sorted integer arrays, merge them into a single sorted output array.",
                'difficulty' => 'easy',
                'constraints' => "0 <= sizes <= 1000",
                'input_format' => "Four lines:\n1. N, size of first array\n2. N space-separated integers\n3. M, size of second array\n4. M space-separated integers",
                'output_format' => "Print space-separated sorted integers of the combined array.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'sorting'],
                'test_cases' => [
                    ['input' => "3\n1 2 4\n3\n1 3 4", 'expected_output' => "1 1 2 3 4 4", 'is_hidden' => false],
                    ['input' => "0\n\n1\n0", 'expected_output' => "0", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Remove Duplicates from Sorted Array',
                'slug' => 'remove-duplicates-from-sorted-array',
                'description' => "Given an integer array sorted in non-decreasing order, remove the duplicates in-place such that each unique element appears only once. Return the number of unique elements followed by the sorted unique array.",
                'difficulty' => 'easy',
                'constraints' => "1 <= nums.length <= 3 * 10^4",
                'input_format' => "First line: integer N. Second line: N space-separated integers.",
                'output_format' => "Two lines:\n1. Number of unique elements\n2. Space-separated unique integers",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'two-pointers'],
                'test_cases' => [
                    ['input' => "3\n1 1 2", 'expected_output' => "2\n1 2", 'is_hidden' => false],
                    ['input' => "10\n0 0 1 1 1 2 2 3 3 4", 'expected_output' => "5\n0 1 2 3 4", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Power of Two',
                'slug' => 'power-of-two',
                'description' => "Given an integer `n`, return `true` if it is a power of two. Otherwise, return `false`.",
                'difficulty' => 'easy',
                'constraints' => "-2^31 <= n <= 2^31 - 1",
                'input_format' => "A single line containing the integer n.",
                'output_format' => "Print 'true' or 'false'.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['mathematics'],
                'test_cases' => [
                    ['input' => "16", 'expected_output' => "true", 'is_hidden' => false],
                    ['input' => "3", 'expected_output' => "false", 'is_hidden' => true],
                    ['input' => "1", 'expected_output' => "true", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Single Number',
                'slug' => 'single-number',
                'description' => "Given a non-empty array of integers `nums`, every element appears twice except for one. Find that single one.",
                'difficulty' => 'easy',
                'constraints' => "1 <= nums.length <= 3 * 10^4",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print the single number.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays'],
                'test_cases' => [
                    ['input' => "3\n2 2 1", 'expected_output' => "1", 'is_hidden' => false],
                    ['input' => "5\n4 1 2 1 2", 'expected_output' => "4", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Valid Anagram',
                'slug' => 'valid-anagram',
                'description' => "Given two strings `s` and `t`, return `true` if `t` is an anagram of `s`, and `false` otherwise.",
                'difficulty' => 'easy',
                'constraints' => "1 <= s.length, t.length <= 5 * 10^4",
                'input_format' => "Two lines containing string s and string t respectively.",
                'output_format' => "Print 'true' or 'false'.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings'],
                'test_cases' => [
                    ['input' => "anagram\nnagaram", 'expected_output' => "true", 'is_hidden' => false],
                    ['input' => "rat\ncar", 'expected_output' => "false", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Contains Duplicate',
                'slug' => 'contains-duplicate',
                'description' => "Given an integer array `nums`, return `true` if any value appears at least twice in the array, and return `false` if every element is distinct.",
                'difficulty' => 'easy',
                'constraints' => "1 <= nums.length <= 10^5",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print 'true' or 'false'.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays'],
                'test_cases' => [
                    ['input' => "4\n1 2 3 1", 'expected_output' => "true", 'is_hidden' => false],
                    ['input' => "4\n1 2 3 4", 'expected_output' => "false", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Majority Element',
                'slug' => 'majority-element',
                'description' => "Given an array `nums` of size `n`, return the majority element (the element that appears more than ⌊n / 2⌋ times).",
                'difficulty' => 'easy',
                'constraints' => "1 <= n <= 5 * 10^4",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print the majority element.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays'],
                'test_cases' => [
                    ['input' => "3\n3 2 3", 'expected_output' => "3", 'is_hidden' => false],
                    ['input' => "7\n2 2 1 1 1 2 2", 'expected_output' => "2", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Move Zeroes',
                'slug' => 'move-zeroes',
                'description' => "Given an integer array `nums`, move all 0's to the end of it while maintaining the relative order of the non-zero elements.",
                'difficulty' => 'easy',
                'constraints' => "1 <= nums.length <= 10^4",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print the elements separated by space.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'two-pointers'],
                'test_cases' => [
                    ['input' => "5\n0 1 0 3 12", 'expected_output' => "1 3 12 0 0", 'is_hidden' => false],
                    ['input' => "1\n0", 'expected_output' => "0", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Intersection of Two Arrays',
                'slug' => 'intersection-of-two-arrays',
                'description' => "Given two integer arrays `nums1` and `nums2`, return an array of their intersection. Each element in the result must be unique and you may return the result in any order.",
                'difficulty' => 'easy',
                'constraints' => "1 <= nums1.length, nums2.length <= 1000",
                'input_format' => "Four lines:\n1. N, size of first array\n2. N space-separated integers\n3. M, size of second array\n4. M space-separated integers",
                'output_format' => "Print space-separated sorted unique intersecting integers.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'sorting'],
                'test_cases' => [
                    ['input' => "4\n1 2 2 1\n2\n2 2", 'expected_output' => "2", 'is_hidden' => false],
                    ['input' => "3\n4 9 5\n5\n9 4 9 8 4", 'expected_output' => "4 9", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Binary Search',
                'slug' => 'binary-search',
                'description' => "Given an array of integers `nums` which is sorted in ascending order, and an integer `target`, write a function to search `target` in `nums`. If `target` exists, then return its index. Otherwise, return -1.",
                'difficulty' => 'easy',
                'constraints' => "1 <= nums.length <= 10^4",
                'input_format' => "Three lines:\n1. N, size of array\n2. N space-separated integers\n3. Target value",
                'output_format' => "Print index of target or -1.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['binary-search', 'searching'],
                'test_cases' => [
                    ['input' => "6\n-1 0 3 5 9 12\n9", 'expected_output' => "4", 'is_hidden' => false],
                    ['input' => "6\n-1 0 3 5 9 12\n2", 'expected_output' => "-1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'First Bad Version',
                'slug' => 'first-bad-version',
                'description' => "You are a product manager and currently leading a team to develop a new product. Unfortunately, the latest version of your product fails the quality check. Since each version is developed based on the previous version, all the versions after a bad version are also bad. Find the first bad version.",
                'difficulty' => 'easy',
                'constraints' => "1 <= bad <= n <= 2^31 - 1",
                'input_format' => "Two lines:\n1. N, total versions\n2. B, the first bad version",
                'output_format' => "Print the first bad version.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['binary-search'],
                'test_cases' => [
                    ['input' => "5\n4", 'expected_output' => "4", 'is_hidden' => false],
                    ['input' => "2\n1", 'expected_output' => "1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Climbing Stairs',
                'slug' => 'climbing-stairs',
                'description' => "You are climbing a staircase. It takes `n` steps to reach the top. Each time you can either climb 1 or 2 steps. In how many distinct ways can you climb to the top?",
                'difficulty' => 'easy',
                'constraints' => "1 <= n <= 45",
                'input_format' => "A single line containing integer n.",
                'output_format' => "Print the number of distinct ways.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['dynamic-programming', 'mathematics'],
                'test_cases' => [
                    ['input' => "3", 'expected_output' => "3", 'is_hidden' => false],
                    ['input' => "2", 'expected_output' => "2", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Square Root of X',
                'slug' => 'sqrt-x',
                'description' => "Given a non-negative integer `x`, return the square root of `x` rounded down to the nearest integer. The returned integer should be non-negative as well.",
                'difficulty' => 'easy',
                'constraints' => "0 <= x <= 2^31 - 1",
                'input_format' => "A single line containing the integer x.",
                'output_format' => "Print the rounded down square root.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['mathematics', 'binary-search'],
                'test_cases' => [
                    ['input' => "8", 'expected_output' => "2", 'is_hidden' => false],
                    ['input' => "4", 'expected_output' => "2", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Length of Last Word',
                'slug' => 'length-of-last-word',
                'description' => "Given a string `s` consisting of words and spaces, return the length of the last word in the string.",
                'difficulty' => 'easy',
                'constraints' => "1 <= s.length <= 10^4",
                'input_format' => "A single line containing the string s.",
                'output_format' => "Print the length of the last word.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings'],
                'test_cases' => [
                    ['input' => "Hello World", 'expected_output' => "5", 'is_hidden' => false],
                    ['input' => "   fly me   to   the moon  ", 'expected_output' => "4", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Plus One',
                'slug' => 'plus-one',
                'description' => "You are given a large integer represented as an integer array `digits`, where each `digits[i]` is the `i-th` digit of the integer. The digits are ordered from most significant to least significant in left-to-right order. Increment the large integer by one and return the resulting array of digits.",
                'difficulty' => 'easy',
                'constraints' => "1 <= digits.length <= 100",
                'input_format' => "First line: N. Second line: N space-separated digits.",
                'output_format' => "Print space-separated digits of the result.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'mathematics'],
                'test_cases' => [
                    ['input' => "3\n1 2 3", 'expected_output' => "1 2 4", 'is_hidden' => false],
                    ['input' => "1\n9", 'expected_output' => "1 0", 'is_hidden' => true]
                ]
            ],
            [
                'title' => "Pascal's Triangle",
                'slug' => 'pascals-triangle',
                'description' => "Given an integer `numRows`, print the first `numRows` of Pascal's triangle.",
                'difficulty' => 'easy',
                'constraints' => "1 <= numRows <= 30",
                'input_format' => "A single line containing numRows.",
                'output_format' => "Print Pascal's triangle rows as space-separated integers on individual lines.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['mathematics'],
                'test_cases' => [
                    ['input' => "3", 'expected_output' => "1\n1 1\n1 2 1", 'is_hidden' => false],
                    ['input' => "5", 'expected_output' => "1\n1 1\n1 2 1\n1 3 3 1\n1 4 6 4 1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Search Insert Position',
                'slug' => 'search-insert-position',
                'description' => "Given a sorted array of distinct integers and a target value, return the index if the target is found. If not, return the index where it would be if it were inserted in order.",
                'difficulty' => 'easy',
                'constraints' => "1 <= nums.length <= 10^4",
                'input_format' => "Three lines:\n1. N, size of array\n2. N space-separated integers\n3. Target value",
                'output_format' => "Print insert index.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['binary-search'],
                'test_cases' => [
                    ['input' => "4\n1 3 5 6\n5", 'expected_output' => "2", 'is_hidden' => false],
                    ['input' => "4\n1 3 5 6\n2", 'expected_output' => "1", 'is_hidden' => true]
                ]
            ],

            // --- ORIGINAL MEDIUM PROBLEMS ---
            [
                'title' => 'Add Two Numbers',
                'slug' => 'add-two-numbers',
                'description' => "Given two space-separated integers, calculate and print their sum.",
                'difficulty' => 'medium',
                'constraints' => "-10^9 <= A, B <= 10^9",
                'input_format' => "A single line containing two integers A and B, separated by a single space.",
                'output_format' => "Print a single integer representing the sum A + B.",
                'time_limit' => 1000,
                'memory_limit' => 256,
                'tags' => ['mathematics'],
                'test_cases' => [
                    ['input' => "12 34", 'expected_output' => "46", 'is_hidden' => false],
                    ['input' => "-10 10", 'expected_output' => "0", 'is_hidden' => true],
                    ['input' => "100000000 200000000", 'expected_output' => "300000000", 'is_hidden' => true]
                ]
            ],

            // --- 15 NEW MEDIUM PROBLEMS ---
            [
                'title' => '3Sum',
                'slug' => 'three-sum',
                'description' => "Given an integer array `nums`, return all the triplets `[nums[i], nums[j], nums[k]]` such that `i != j`, `i != k`, and `j != k`, and `nums[i] + nums[j] + nums[k] == 0`.",
                'difficulty' => 'medium',
                'constraints' => "3 <= nums.length <= 3000",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print each unique triplet on a new line sorted in ascending order.",
                'time_limit' => 2000, 'memory_limit' => 256, 'tags' => ['arrays', 'two-pointers', 'sorting'],
                'test_cases' => [
                    ['input' => "6\n-1 0 1 2 -1 -4", 'expected_output' => "-1 -1 2\n-1 0 1", 'is_hidden' => false],
                    ['input' => "3\n0 1 1", 'expected_output' => "", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Longest Substring Without Repeating Characters',
                'slug' => 'longest-substring-without-repeating-characters',
                'description' => "Given a string `s`, find the length of the longest substring without repeating characters.",
                'difficulty' => 'medium',
                'constraints' => "0 <= s.length <= 5 * 10^4",
                'input_format' => "A single line containing the string s.",
                'output_format' => "Print length of the longest unique substring.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings', 'sliding-window'],
                'test_cases' => [
                    ['input' => "abcabcbb", 'expected_output' => "3", 'is_hidden' => false],
                    ['input' => "bbbbb", 'expected_output' => "1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Container With Most Water',
                'slug' => 'container-with-most-water',
                'description' => "You are given an integer array `height` of length `n`. There are `n` vertical lines drawn such that the two endpoints of the `i-th` line are `(i, 0)` and `(i, height[i])`. Find two lines that together with the x-axis form a container, such that the container contains the most water.",
                'difficulty' => 'medium',
                'constraints' => "2 <= n <= 10^5",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print maximum water capacity.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'two-pointers'],
                'test_cases' => [
                    ['input' => "9\n1 8 6 2 5 4 8 3 7", 'expected_output' => "49", 'is_hidden' => false],
                    ['input' => "2\n1 1", 'expected_output' => "1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'String to Integer (atoi)',
                'slug' => 'string-to-integer-atoi',
                'description' => "Implement the `myAtoi(string s)` function, which converts a string into a 32-bit signed integer.",
                'difficulty' => 'medium',
                'constraints' => "0 <= s.length <= 200",
                'input_format' => "A single line containing the input string.",
                'output_format' => "Print the parsed 32-bit signed integer.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings', 'mathematics'],
                'test_cases' => [
                    ['input' => "   -42", 'expected_output' => "-42", 'is_hidden' => false],
                    ['input' => "4193 with words", 'expected_output' => "4193", 'is_hidden' => true]
                ]
            ],
            [
                'title' => '3Sum Closest',
                'slug' => 'three-sum-closest',
                'description' => "Given an integer array `nums` of length `n` and an integer `target`, find three integers in `nums` such that the sum is closest to `target`.",
                'difficulty' => 'medium',
                'constraints' => "3 <= nums.length <= 1000",
                'input_format' => "Three lines:\n1. N, size of array\n2. N space-separated integers\n3. Target sum",
                'output_format' => "Print the closest sum.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'two-pointers', 'sorting'],
                'test_cases' => [
                    ['input' => "4\n-1 2 1 -4\n1", 'expected_output' => "2", 'is_hidden' => false],
                    ['input' => "3\n0 0 0\n1", 'expected_output' => "0", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Generate Parentheses',
                'slug' => 'generate-parentheses',
                'description' => "Given `n` pairs of parentheses, write a function to generate all combinations of well-formed parentheses.",
                'difficulty' => 'medium',
                'constraints' => "1 <= n <= 8",
                'input_format' => "A single line containing integer n.",
                'output_format' => "Print combinations on individual lines, sorted lexicographically.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings', 'dynamic-programming'],
                'test_cases' => [
                    ['input' => "3", 'expected_output' => "((()))\n(()())\n(())()\n()(())\n()()()", 'is_hidden' => false],
                    ['input' => "1", 'expected_output' => "()", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Rotate Image',
                'slug' => 'rotate-image',
                'description' => "You are given an `n x n` 2D matrix representing an image, rotate the image by 90 degrees (clockwise). You have to rotate the image in-place.",
                'difficulty' => 'medium',
                'constraints' => "1 <= n <= 20",
                'input_format' => "First line: N. Next N lines: N space-separated integers representing the matrix rows.",
                'output_format' => "Print N lines of space-separated rotated matrix.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays'],
                'test_cases' => [
                    ['input' => "3\n1 2 3\n4 5 6\n7 8 9", 'expected_output' => "7 4 1\n8 5 2\n9 6 3", 'is_hidden' => false],
                    ['input' => "2\n1 2\n3 4", 'expected_output' => "3 1\n4 2", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Group Anagrams',
                'slug' => 'group-anagrams',
                'description' => "Given an array of strings `strs`, group the anagrams together. You can return the answer in any order.",
                'difficulty' => 'medium',
                'constraints' => "1 <= strs.length <= 10^4",
                'input_format' => "First line: N. Second line: N space-separated strings.",
                'output_format' => "Print groups of anagrams. Group members should be space-separated and groups sorted alphabetically.",
                'time_limit' => 1500, 'memory_limit' => 256, 'tags' => ['strings', 'sorting'],
                'test_cases' => [
                    ['input' => "6\neat tea tan ate nat bat", 'expected_output' => "bat\neat tea ate\ntan nat", 'is_hidden' => false],
                    ['input' => "1\na", 'expected_output' => "a", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Unique Paths',
                'slug' => 'unique-paths',
                'description' => "There is a robot on an `m x n` grid. The robot is initially located at the top-left corner. The robot tries to move to the bottom-right corner. The robot can only move either down or right at any point in time. Given the two integers `m` and `n`, return the number of possible unique paths.",
                'difficulty' => 'medium',
                'constraints' => "1 <= m, n <= 100",
                'input_format' => "A single line containing m and n separated by space.",
                'output_format' => "Print number of unique paths.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['dynamic-programming', 'mathematics'],
                'test_cases' => [
                    ['input' => "3 7", 'expected_output' => "28", 'is_hidden' => false],
                    ['input' => "3 2", 'expected_output' => "3", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Coin Change',
                'slug' => 'coin-change',
                'description' => "You are given an integer array `coins` representing coins of different denominations and an integer `amount` representing a total amount of money. Return the fewest number of coins that you need to make up that amount.",
                'difficulty' => 'medium',
                'constraints' => "1 <= coins.length <= 12, 0 <= amount <= 10^4",
                'input_format' => "Three lines:\n1. N, number of coin types\n2. N space-separated coin denominations\n3. Target amount",
                'output_format' => "Print min coins needed, or -1 if impossible.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['dynamic-programming'],
                'test_cases' => [
                    ['input' => "3\n1 2 5\n11", 'expected_output' => "3", 'is_hidden' => false],
                    ['input' => "1\n2\n3", 'expected_output' => "-1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Longest Common Subsequence',
                'slug' => 'longest-common-subsequence',
                'description' => "Given two strings `text1` and `text2`, return the length of their longest common subsequence. If there is no common subsequence, return 0.",
                'difficulty' => 'medium',
                'constraints' => "1 <= text1.length, text2.length <= 1000",
                'input_format' => "Two lines containing text1 and text2.",
                'output_format' => "Print length of the longest common subsequence.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings', 'dynamic-programming'],
                'test_cases' => [
                    ['input' => "abcde\nace", 'expected_output' => "3", 'is_hidden' => false],
                    ['input' => "abc\ndef", 'expected_output' => "0", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Course Schedule',
                'slug' => 'course-schedule',
                'description' => "There are a total of `numCourses` courses you have to take, labeled from 0 to `numCourses - 1`. You are given an array `prerequisites` where `prerequisites[i] = [ai, bi]` indicates that you must take course `bi` first if you want to take course `ai`. Return `true` if you can finish all courses. Otherwise, return `false`.",
                'difficulty' => 'medium',
                'constraints' => "1 <= numCourses <= 2000",
                'input_format' => "Three lines:\n1. numCourses\n2. P, number of prerequisite pairs\n3. Next P lines: ai and bi separated by space",
                'output_format' => "Print 'true' or 'false'.",
                'time_limit' => 1500, 'memory_limit' => 256, 'tags' => ['graphs'],
                'test_cases' => [
                    ['input' => "2\n1\n1 0", 'expected_output' => "true", 'is_hidden' => false],
                    ['input' => "2\n2\n1 0\n0 1", 'expected_output' => "false", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Product of Array Except Self',
                'slug' => 'product-of-array-except-self',
                'description' => "Given an integer array `nums`, return an array `answer` such that `answer[i]` is equal to the product of all the elements of `nums` except `nums[i]` in O(n) complexity.",
                'difficulty' => 'medium',
                'constraints' => "2 <= nums.length <= 10^5",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print space-separated product integers.",
                'time_limit' => 1500, 'memory_limit' => 256, 'tags' => ['arrays'],
                'test_cases' => [
                    ['input' => "4\n1 2 3 4", 'expected_output' => "24 12 8 6", 'is_hidden' => false],
                    ['input' => "5\n-1 1 0 -3 3", 'expected_output' => "0 0 9 0 0", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Subarray Sum Equals K',
                'slug' => 'subarray-sum-equals-k',
                'description' => "Given an array of integers `nums` and an integer `k`, return the total number of subarrays whose sum equals to `k`.",
                'difficulty' => 'medium',
                'constraints' => "1 <= nums.length <= 2 * 10^4",
                'input_format' => "Three lines:\n1. N, size of array\n2. N space-separated integers\n3. Target sum K",
                'output_format' => "Print count of subarrays.",
                'time_limit' => 1500, 'memory_limit' => 256, 'tags' => ['arrays'],
                'test_cases' => [
                    ['input' => "3\n1 1 1\n2", 'expected_output' => "2", 'is_hidden' => false],
                    ['input' => "3\n1 2 3\n3", 'expected_output' => "2", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Find First and Last Position of Element in Sorted Array',
                'slug' => 'find-first-and-last-position-of-element-in-sorted-array',
                'description' => "Given an array of integers `nums` sorted in non-decreasing order, find the starting and ending position of a given `target` value. If target is not found, return `[-1, -1]`.",
                'difficulty' => 'medium',
                'constraints' => "0 <= nums.length <= 10^5",
                'input_format' => "Three lines:\n1. N, size of array\n2. N space-separated sorted integers\n3. Target value",
                'output_format' => "Print two space-separated integers representing start and end index.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['binary-search', 'searching'],
                'test_cases' => [
                    ['input' => "6\n5 7 7 8 8 10\n8", 'expected_output' => "3 4", 'is_hidden' => false],
                    ['input' => "6\n5 7 7 8 8 10\n6", 'expected_output' => "-1 -1", 'is_hidden' => true]
                ]
            ],

            // --- 15 NEW HARD PROBLEMS ---
            [
                'title' => 'Median of Two Sorted Arrays',
                'slug' => 'median-of-two-sorted-arrays',
                'description' => "Given two sorted arrays `nums1` and `nums2` of size `m` and `n` respectively, return the median of the two sorted arrays.",
                'difficulty' => 'hard',
                'constraints' => "0 <= m, n <= 1000",
                'input_format' => "Four lines:\n1. N, size of first array\n2. N space-separated integers\n3. M, size of second array\n4. M space-separated integers",
                'output_format' => "Print the median as a float value.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'binary-search', 'sorting'],
                'test_cases' => [
                    ['input' => "2\n1 3\n1\n2", 'expected_output' => "2.0", 'is_hidden' => false],
                    ['input' => "2\n1 2\n2\n3 4", 'expected_output' => "2.5", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Regular Expression Matching',
                'slug' => 'regular-expression-matching',
                'description' => "Given an input string `s` and a pattern `p`, implement regular expression matching with support for '.' and '*' where '.' matches any single character and '*' matches zero or more of the preceding element.",
                'difficulty' => 'hard',
                'constraints' => "1 <= s.length, p.length <= 20",
                'input_format' => "Two lines containing string s and pattern p.",
                'output_format' => "Print 'true' or 'false'.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings', 'dynamic-programming'],
                'test_cases' => [
                    ['input' => "aa\na*", 'expected_output' => "true", 'is_hidden' => false],
                    ['input' => "ab\n.*", 'expected_output' => "true", 'is_hidden' => true],
                    ['input' => "mississippi\nmis*is*p*.", 'expected_output' => "false", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Merge k Sorted Lists',
                'slug' => 'merge-k-sorted-lists',
                'description' => "You are given an array of `k` linked-lists `lists`, each linked-list is sorted in ascending order. Merge all the linked-lists into one sorted linked-list and return it.",
                'difficulty' => 'hard',
                'constraints' => "0 <= k <= 10^4",
                'input_format' => "First line: K. Next K blocks: First line is size S, second line contains S space-separated sorted integers.",
                'output_format' => "Print space-separated sorted combined integers.",
                'time_limit' => 2000, 'memory_limit' => 256, 'tags' => ['sorting', 'searching'],
                'test_cases' => [
                    ['input' => "3\n3\n1 4 5\n3\n1 3 4\n2\n2 6", 'expected_output' => "1 1 2 3 4 4 5 6", 'is_hidden' => false],
                    ['input' => "0", 'expected_output' => "", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Reverse Nodes in k-Group',
                'slug' => 'reverse-nodes-in-k-group',
                'description' => "Given the head of a linked list, reverse the nodes of the list `k` at a time and return the modified list. `k` is a positive integer and is less than or equal to the length of the linked list.",
                'difficulty' => 'hard',
                'constraints' => "1 <= sz <= 5000",
                'input_format' => "Three lines:\n1. N, size of list\n2. N space-separated list integers\n3. Group size k",
                'output_format' => "Print space-separated modified integers.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['two-pointers'],
                'test_cases' => [
                    ['input' => "5\n1 2 3 4 5\n2", 'expected_output' => "2 1 4 3 5", 'is_hidden' => false],
                    ['input' => "5\n1 2 3 4 5\n3", 'expected_output' => "3 2 1 4 5", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'First Missing Positive',
                'slug' => 'first-missing-positive',
                'description' => "Given an unsorted integer array `nums`, return the smallest missing positive integer in O(n) time and O(1) auxiliary space.",
                'difficulty' => 'hard',
                'constraints' => "1 <= nums.length <= 10^5",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print smallest missing positive integer.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays'],
                'test_cases' => [
                    ['input' => "3\n1 2 0", 'expected_output' => "3", 'is_hidden' => false],
                    ['input' => "4\n3 4 -1 1", 'expected_output' => "2", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Trapping Rain Water',
                'slug' => 'trapping-rain-water',
                'description' => "Given `n` non-negative integers representing an elevation map where the width of each bar is 1, compute how much water it can trap after raining.",
                'difficulty' => 'hard',
                'constraints' => "n <= 2 * 10^4",
                'input_format' => "First line: N. Second line: N space-separated elevation integers.",
                'output_format' => "Print total units of trapped water.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['arrays', 'two-pointers'],
                'test_cases' => [
                    ['input' => "12\n0 1 0 2 1 0 1 3 2 1 2 1", 'expected_output' => "6", 'is_hidden' => false],
                    ['input' => "3\n3 0 3", 'expected_output' => "3", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'N-Queens',
                'slug' => 'n-queens',
                'description' => "The n-queens puzzle is the problem of placing `n` queens on an `n x n` chessboard such that no two queens attack each other. Given an integer `n`, return the number of distinct solutions.",
                'difficulty' => 'hard',
                'constraints' => "1 <= n <= 9",
                'input_format' => "A single line containing the chessboard size n.",
                'output_format' => "Print the number of valid solutions.",
                'time_limit' => 1500, 'memory_limit' => 256, 'tags' => ['mathematics'],
                'test_cases' => [
                    ['input' => "4", 'expected_output' => "2", 'is_hidden' => false],
                    ['input' => "1", 'expected_output' => "1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Edit Distance',
                'slug' => 'edit-distance',
                'description' => "Given two strings `word1` and `word2`, return the minimum number of operations required to convert `word1` to `word2` (Operations: Insert, Delete, Replace).",
                'difficulty' => 'hard',
                'constraints' => "0 <= word1.length, word2.length <= 500",
                'input_format' => "Two lines containing word1 and word2.",
                'output_format' => "Print the edit distance integer.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['strings', 'dynamic-programming'],
                'test_cases' => [
                    ['input' => "horse\nros", 'expected_output' => "3", 'is_hidden' => false],
                    ['input' => "intention\nexecution", 'expected_output' => "5", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Maximal Rectangle',
                'slug' => 'maximal-rectangle',
                'description' => "Given a `rows x cols` binary matrix filled with 0's and 1's, find the largest rectangle containing only 1's and return its area.",
                'difficulty' => 'hard',
                'constraints' => "rows, cols <= 200",
                'input_format' => "First line: R and C. Next R lines: C space-separated binary values.",
                'output_format' => "Print area of maximal rectangle.",
                'time_limit' => 1500, 'memory_limit' => 256, 'tags' => ['arrays', 'dynamic-programming'],
                'test_cases' => [
                    ['input' => "4 5\n1 0 1 0 0\n1 0 1 1 1\n1 1 1 1 1\n1 0 0 1 0", 'expected_output' => "6", 'is_hidden' => false],
                    ['input' => "1 1\n0", 'expected_output' => "0", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Binary Tree Maximum Path Sum',
                'slug' => 'binary-tree-maximum-path-sum',
                'description' => "A path in a binary tree is a sequence of nodes where each pair of adjacent nodes in the sequence has an edge connecting them. Find the maximum path sum of any non-empty path.",
                'difficulty' => 'hard',
                'constraints' => "nodes count <= 30005",
                'input_format' => "First line: N, node count. Second line: N space-separated node values in level order (use -999 for null).",
                'output_format' => "Print the maximum path sum.",
                'time_limit' => 1000, 'memory_limit' => 256, 'tags' => ['trees'],
                'test_cases' => [
                    ['input' => "3\n1 2 3", 'expected_output' => "6", 'is_hidden' => false],
                    ['input' => "7\n-10 9 20 -999 -999 15 7", 'expected_output' => "42", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Word Ladder',
                'slug' => 'word-ladder',
                'description' => "A transformation sequence from word `beginWord` to word `endWord` using a dictionary `wordList` is a sequence of words `beginWord -> s1 -> s2 -> ... -> sk` such that every adjacent pair of words differs by a single letter. Return the number of words in the shortest transformation sequence, or 0 if no such sequence exists.",
                'difficulty' => 'hard',
                'constraints' => "1 <= beginWord.length <= 10",
                'input_format' => "Four lines:\n1. beginWord\n2. endWord\n3. W, size of dictionary\n4. W space-separated words",
                'output_format' => "Print transformation sequence length.",
                'time_limit' => 2000, 'memory_limit' => 256, 'tags' => ['graphs', 'searching'],
                'test_cases' => [
                    ['input' => "hit\ncog\n5\nhot dot dog lot log", 'expected_output' => "5", 'is_hidden' => false],
                    ['input' => "hit\ncog\n4\nhot dot dog lot", 'expected_output' => "0", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Sliding Window Maximum',
                'slug' => 'sliding-window-maximum',
                'description' => "You are given an array of integers `nums`, there is a sliding window of size `k` which is moving from the very left of the array to the very right. Return the max sliding window.",
                'difficulty' => 'hard',
                'constraints' => "1 <= nums.length <= 10^5, 1 <= k <= nums.length",
                'input_format' => "Three lines:\n1. N, array size\n2. N space-separated integers\n3. Window size K",
                'output_format' => "Print space-separated sliding window maximums.",
                'time_limit' => 2000, 'memory_limit' => 256, 'tags' => ['arrays', 'sliding-window'],
                'test_cases' => [
                    ['input' => "8\n1 3 -1 -3 5 3 6 7\n3", 'expected_output' => "3 3 5 5 6 7", 'is_hidden' => false],
                    ['input' => "1\n1\n1", 'expected_output' => "1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Longest Consecutive Sequence',
                'slug' => 'longest-consecutive-sequence',
                'description' => "Given an unsorted array of integers `nums`, return the length of the longest consecutive elements sequence in O(n) complexity.",
                'difficulty' => 'hard',
                'constraints' => "0 <= nums.length <= 10^5",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print the length of the longest consecutive sequence.",
                'time_limit' => 1500, 'memory_limit' => 256, 'tags' => ['arrays', 'sorting'],
                'test_cases' => [
                    ['input' => "6\n100 4 200 1 3 2", 'expected_output' => "4", 'is_hidden' => false],
                    ['input' => "10\n0 3 7 2 5 8 4 6 0 1", 'expected_output' => "9", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Smallest Range Covering Elements from K Lists',
                'slug' => 'smallest-range-covering-elements-from-k-lists',
                'description' => "You have `k` lists of sorted integers in non-decreasing order. Find the smallest range `[a, b]` that includes at least one number from each of the `k` lists.",
                'difficulty' => 'hard',
                'constraints' => "1 <= k <= 3500",
                'input_format' => "First line: K. Next K blocks: First line size S, second line contains S space-separated sorted integers.",
                'output_format' => "Print two space-separated integers representing range boundary a and b.",
                'time_limit' => 2000, 'memory_limit' => 256, 'tags' => ['two-pointers', 'sorting'],
                'test_cases' => [
                    ['input' => "3\n4\n4 10 15 24\n4\n0 9 12 20\n4\n5 18 22 30", 'expected_output' => "20 24", 'is_hidden' => false],
                    ['input' => "3\n3\n1 2 3\n3\n1 2 3\n3\n1 2 3", 'expected_output' => "1 1", 'is_hidden' => true]
                ]
            ],
            [
                'title' => 'Find Median from Data Stream',
                'slug' => 'find-median-from-data-stream',
                'description' => "The median is the middle value in an ordered integer list. Implement a structure to calculate the median from a stream of numbers.",
                'difficulty' => 'hard',
                'constraints' => "numbers count <= 50000",
                'input_format' => "First line: N. Second line: N space-separated integers.",
                'output_format' => "Print the final median as a float value.",
                'time_limit' => 1500, 'memory_limit' => 256, 'tags' => ['sorting'],
                'test_cases' => [
                    ['input' => "3\n1 2 3", 'expected_output' => "2.0", 'is_hidden' => false],
                    ['input' => "4\n1 2 3 4", 'expected_output' => "2.5", 'is_hidden' => true]
                ]
            ]
        ];

        // 5. Seed all Problems & their Test Cases
        foreach ($problemsData as $prob) {
            $problem = Problem::create([
                'title' => $prob['title'],
                'slug' => $prob['slug'],
                'description' => $prob['description'],
                'difficulty' => $prob['difficulty'],
                'constraints' => $prob['constraints'],
                'input_format' => $prob['input_format'],
                'output_format' => $prob['output_format'],
                'time_limit' => $prob['time_limit'],
                'memory_limit' => $prob['memory_limit']
            ]);

            // Sync Tags
            $tagIds = [];
            foreach ($prob['tags'] as $tagSlug) {
                if (isset($tagMap[$tagSlug])) {
                    $tagIds[] = $tagMap[$tagSlug]->id;
                }
            }
            $problem->tags()->sync($tagIds);

            // Create Test Cases
            foreach ($prob['test_cases'] as $tc) {
                TestCase::create([
                    'problem_id' => $problem->id,
                    'input' => $tc['input'],
                    'expected_output' => $tc['expected_output'],
                    'is_hidden' => $tc['is_hidden']
                ]);
            }
        }

        // 6. Create Contests
        // Active Weekly Contest (running now)
        $contest1 = Contest::create([
            'title' => 'Weekly CodeSolve Challenge #1',
            'slug' => 'weekly-codesolve-challenge-1',
            'description' => 'Welcome to the first weekly competitive coding round on CodeSolve! Solve the problems as fast as possible to rank high on the contest leaderboard.',
            'start_time' => Carbon::now()->subHour(),
            'end_time' => Carbon::now()->addHours(2),
        ]);
        
        $p1 = Problem::where('slug', 'two-sum')->first();
        $p2 = Problem::where('slug', 'reverse-string')->first();
        if ($p1 && $p2) {
            $contest1->problems()->attach([
                $p1->id => ['points' => 100],
                $p2->id => ['points' => 100]
            ]);
        }

        // Upcoming Contest
        $contest2 = Contest::create([
            'title' => 'Grand Coding Championship 2026',
            'slug' => 'grand-coding-championship-2026',
            'description' => 'The flagship algorithm competition featuring challenging problem sets from Graph Theory, Dynamic Programming, and advanced Data Structures.',
            'start_time' => Carbon::now()->addDays(2),
            'end_time' => Carbon::now()->addDays(2)->addHours(4),
        ]);
        
        $p3 = Problem::where('slug', 'fibonacci-number')->first();
        $p4 = Problem::where('slug', 'add-two-numbers')->first();
        if ($p3 && $p4) {
            $contest2->problems()->attach([
                $p3->id => ['points' => 100],
                $p4->id => ['points' => 200]
            ]);
        }

        // --- NEW REQ: 2 Daily Contests ---
        $daily1 = Contest::create([
            'title' => 'Daily Coding Challenge #1',
            'slug' => 'daily-coding-challenge-1',
            'description' => 'Sharpen your coding skills every day with our quick daily rounds. Solve 2 problems in 4 hours!',
            'start_time' => Carbon::now()->subHours(2),
            'end_time' => Carbon::now()->addHours(2),
        ]);

        $p_ts = Problem::where('slug', 'two-sum')->first();
        $p_fib = Problem::where('slug', 'fibonacci-number')->first();
        if ($p_ts && $p_fib) {
            $daily1->problems()->attach([
                $p_ts->id => ['points' => 100],
                $p_fib->id => ['points' => 100]
            ]);
        }

        $daily2 = Contest::create([
            'title' => 'Daily Coding Challenge #2',
            'slug' => 'daily-coding-challenge-2',
            'description' => 'Challenge yourself daily! Quick problems to practice implementation speed and runtime optimizations.',
            'start_time' => Carbon::now()->subHours(1),
            'end_time' => Carbon::now()->addHours(3),
        ]);

        $p_rev = Problem::where('slug', 'reverse-string')->first();
        $p_pal = Problem::where('slug', 'palindrome-number')->first();
        if ($p_rev && $p_pal) {
            $daily2->problems()->attach([
                $p_rev->id => ['points' => 100],
                $p_pal->id => ['points' => 100]
            ]);
        }

        // --- NEW REQ: 2 Testing Participants ---
        $contestant1 = User::create([
            'name' => 'Contestant One',
            'email' => 'contestant1@codesolve.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
            'points' => 10,
        ]);

        $contestant2 = User::create([
            'name' => 'Contestant Two',
            'email' => 'contestant2@codesolve.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
            'points' => 20,
        ]);

        // Contest submissions for Contestant One
        if ($p_ts && $p_fib) {
            // Solve two-sum accepted
            \App\Models\Submission::create([
                'user_id' => $contestant1->id,
                'problem_id' => $p_ts->id,
                'contest_id' => $daily1->id,
                'language' => 'python',
                'code' => '# Contestant One Two Sum solution',
                'status' => 'Accepted',
                'execution_time' => 45,
                'memory_used' => 2048,
                'created_at' => Carbon::now()->subHours(1)->subMinutes(30),
            ]);

            // Attempt fibonacci wrong answer
            \App\Models\Submission::create([
                'user_id' => $contestant1->id,
                'problem_id' => $p_fib->id,
                'contest_id' => $daily1->id,
                'language' => 'python',
                'code' => '# Contestant One Fib attempt',
                'status' => 'Wrong Answer',
                'execution_time' => 30,
                'memory_used' => 1024,
                'created_at' => Carbon::now()->subHours(1)->subMinutes(15),
            ]);
        }

        if ($p_rev) {
            // Solve reverse-string accepted
            \App\Models\Submission::create([
                'user_id' => $contestant1->id,
                'problem_id' => $p_rev->id,
                'contest_id' => $daily2->id,
                'language' => 'python',
                'code' => '# Contestant One Reverse solution',
                'status' => 'Accepted',
                'execution_time' => 25,
                'memory_used' => 1024,
                'created_at' => Carbon::now()->subMinutes(45),
            ]);
        }

        // Contest submissions for Contestant Two
        if ($p_ts) {
            \App\Models\Submission::create([
                'user_id' => $contestant2->id,
                'problem_id' => $p_ts->id,
                'contest_id' => $daily1->id,
                'language' => 'javascript',
                'code' => '// Contestant Two Two Sum solution',
                'status' => 'Accepted',
                'execution_time' => 35,
                'memory_used' => 4096,
                'created_at' => Carbon::now()->subHours(1)->subMinutes(10),
            ]);
        }

        if ($p_rev && $p_pal) {
            \App\Models\Submission::create([
                'user_id' => $contestant2->id,
                'problem_id' => $p_rev->id,
                'contest_id' => $daily2->id,
                'language' => 'javascript',
                'code' => '// Contestant Two Reverse solution',
                'status' => 'Accepted',
                'execution_time' => 20,
                'memory_used' => 2048,
                'created_at' => Carbon::now()->subMinutes(50),
            ]);

            \App\Models\Submission::create([
                'user_id' => $contestant2->id,
                'problem_id' => $p_pal->id,
                'contest_id' => $daily2->id,
                'language' => 'javascript',
                'code' => '// Contestant Two Palindrome solution',
                'status' => 'Accepted',
                'execution_time' => 55,
                'memory_used' => 2048,
                'created_at' => Carbon::now()->subMinutes(30),
            ]);
        }

        // --- NEW REQ: 3 Testing Code Solvers with Badges & Certificates ---
        $alice = User::create([
            'name' => 'Alice Coder',
            'email' => 'alice@codesolve.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
            'points' => 150,
            'streak' => 3,
            'last_submission_at' => now()->subDay(),
        ]);

        $bob = User::create([
            'name' => 'Bob Programmer',
            'email' => 'bob@codesolve.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
            'points' => 550,
            'streak' => 5,
            'last_submission_at' => now()->subDay(),
        ]);

        $charlie = User::create([
            'name' => 'Charlie Hacker',
            'email' => 'charlie@codesolve.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
            'points' => 20,
            'streak' => 1,
            'last_submission_at' => now()->subDay(),
        ]);

        // Attach Badges
        $badge1 = Badge::where('name', 'First Blood')->first();
        $badge2 = Badge::where('name', 'Streak Starter')->first();
        $badge3 = Badge::where('name', 'Code Cadet')->first();
        $badge4 = Badge::where('name', 'Algorithm Knight')->first();

        if ($badge1) {
            $alice->badges()->attach($badge1->id);
            $bob->badges()->attach($badge1->id);
            $charlie->badges()->attach($badge1->id);
        }
        if ($badge2 && $badge3) {
            $alice->badges()->attach([$badge2->id, $badge3->id]);
            $bob->badges()->attach([$badge2->id, $badge3->id]);
        }
        if ($badge4) {
            $bob->badges()->attach($badge4->id);
        }

        // Create Solved Problem Submissions for Alice (6 problems)
        $aliceProblems = ['two-sum', 'reverse-string', 'fibonacci-number', 'palindrome-number', 'fizz-buzz', 'valid-parentheses'];
        foreach ($aliceProblems as $slug) {
            $prob = Problem::where('slug', $slug)->first();
            if ($prob) {
                \App\Models\Submission::create([
                    'user_id' => $alice->id,
                    'problem_id' => $prob->id,
                    'language' => 'python',
                    'code' => '# Alice solution for ' . $slug,
                    'status' => 'Accepted',
                    'execution_time' => rand(15, 80),
                    'memory_used' => rand(1024, 4096),
                    'created_at' => Carbon::now()->subDays(2),
                ]);
            }
        }

        // Create Solved Problem Submissions for Bob (12 problems)
        $bobProblems = [
            'two-sum', 'reverse-string', 'fibonacci-number', 'palindrome-number', 'fizz-buzz', 'valid-parentheses',
            'merge-two-sorted-lists', 'add-two-numbers', 'length-of-last-word', 'plus-one', 'climbing-stairs', 'merge-sorted-array'
        ];
        foreach ($bobProblems as $slug) {
            $prob = Problem::where('slug', $slug)->first();
            if ($prob) {
                \App\Models\Submission::create([
                    'user_id' => $bob->id,
                    'problem_id' => $prob->id,
                    'language' => 'cpp',
                    'code' => '// Bob solution for ' . $slug,
                    'status' => 'Accepted',
                    'execution_time' => rand(15, 80),
                    'memory_used' => rand(1024, 4096),
                    'created_at' => Carbon::now()->subDays(3),
                ]);
            }
        }

        // Create Solved Problem Submissions for Charlie (2 problems)
        $charlieProblems = ['two-sum', 'reverse-string'];
        foreach ($charlieProblems as $slug) {
            $prob = Problem::where('slug', $slug)->first();
            if ($prob) {
                \App\Models\Submission::create([
                    'user_id' => $charlie->id,
                    'problem_id' => $prob->id,
                    'language' => 'javascript',
                    'code' => '// Charlie solution for ' . $slug,
                    'status' => 'Accepted',
                    'execution_time' => rand(15, 80),
                    'memory_used' => rand(1024, 4096),
                    'created_at' => Carbon::now()->subDays(1),
                ]);
            }
        }
    }
}
