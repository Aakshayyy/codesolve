<?php

namespace App\Services;

use App\Models\Problem;
use Illuminate\Support\Str;

class SignatureService
{
    /**
     * Get the signature configuration for a problem.
     */
    public static function getSignature(Problem $problem): ?array
    {
        $signatures = config('signatures');
        return $signatures[$problem->slug] ?? null;
    }

    /**
     * Generate starter templates for Monaco Editor for a problem.
     */
    public static function generateStarterCodes(Problem $problem, array $defaultFallbacks): array
    {
        $sig = self::getSignature($problem);
        if (!$sig) {
            return $defaultFallbacks;
        }

        $methodName = $sig['method'];
        $params = $sig['params'];
        $returnType = $sig['return'];

        return [
            'cpp' => self::generateCppStarter($methodName, $params, $returnType),
            'java' => self::generateJavaStarter($methodName, $params, $returnType),
            'python' => self::generatePythonStarter($methodName, $params, $returnType),
            'javascript' => self::generateJsStarter($methodName, $params, $returnType),
        ];
    }

    /**
     * Wrap user's Solution class with a driver wrapper that handles I/O parsing.
     */
    public static function wrapWithDriver(Problem $problem, string $language, string $userCode): string
    {
        $sig = self::getSignature($problem);
        if (!$sig) {
            return $userCode; // Fallback
        }

        switch ($language) {
            case 'cpp':
                return self::wrapCpp($sig, $userCode);
            case 'java':
                return self::wrapJava($sig, $userCode);
            case 'python':
                return self::wrapPython($sig, $userCode);
            case 'javascript':
                return self::wrapJs($sig, $userCode);
            default:
                return $userCode;
        }
    }

    // --- C++ STARTER GENERATOR ---
    private static function generateCppStarter(string $method, array $params, string $return): string
    {
        $cppParams = [];
        foreach ($params as $p) {
            $cppParams[] = self::mapCppType($p['type']) . ' ' . $p['name'];
        }
        $paramStr = implode(', ', $cppParams);
        $retType = self::mapCppType($return, true);

        return "#include <iostream>\n#include <vector>\n#include <string>\n\nusing namespace std;\n\nclass Solution {\npublic:\n    " . $retType . " " . $method . "(" . $paramStr . ") {\n        // Write your code here\n        \n    }\n};";
    }

    private static function mapCppType(string $type, bool $isReturn = false): string
    {
        switch ($type) {
            case 'int': return 'int';
            case 'bool': return 'bool';
            case 'double': return 'double';
            case 'string':
            case 'string_line': return 'string';
            case 'array_int': return $isReturn ? 'vector<int>' : 'vector<int>&';
            case 'array_string': return $isReturn ? 'vector<string>' : 'vector<string>&';
            case 'matrix_int':
            case 'matrix_int_pairs':
            case 'square_matrix_int':
            case 'matrix_int_blocks': return $isReturn ? 'vector<vector<int>>' : 'vector<vector<int>>&';
            case 'matrix_string': return $isReturn ? 'vector<vector<string>>' : 'vector<vector<string>>&';
            case 'in_place_array_count': return 'int';
            case 'in_place_matrix_int': return 'void';
            default: return 'void';
        }
    }

    // --- JAVA STARTER GENERATOR ---
    private static function generateJavaStarter(string $method, array $params, string $return): string
    {
        $javaParams = [];
        foreach ($params as $p) {
            $javaParams[] = self::mapJavaType($p['type']) . ' ' . $p['name'];
        }
        $paramStr = implode(', ', $javaParams);
        $retType = self::mapJavaType($return);

        return "import java.util.*;\n\nclass Solution {\n    public " . $retType . " " . $method . "(" . $paramStr . ") {\n        // Write your code here\n        \n    }\n}";
    }

