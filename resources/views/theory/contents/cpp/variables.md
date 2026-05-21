# Variables & Data Types in C++

A variable is a container to store data values. Each variable in C++ has a specific data type, which dictates its size, layout in memory, and the range of values that can be stored.

## Primitive Data Types
C++ provides several primitive types:

| Type | Size (Bytes) | Range | Common Usage |
| :--- | :--- | :--- | :--- |
| `int` | 4 | $-2 \times 10^9$ to $2 \times 10^9$ | Counting, index variables |
| `long long` | 8 | $-9 \times 10^{18}$ to $9 \times 10^{18}$ | Large counters, sum values |
| `float` | 4 | 7 decimal digits of precision | Single-precision floats |
| `double` | 8 | 15 decimal digits of precision | Standard geometry coordinates |
| `char` | 1 | Single ASCII character | Text processing |
| `bool` | 1 | `true` or `false` | Flags, state indicators |

## Variable Declarations
Variables must be declared with a type before use:

```cpp
#include <iostream>
using namespace std;

int main() {
    int age = 21;
    double pi = 3.14159265;
    char grade = 'A';
    bool isActive = true;

    cout << "Age: " << age << "\n";
    cout << "PI: " << pi << "\n";
    return 0;
}
```

> [!WARNING]
> Integer overflow is a common bug in competitive programming. If a product or sum can exceed $2 \times 10^9$, declare your variables as `long long` instead of `int`.
