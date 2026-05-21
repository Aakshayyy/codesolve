<?php

return [
    // --- EASY PROBLEMS ---
    'two-sum' => [
        'method' => 'twoSum',
        'return' => 'array_int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int'],
            ['name' => 'target', 'type' => 'int']
        ]
    ],
    'reverse-string' => [
        'method' => 'reverseString',
        'return' => 'string',
        'params' => [
            ['name' => 's', 'type' => 'string']
        ]
    ],
    'fibonacci-number' => [
        'method' => 'fib',
        'return' => 'int',
        'params' => [
            ['name' => 'n', 'type' => 'int']
        ]
    ],
    'palindrome-number' => [
        'method' => 'isPalindrome',
        'return' => 'bool',
        'params' => [
            ['name' => 'x', 'type' => 'int']
        ]
    ],
    'fizz-buzz' => [
        'method' => 'fizzBuzz',
        'return' => 'array_string',
        'params' => [
            ['name' => 'n', 'type' => 'int']
        ]
    ],
    'valid-parentheses' => [
        'method' => 'isValid',
        'return' => 'bool',
        'params' => [
            ['name' => 's', 'type' => 'string']
        ]
    ],
    'merge-two-sorted-lists' => [
        'method' => 'merge',
        'return' => 'array_int',
        'params' => [
            ['name' => 'nums1', 'type' => 'array_int'],
            ['name' => 'nums2', 'type' => 'array_int']
        ]
    ],
    'remove-duplicates-from-sorted-array' => [
        'method' => 'removeDuplicates',
        'return' => 'in_place_array_count', // Special return handler: prints count, then unique elements
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'power-of-two' => [
        'method' => 'isPowerOfTwo',
        'return' => 'bool',
        'params' => [
            ['name' => 'n', 'type' => 'int']
        ]
    ],
    'single-number' => [
        'method' => 'singleNumber',
        'return' => 'int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'valid-anagram' => [
        'method' => 'isAnagram',
        'return' => 'bool',
        'params' => [
            ['name' => 's', 'type' => 'string'],
            ['name' => 't', 'type' => 'string']
        ]
    ],
    'contains-duplicate' => [
        'method' => 'containsDuplicate',
        'return' => 'bool',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'majority-element' => [
        'method' => 'majorityElement',
        'return' => 'int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'move-zeroes' => [
        'method' => 'moveZeroes',
        'return' => 'array_int', // Returns modified/new array
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'intersection-of-two-arrays' => [
        'method' => 'intersection',
        'return' => 'array_int',
        'params' => [
            ['name' => 'nums1', 'type' => 'array_int'],
            ['name' => 'nums2', 'type' => 'array_int']
        ]
    ],
    'binary-search' => [
        'method' => 'search',
        'return' => 'int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int'],
            ['name' => 'target', 'type' => 'int']
        ]
    ],
    'first-bad-version' => [
        'method' => 'firstBadVersion',
        'return' => 'int',
        'params' => [
            ['name' => 'n', 'type' => 'int'],
            ['name' => 'bad', 'type' => 'int']
        ]
    ],
    'climbing-stairs' => [
        'method' => 'climbStairs',
        'return' => 'int',
        'params' => [
            ['name' => 'n', 'type' => 'int']
        ]
    ],
    'sqrt-x' => [
        'method' => 'mySqrt',
        'return' => 'int',
        'params' => [
            ['name' => 'x', 'type' => 'int']
        ]
    ],
    'length-of-last-word' => [
        'method' => 'lengthOfLastWord',
        'return' => 'int',
        'params' => [
            ['name' => 's', 'type' => 'string_line']
        ]
    ],
    'plus-one' => [
        'method' => 'plusOne',
        'return' => 'array_int',
        'params' => [
            ['name' => 'digits', 'type' => 'array_int']
        ]
    ],
    'pascals-triangle' => [
        'method' => 'generate',
        'return' => 'matrix_int',
        'params' => [
            ['name' => 'numRows', 'type' => 'int']
        ]
    ],
    'search-insert-position' => [
        'method' => 'searchInsert',
        'return' => 'int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int'],
            ['name' => 'target', 'type' => 'int']
        ]
    ],

    // --- MEDIUM PROBLEMS ---
    'add-two-numbers' => [
        'method' => 'addTwoNumbers',
        'return' => 'int',
        'params' => [
            ['name' => 'a', 'type' => 'int'],
            ['name' => 'b', 'type' => 'int']
        ]
    ],
    'three-sum' => [
        'method' => 'threeSum',
        'return' => 'matrix_int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'longest-substring-without-repeating-characters' => [
        'method' => 'lengthOfLongestSubstring',
        'return' => 'int',
        'params' => [
            ['name' => 's', 'type' => 'string']
        ]
    ],
    'container-with-most-water' => [
        'method' => 'maxArea',
        'return' => 'int',
        'params' => [
            ['name' => 'height', 'type' => 'array_int']
        ]
    ],
    'string-to-integer-atoi' => [
        'method' => 'myAtoi',
        'return' => 'int',
        'params' => [
            ['name' => 's', 'type' => 'string_line']
        ]
    ],
    'three-sum-closest' => [
        'method' => 'threeSumClosest',
        'return' => 'int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int'],
            ['name' => 'target', 'type' => 'int']
        ]
    ],
    'generate-parentheses' => [
        'method' => 'generateParenthesis',
        'return' => 'array_string',
        'params' => [
            ['name' => 'n', 'type' => 'int']
        ]
    ],
    'rotate-image' => [
        'method' => 'rotate',
        'return' => 'in_place_matrix_int', // Special return handler: rotates matrix in-place and prints it
        'params' => [
            ['name' => 'matrix', 'type' => 'square_matrix_int']
        ]
    ],
    'group-anagrams' => [
        'method' => 'groupAnagrams',
        'return' => 'matrix_string',
        'params' => [
            ['name' => 'strs', 'type' => 'array_string']
        ]
    ],
    'unique-paths' => [
        'method' => 'uniquePaths',
        'return' => 'int',
        'params' => [
            ['name' => 'm', 'type' => 'int'],
            ['name' => 'n', 'type' => 'int']
        ]
    ],
    'coin-change' => [
        'method' => 'coinChange',
        'return' => 'int',
        'params' => [
            ['name' => 'coins', 'type' => 'array_int'],
            ['name' => 'amount', 'type' => 'int']
        ]
    ],
    'longest-common-subsequence' => [
        'method' => 'longestCommonSubsequence',
        'return' => 'int',
        'params' => [
            ['name' => 'text1', 'type' => 'string'],
            ['name' => 'text2', 'type' => 'string']
        ]
    ],
    'course-schedule' => [
        'method' => 'canFinish',
        'return' => 'bool',
        'params' => [
            ['name' => 'numCourses', 'type' => 'int'],
            ['name' => 'prerequisites', 'type' => 'matrix_int_pairs']
        ]
    ],
    'product-of-array-except-self' => [
        'method' => 'productExceptSelf',
        'return' => 'array_int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'subarray-sum-equals-k' => [
        'method' => 'subarraySum',
        'return' => 'int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int'],
            ['name' => 'k', 'type' => 'int']
        ]
    ],
    'find-first-and-last-position-of-element-in-sorted-array' => [
        'method' => 'searchRange',
        'return' => 'array_int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int'],
            ['name' => 'target', 'type' => 'int']
        ]
    ],

    // --- HARD PROBLEMS ---
    'median-of-two-sorted-arrays' => [
        'method' => 'findMedianSortedArrays',
        'return' => 'double',
        'params' => [
            ['name' => 'nums1', 'type' => 'array_int'],
            ['name' => 'nums2', 'type' => 'array_int']
        ]
    ],
    'regular-expression-matching' => [
        'method' => 'isMatch',
        'return' => 'bool',
        'params' => [
            ['name' => 's', 'type' => 'string'],
            ['name' => 'p', 'type' => 'string']
        ]
    ],
    'merge-k-sorted-lists' => [
        'method' => 'mergeKLists',
        'return' => 'array_int',
        'params' => [
            ['name' => 'lists', 'type' => 'matrix_int_blocks']
        ]
    ],
    'reverse-nodes-in-k-group' => [
        'method' => 'reverseKGroup',
        'return' => 'array_int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int'],
            ['name' => 'k', 'type' => 'int']
        ]
    ],
    'first-missing-positive' => [
        'method' => 'firstMissingPositive',
        'return' => 'int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'trapping-rain-water' => [
        'method' => 'trap',
        'return' => 'int',
        'params' => [
            ['name' => 'height', 'type' => 'array_int']
        ]
    ],
    'n-queens' => [
        'method' => 'solveNQueens',
        'return' => 'int',
        'params' => [
            ['name' => 'n', 'type' => 'int']
        ]
    ],
    'edit-distance' => [
        'method' => 'minDistance',
        'return' => 'int',
        'params' => [
            ['name' => 'word1', 'type' => 'string'],
            ['name' => 'word2', 'type' => 'string']
        ]
    ],
    'maximal-rectangle' => [
        'method' => 'maximalRectangle',
        'return' => 'int',
        'params' => [
            ['name' => 'matrix', 'type' => 'matrix_int']
        ]
    ],
    'binary-tree-maximum-path-sum' => [
        'method' => 'maxPathSum',
        'return' => 'int',
        'params' => [
            ['name' => 'nodes', 'type' => 'array_int']
        ]
    ],
    'word-ladder' => [
        'method' => 'ladderLength',
        'return' => 'int',
        'params' => [
            ['name' => 'beginWord', 'type' => 'string'],
            ['name' => 'endWord', 'type' => 'string'],
            ['name' => 'wordList', 'type' => 'array_string']
        ]
    ],
    'sliding-window-maximum' => [
        'method' => 'maxSlidingWindow',
        'return' => 'array_int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int'],
            ['name' => 'k', 'type' => 'int']
        ]
    ],
    'longest-consecutive-sequence' => [
        'method' => 'longestConsecutive',
        'return' => 'int',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
    'smallest-range-covering-elements-from-k-lists' => [
        'method' => 'smallestRange',
        'return' => 'array_int',
        'params' => [
            ['name' => 'lists', 'type' => 'matrix_int_blocks']
        ]
    ],
    'find-median-from-data-stream' => [
        'method' => 'findMedian',
        'return' => 'double',
        'params' => [
            ['name' => 'nums', 'type' => 'array_int']
        ]
    ],
];