    private static function mapJavaType(string $type): string
    {
        switch ($type) {
            case 'int': return 'int';
            case 'bool': return 'boolean';
            case 'double': return 'double';
            case 'string':
            case 'string_line': return 'String';
            case 'array_int': return 'int[]';
            case 'array_string': return 'String[]';
            case 'matrix_int':
            case 'matrix_int_pairs':
            case 'square_matrix_int':
            case 'matrix_int_blocks': return 'int[][]';
            case 'matrix_string': return 'String[][]';
            case 'in_place_array_count': return 'int';
            case 'in_place_matrix_int': return 'void';
            default: return 'void';
        }
    }

    // --- PYTHON STARTER GENERATOR ---
    private static function generatePythonStarter(string $method, array $params, string $return): string
    {
        $pyParams = ['self'];
        foreach ($params as $p) {
            $pyParams[] = $p['name'] . ': ' . self::mapPythonType($p['type']);
        }
        $paramStr = implode(', ', $pyParams);
        $retType = self::mapPythonType($return);

        return "from typing import List\n\nclass Solution:\n    def " . $method . "(" . $paramStr . ") -> " . $retType . ":\n        # Write your code here\n        pass";
    }

    private static function mapPythonType(string $type): string
    {
        switch ($type) {
            case 'int': return 'int';
            case 'bool': return 'bool';
            case 'double': return 'float';
            case 'string':
            case 'string_line': return 'str';
            case 'array_int': return 'List[int]';
            case 'array_string': return 'List[str]';
            case 'matrix_int':
            case 'matrix_int_pairs':
            case 'square_matrix_int':
            case 'matrix_int_blocks': return 'List[List[int]]';
            case 'matrix_string': return 'List[List[str]]';
            case 'in_place_array_count': return 'int';
            case 'in_place_matrix_int': return 'None';
            default: return 'None';
        }
    }

    // --- JS STARTER GENERATOR ---
    private static function generateJsStarter(string $method, array $params, string $return): string
    {
        $jsParams = [];
        $docParams = [];
        foreach ($params as $p) {
            $jsParams[] = $p['name'];
            $docParams[] = "     * @param {" . self::mapJsType($p['type']) . "} " . $p['name'];
        }
        $paramStr = implode(', ', $jsParams);
        $retType = self::mapJsType($return);

        return "class Solution {\n    /**\n" . implode("\n", $docParams) . "\n     * @return {" . $retType . "}\n     */\n    " . $method . "(" . $paramStr . ") {\n        // Write your code here\n        \n    }\n}";
    }

    private static function mapJsType(string $type): string
    {
        switch ($type) {
            case 'int': return 'number';
            case 'bool': return 'boolean';
            case 'double': return 'number';
            case 'string':
            case 'string_line': return 'string';
            case 'array_int': return 'number[]';
            case 'array_string': return 'string[]';
            case 'matrix_int':
            case 'matrix_int_pairs':
            case 'square_matrix_int':
            case 'matrix_int_blocks': return 'number[][]';
            case 'matrix_string': return 'string[][]';
            case 'in_place_array_count': return 'number';
            case 'in_place_matrix_int': return 'void';
            default: return 'void';
        }
    }

