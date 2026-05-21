<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TheoryController extends Controller
{
    // Define the categories and their topics
    protected $categories = [
        'cpp' => [
            'name' => 'C++',
            'description' => 'Master competitive programming with C++, from variables and pointers to memory optimization and OOP.',
            'icon' => 'C++',
            'topics' => [
                'intro' => 'Introduction to C++',
                'variables' => 'Variables & Data Types',
                'control-flow' => 'Control Flow (If/Else & Loops)',
                'functions' => 'Functions & Recursion',
                'pointers' => 'Pointers & References',
                'oop' => 'Object-Oriented Programming (OOP)'
            ]
        ],
        'java' => [
            'name' => 'Java',
            'description' => 'Learn Java programming including the JVM architecture, strings, OOP, and the Collections Framework.',
            'icon' => 'Java',
            'topics' => [
                'intro' => 'Introduction to Java (JVM/JDK)',
                'variables' => 'Variables & Data Types',
                'control-flow' => 'Control Flow',
                'arrays-strings' => 'Arrays & Strings',
                'oop' => 'OOP Concepts in Java',
                'collections' => 'Collections Framework'
            ]
        ],
        'dsa' => [
            'name' => 'DSA',
            'description' => 'Build strong algorithmic foundations with Arrays, Linked Lists, Stacks, Trees, Graphs, and Sorting.',
            'icon' => 'DSA',
            'topics' => [
                'complexity' => 'Time & Space Complexity',
                'arrays' => 'Arrays & Multi-Dimensional Arrays',
                'linked-list' => 'Linked Lists (Singly & Doubly)',
                'stack-queue' => 'Stacks & Queues',
                'trees' => 'Trees & BSTs',
                'graphs' => 'Graphs & DFS/BFS',
                'sorting-searching' => 'Sorting & Searching'
            ]
        ]
    ];

    // Map categories and topics to recommended problem slugs
    protected $problemMappings = [
        'cpp/intro' => ['fizz-buzz'],
        'cpp/variables' => ['palindrome-number'],
        'cpp/control-flow' => ['palindrome-number', 'fizz-buzz'],
        'cpp/functions' => ['fibonacci-number'],
        'cpp/pointers' => ['reverse-string'],
        'cpp/oop' => ['single-number'],

        'java/intro' => ['fizz-buzz'],
        'java/variables' => ['palindrome-number'],
        'java/control-flow' => ['palindrome-number'],
        'java/arrays-strings' => ['reverse-string', 'valid-anagram', 'longest-substring-without-repeating-characters'],
        'java/oop' => ['single-number'],
        'java/collections' => ['contains-duplicate', 'two-sum', 'group-anagrams'],

        'dsa/complexity' => ['fibonacci-number'],
        'dsa/arrays' => ['two-sum', 'remove-duplicates-from-sorted-array', 'contains-duplicate', 'rotate-image'],
        'dsa/linked-list' => ['merge-two-sorted-lists', 'add-two-numbers', 'reverse-nodes-in-k-group', 'merge-k-sorted-lists'],
        'dsa/stack-queue' => ['valid-parentheses', 'generate-parentheses'],
        'dsa/trees' => ['binary-tree-maximum-path-sum'],
        'dsa/graphs' => ['course-schedule'],
        'dsa/sorting-searching' => ['binary-search', 'search-insert-position', 'find-first-and-last-position-of-element-in-sorted-array']
    ];

    public function index()
    {
        return view('theory.index', [
            'categories' => $this->categories
        ]);
    }

    public function category($category)
    {
        if (!array_key_exists($category, $this->categories)) {
            abort(404);
        }

        // Redirect to the first topic in the category
        $firstTopic = array_key_first($this->categories[$category]['topics']);
        return redirect()->route('theory.topic', [$category, $firstTopic]);
    }

    public function topic($category, $topic)
    {
        if (!array_key_exists($category, $this->categories)) {
            abort(404);
        }

        $catData = $this->categories[$category];

        if (!array_key_exists($topic, $catData['topics'])) {
            abort(404);
        }

        $topicTitle = $catData['topics'][$topic];

        // Read markdown file from resources/views/theory/contents/{category}/{topic}.md
        $filePath = resource_path("views/theory/contents/{$category}/{$topic}.md");
        
        $markdown = "";
        if (File::exists($filePath)) {
            $markdown = File::get($filePath);
        } else {
            $markdown = "# " . $topicTitle . "\n\nContent for this topic is under development. Please check back soon!";
        }

        // Parse markdown to HTML
        $htmlContent = Str::markdown($markdown);

        // Fetch recommended problems
        $mapKey = "{$category}/{$topic}";
        $problemSlugs = $this->problemMappings[$mapKey] ?? [];
        $recommendedProblems = Problem::whereIn('slug', $problemSlugs)->get();

        return view('theory.show', [
            'categories' => $this->categories,
            'activeCategory' => $category,
            'activeTopic' => $topic,
            'topicTitle' => $topicTitle,
            'htmlContent' => $htmlContent,
            'recommendedProblems' => $recommendedProblems
        ]);
    }
}