    // --- WRAP CPP ---
    private static function wrapCpp(array $sig, string $userCode): string
    {
        $parseCode = "";
        $args = [];
        $hasStringLine = false;

        foreach ($sig['params'] as $p) {
            $name = $p['name'];
            $args[] = $name;

            switch ($p['type']) {
                case 'int':
                    $parseCode .= "    int {$name};\n    if (!(cin >> {$name})) return 0;\n";
                    break;
                case 'double':
                    $parseCode .= "    double {$name};\n    if (!(cin >> {$name})) return 0;\n";
                    break;
                case 'string':
                    $parseCode .= "    string {$name};\n    if (!(cin >> {$name})) return 0;\n";
                    break;
                case 'string_line':
                    $hasStringLine = true;
                    $parseCode .= "    string {$name};\n    cin >> ws;\n    getline(cin, {$name});\n";
                    break;
                case 'array_int':
                    $parseCode .= "    int n_{$name};\n    if (!(cin >> n_{$name})) return 0;\n    vector<int> {$name}(n_{{$name}});\n    for(int i = 0; i < n_{$name}; i++) cin >> {$name}[i];\n";
                    break;
                case 'array_string':
                    $parseCode .= "    int n_{$name};\n    if (!(cin >> n_{$name})) return 0;\n    vector<string> {$name}(n_{{$name}});\n    for(int i = 0; i < n_{$name}; i++) cin >> {$name}[i];\n";
                    break;
                case 'matrix_int_pairs':
                    $parseCode .= "    int n_{$name};\n    if (!(cin >> n_{$name})) return 0;\n    vector<vector<int>> {$name}(n_{{$name}}, vector<int>(2));\n    for(int i = 0; i < n_{$name}; i++) cin >> {$name}[i][0] >> {$name}[i][1];\n";
                    break;
                case 'square_matrix_int':
                    $parseCode .= "    int n_{$name};\n    if (!(cin >> n_{$name})) return 0;\n    vector<vector<int>> {$name}(n_{{$name}}, vector<int>(n_{{$name}}));\n    for(int i = 0; i < n_{$name}; i++) {\n        for(int j = 0; j < n_{$name}; j++) cin >> {$name}[i][j];\n    }\n";
                    break;
                case 'matrix_int':
                    $parseCode .= "    int r_{$name}, c_{$name};\n    if (!(cin >> r_{{$name}} >> c_{{$name}})) return 0;\n    vector<vector<int>> {$name}(r_{{$name}}, vector<int>(c_{{$name}}));\n    for(int i = 0; i < r_{$name}; i++) {\n        for(int j = 0; j < c_{$name}; j++) cin >> {$name}[i][j];\n    }\n";
                    break;
                case 'matrix_int_blocks':
                    $parseCode .= "    int k_{$name};\n    if (!(cin >> k_{$name})) return 0;\n    vector<vector<int>> {$name}(k_{{$name}});\n    for(int i = 0; i < k_{$name}; i++) {\n        int s_{$name};\n        if (!(cin >> s_{{$name}})) return 0;\n        {$name}[i].resize(s_{{$name}});\n        for(int j = 0; j < s_{$name}; j++) cin >> {$name}[i][j];\n    }\n";
                    break;
            }
        }

        $callAndPrint = "";
        $method = $sig['method'];
        $argListStr = implode(', ', $args);

        switch ($sig['return']) {
            case 'int':
            case 'double':
            case 'string':
                $callAndPrint = "    Solution ob;\n    auto ans = ob.{$method}({$argListStr});\n    cout << ans << endl;";
                break;
            case 'bool':
                $callAndPrint = "    Solution ob;\n    auto ans = ob.{$method}({$argListStr});\n    cout << (ans ? \"true\" : \"false\") << endl;";
                break;
            case 'array_int':
            case 'array_string':
                $callAndPrint = "    Solution ob;\n    auto ans = ob.{$method}({$argListStr});\n    for(size_t i = 0; i < ans.size(); i++) cout << ans[i] << (i == ans.size() - 1 ? \"\" : \" \");\n    cout << endl;";
                break;
            case 'matrix_int':
            case 'matrix_string':
                $callAndPrint = "    Solution ob;\n    auto ans = ob.{$method}({$argListStr});\n    for(size_t i = 0; i < ans.size(); i++) {\n        for(size_t j = 0; j < ans[i].size(); j++) cout << ans[i][j] << (j == ans[i].size() - 1 ? \"\" : \" \");\n        cout << endl;\n    }";
                break;
            case 'in_place_array_count':
                $firstParam = $sig['params'][0]['name'];
                $callAndPrint = "    Solution ob;\n    auto ans = ob.{$method}({$argListStr});\n    cout << ans << endl;\n    for(int i = 0; i < ans; i++) cout << {$firstParam}[i] << (i == ans - 1 ? \"\" : \" \");\n    cout << endl;";
                break;
            case 'in_place_matrix_int':
                $firstParam = $sig['params'][0]['name'];
                $callAndPrint = "    Solution ob;\n    ob.{$method}({$argListStr});\n    for(size_t i = 0; i < {$firstParam}.size(); i++) {\n        for(size_t j = 0; j < {$firstParam}[i].size(); j++) cout << {$firstParam}[i][j] << (j == {$firstParam}[i].size() - 1 ? \"\" : \" \");\n        cout << endl;\n    }";
                break;
        }

        return $userCode . "\n\nint main() {\n" . $parseCode . $callAndPrint . "\n    return 0;\n}";
    }

    // --- WRAP JAVA ---
    private static function wrapJava(array $sig, string $userCode): string
    {
        $parseCode = "";
        $args = [];
        $hasStringLine = false;

        foreach ($sig['params'] as $p) {
            $name = $p['name'];
            $args[] = $name;

            switch ($p['type']) {
                case 'int':
                    $parseCode .= "        int {$name} = sc.nextInt();\n";
                    break;
                case 'double':
                    $parseCode .= "        double {$name} = sc.nextDouble();\n";
                    break;
                case 'string':
                    $parseCode .= "        String {$name} = sc.next();\n";
                    break;
                case 'string_line':
                    $hasStringLine = true;
                    $parseCode .= "        if (sc.hasNextLine()) sc.nextLine();\n        String {$name} = sc.hasNextLine() ? sc.nextLine().trim() : \"\";\n";
                    break;
                case 'array_int':
                    $parseCode .= "        int n_{$name} = sc.nextInt();\n        int[] {$name} = new int[n_{{$name}}];\n        for(int i = 0; i < n_{$name}; i++) {$name}[i] = sc.nextInt();\n";
                    break;
                case 'array_string':
                    $parseCode .= "        int n_{$name} = sc.nextInt();\n        String[] {$name} = new String[n_{{$name}}];\n        for(int i = 0; i < n_{$name}; i++) {$name}[i] = sc.next();\n";
                    break;
                case 'matrix_int_pairs':
                    $parseCode .= "        int n_{$name} = sc.nextInt();\n        int[][] {$name} = new int[n_{{$name}}][2];\n        for(int i = 0; i < n_{$name}; i++) {\n            {$name}[i][0] = sc.nextInt();\n            {$name}[i][1] = sc.nextInt();\n        }\n";
                    break;
                case 'square_matrix_int':
                    $parseCode .= "        int n_{$name} = sc.nextInt();\n        int[][] {$name} = new int[n_{{$name}}][n_{{$name}}];\n        for(int i = 0; i < n_{$name}; i++) {\n            for(int j = 0; j < n_{$name}; j++) {$name}[i][j] = sc.nextInt();\n        }\n";
                    break;
                case 'matrix_int':
                    $parseCode .= "        int r_{$name} = sc.nextInt();\n        int c_{$name} = sc.nextInt();\n        int[][] {$name} = new int[r_{{$name}}][c_{{$name}}];\n        for(int i = 0; i < r_{$name}; i++) {\n            for(int j = 0; j < c_{$name}; j++) {$name}[i][j] = sc.nextInt();\n        }\n";
                    break;
                case 'matrix_int_blocks':
                    $parseCode .= "        int k_{$name} = sc.nextInt();\n        int[][] {$name} = new int[k_{{$name}}][];\n        for(int i = 0; i < k_{$name}; i++) {\n            int s_{$name} = sc.nextInt();\n            {$name}[i] = new int[s_{{$name}}];\n            for(int j = 0; j < s_{$name}; j++) {$name}[i][j] = sc.nextInt();\n        }\n";
                    break;
            }
        }

        $callAndPrint = "";
        $method = $sig['method'];
        $argListStr = implode(', ', $args);
        $retType = self::mapJavaType($sig['return']);

        switch ($sig['return']) {
            case 'int':
            case 'double':
            case 'string':
                $callAndPrint = "        Solution ob = new Solution();\n        {$retType} ans = ob.{$method}({$argListStr});\n        System.out.println(ans);";
                break;
            case 'bool':
                $callAndPrint = "        Solution ob = new Solution();\n        boolean ans = ob.{$method}({$argListStr});\n        System.out.println(ans ? \"true\" : \"false\");";
                break;
            case 'array_int':
                $callAndPrint = "        Solution ob = new Solution();\n        int[] ans = ob.{$method}({$argListStr});\n        for(int i = 0; i < ans.length; i++) System.out.print(ans[i] + (i == ans.length - 1 ? \"\" : \" \"));\n        System.out.println();";
                break;
            case 'array_string':
                $callAndPrint = "        Solution ob = new Solution();\n        String[] ans = ob.{$method}({$argListStr});\n        for(int i = 0; i < ans.length; i++) System.out.print(ans[i] + (i == ans.length - 1 ? \"\" : \" \"));\n        System.out.println();";
                break;
            case 'matrix_int':
                $callAndPrint = "        Solution ob = new Solution();\n        int[][] ans = ob.{$method}({$argListStr});\n        for(int i = 0; i < ans.length; i++) {\n            for(int j = 0; j < ans[i].length; j++) System.out.print(ans[i][j] + (j == ans[i].length - 1 ? \"\" : \" \"));\n            System.out.println();\n        }";
                break;
            case 'in_place_array_count':
                $firstParam = $sig['params'][0]['name'];
                $callAndPrint = "        Solution ob = new Solution();\n        int ans = ob.{$method}({$argListStr});\n        System.out.println(ans);\n        for(int i = 0; i < ans; i++) System.out.print({$firstParam}[i] + (i == ans - 1 ? \"\" : \" \"));\n        System.out.println();";
                break;
            case 'in_place_matrix_int':
                $firstParam = $sig['params'][0]['name'];
                $callAndPrint = "        Solution ob = new Solution();\n        ob.{$method}({$argListStr});\n        for(int i = 0; i < {$firstParam}.length; i++) {\n            for(int j = 0; j < {$firstParam}[i].length; j++) System.out.print({$firstParam}[i][j] + (j == {$firstParam}[i].length - 1 ? \"\" : \" \"));\n            System.out.println();\n        }";
                break;
        }

        // We wrap everything in Main.java
        return $userCode . "\n\nimport java.util.*;\n\npublic class Main {\n    public static void main(String[] args) {\n        Scanner sc = new Scanner(System.in);\n" . $parseCode . $callAndPrint . "\n    }\n}";
    }

    // --- WRAP PYTHON ---
    private static function wrapPython(array $sig, string $userCode): string
    {
        $hasStringLine = false;
        foreach ($sig['params'] as $p) {
            if ($p['type'] === 'string_line') {
                $hasStringLine = true;
            }
        }

        $parseCode = "";
        if ($hasStringLine) {
            // For strings with spaces, read the whole stdin
            $firstParam = $sig['params'][0]['name'];
            $parseCode .= "    {$firstParam} = sys.stdin.read().rstrip('\\r\\n')\n";
        } else {
            $parseCode .= "    input_data = sys.stdin.read().split()\n    if not input_data:\n        sys.exit(0)\n    ptr = 0\n";
            foreach ($sig['params'] as $p) {
                $name = $p['name'];
                switch ($p['type']) {
                    case 'int':
                        $parseCode .= "    {$name} = int(input_data[ptr]); ptr += 1\n";
                        break;
                    case 'double':
                        $parseCode .= "    {$name} = float(input_data[ptr]); ptr += 1\n";
                        break;
                    case 'string':
                        $parseCode .= "    {$name} = input_data[ptr]; ptr += 1\n";
                        break;
                    case 'array_int':
                        $parseCode .= "    n_{$name} = int(input_data[ptr]); ptr += 1\n    {$name} = [int(x) for x in input_data[ptr : ptr + n_{$name}]]; ptr += n_{$name}\n";
                        break;
                    case 'array_string':
                        $parseCode .= "    n_{$name} = int(input_data[ptr]); ptr += 1\n    {$name} = input_data[ptr : ptr + n_{$name}]; ptr += n_{$name}\n";
                        break;
                    case 'matrix_int_pairs':
                        $parseCode .= "    n_{$name} = int(input_data[ptr]); ptr += 1\n    {$name} = []\n    for _ in range(n_{$name}):\n        {$name}.append([int(input_data[ptr]), int(input_data[ptr+1])])\n        ptr += 2\n";
                        break;
                    case 'square_matrix_int':
                        $parseCode .= "    n_{$name} = int(input_data[ptr]); ptr += 1\n    {$name} = []\n    for _ in range(n_{$name}):\n        {$name}.append([int(x) for x in input_data[ptr : ptr + n_{$name}]])\n        ptr += n_{$name}\n";
                        break;
                    case 'matrix_int':
                        $parseCode .= "    r_{$name} = int(input_data[ptr]); ptr += 1\n    c_{$name} = int(input_data[ptr]); ptr += 1\n    {$name} = []\n    for _ in range(r_{$name}):\n        {$name}.append([int(x) for x in input_data[ptr : ptr + c_{$name}]])\n        ptr += c_{$name}\n";
                        break;
                    case 'matrix_int_blocks':
                        $parseCode .= "    k_{$name} = int(input_data[ptr]); ptr += 1\n    {$name} = []\n    for _ in range(k_{$name}):\n        s_{$name} = int(input_data[ptr]); ptr += 1\n        {$name}.append([int(x) for x in input_data[ptr : ptr + s_{$name}]])\n        ptr += s_{$name}\n";
                        break;
                }
            }
        }

        $callAndPrint = "";
        $method = $sig['method'];
        $args = [];
        foreach ($sig['params'] as $p) {
            $args[] = $p['name'];
        }
        $argListStr = implode(', ', $args);

        switch ($sig['return']) {
            case 'int':
            case 'double':
            case 'string':
                $callAndPrint = "    ob = Solution()\n    ans = ob.{$method}({$argListStr})\n    print(ans)";
                break;
            case 'bool':
                $callAndPrint = "    ob = Solution()\n    ans = ob.{$method}({$argListStr})\n    print(\"true\" if ans else \"false\")";
                break;
            case 'array_int':
            case 'array_string':
                $callAndPrint = "    ob = Solution()\n    ans = ob.{$method}({$argListStr})\n    print(*(ans))";
                break;
            case 'matrix_int':
            case 'matrix_string':
                $callAndPrint = "    ob = Solution()\n    ans = ob.{$method}({$argListStr})\n    for row in ans:\n        print(*(row))";
                break;
            case 'in_place_array_count':
                $firstParam = $sig['params'][0]['name'];
                $callAndPrint = "    ob = Solution()\n    ans = ob.{$method}({$argListStr})\n    print(ans)\n    print(*( {$firstParam}[:ans] ))";
                break;
            case 'in_place_matrix_int':
                $firstParam = $sig['params'][0]['name'];
                $callAndPrint = "    ob = Solution()\n    ob.{$method}({$argListStr})\n    for row in {$firstParam}:\n        print(*(row))";
                break;
        }

        return $userCode . "\n\nif __name__ == '__main__':\n    import sys\n" . $parseCode . $callAndPrint;
    }

    // --- WRAP JS ---
    private static function wrapJs(array $sig, string $userCode): string
    {
        $hasStringLine = false;
        foreach ($sig['params'] as $p) {
            if ($p['type'] === 'string_line') {
                $hasStringLine = true;
            }
        }

        $parseCode = "";
        if ($hasStringLine) {
            $firstParam = $sig['params'][0]['name'];
            $parseCode .= "    const {$firstParam} = fs.readFileSync(0, 'utf-8').replace(/\\r\\n/g, '\\n').replace(/\\n$/, '');\n";
        } else {
            $parseCode .= "    const input = fs.readFileSync(0, 'utf-8').trim().split(/\\s+/);\n    if (input.length === 0 || input[0] === \"\") process.exit(0);\n    let ptr = 0;\n";
            foreach ($sig['params'] as $p) {
                $name = $p['name'];
                switch ($p['type']) {
                    case 'int':
                        $parseCode .= "    const {$name} = parseInt(input[ptr++]);\n";
                        break;
                    case 'double':
                        $parseCode .= "    const {$name} = parseFloat(input[ptr++]);\n";
                        break;
                    case 'string':
                        $parseCode .= "    const {$name} = input[ptr++];\n";
                        break;
                    case 'array_int':
                        $parseCode .= "    const n_{$name} = parseInt(input[ptr++]);\n    const {$name} = [];\n    for (let i = 0; i < n_{$name}; i++) {$name}.push(parseInt(input[ptr++]));\n";
                        break;
                    case 'array_string':
                        $parseCode .= "    const n_{$name} = parseInt(input[ptr++]);\n    const {$name} = [];\n    for (let i = 0; i < n_{$name}; i++) {$name}.push(input[ptr++]);\n";
                        break;
                    case 'matrix_int_pairs':
                        $parseCode .= "    const n_{$name} = parseInt(input[ptr++]);\n    const {$name} = [];\n    for (let i = 0; i < n_{$name}; i++) {$name}.push([parseInt(input[ptr++]), parseInt(input[ptr++])]);\n";
                        break;
                    case 'square_matrix_int':
                        $parseCode .= "    const n_{$name} = parseInt(input[ptr++]);\n    const {$name} = [];\n    for (let i = 0; i < n_{$name}; i++) {\n        const row = [];\n        for (let j = 0; j < n_{$name}; j++) row.push(parseInt(input[ptr++]));\n        {$name}.push(row);\n    }\n";
                        break;
                    case 'matrix_int':
                        $parseCode .= "    const r_{$name} = parseInt(input[ptr++]);\n    const c_{$name} = parseInt(input[ptr++]);\n    const {$name} = [];\n    for (let i = 0; i < r_{$name}; i++) {\n        const row = [];\n        for (let j = 0; j < c_{$name}; j++) row.push(parseInt(input[ptr++]));\n        {$name}.push(row);\n    }\n";
                        break;
                    case 'matrix_int_blocks':
                        $parseCode .= "    const k_{$name} = parseInt(input[ptr++]);\n    const {$name} = [];\n    for (let i = 0; i < k_{$name}; i++) {\n        const s_{$name} = parseInt(input[ptr++]);\n        const sub = [];\n        for (let j = 0; j < s_{$name}; j++) sub.push(parseInt(input[ptr++]));\n        {$name}.push(sub);\n    }\n";
                        break;
                }
            }
        }

        $callAndPrint = "";
        $method = $sig['method'];
        $args = [];
        foreach ($sig['params'] as $p) {
            $args[] = $p['name'];
        }
        $argListStr = implode(', ', $args);

        switch ($sig['return']) {
            case 'int':
            case 'double':
            case 'string':
                $callAndPrint = "    const ob = new Solution();\n    const ans = ob.{$method}({$argListStr});\n    console.log(ans);";
                break;
            case 'bool':
                $callAndPrint = "    const ob = new Solution();\n    const ans = ob.{$method}({$argListStr});\n    console.log(ans ? \"true\" : \"false\");";
                break;
            case 'array_int':
            case 'array_string':
                $callAndPrint = "    const ob = new Solution();\n    const ans = ob.{$method}({$argListStr});\n    console.log(ans.join(\" \"));";
                break;
            case 'matrix_int':
            case 'matrix_string':
                $callAndPrint = "    const ob = new Solution();\n    const ans = ob.{$method}({$argListStr});\n    for (let i = 0; i < ans.length; i++) console.log(ans[i].join(\" \"));";
                break;
            case 'in_place_array_count':
                $firstParam = $sig['params'][0]['name'];
                $callAndPrint = "    const ob = new Solution();\n    const ans = ob.{$method}({$argListStr});\n    console.log(ans);\n    console.log({$firstParam}.slice(0, ans).join(\" \"));";
                break;
            case 'in_place_matrix_int':
                $firstParam = $sig['params'][0]['name'];
                $callAndPrint = "    const ob = new Solution();\n    ob.{$method}({$argListStr});\n    for (let i = 0; i < {$firstParam}.length; i++) console.log({$firstParam}[i].join(\" \"));";
                break;
        }

        return $userCode . "\n\nconst fs = require('fs');\n\nfunction main() {\n" . $parseCode . $callAndPrint . "\n}\n\nmain();";
    }
}
