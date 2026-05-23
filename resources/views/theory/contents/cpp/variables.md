# C++ Variables & Data Types

Variables are containers for storing data values. In C++, every variable has a specific type, which determines the size and layout of the variable's memory.

---

## Declaring (Creating) Variables

To create a variable, specify the type and assign it a value:

```cpp
type variableName = value;
```

### Example:
```cpp
#include <iostream>
using namespace std;

int main() {
    int myNum = 15;            // Integer (whole number)
    double myFloatNum = 5.99;  // Floating point number
    char myLetter = 'D';       // Character
    string myText = "Hello";   // String
    bool myBoolean = true;     // Boolean (true or false)

    cout << myNum << "\n";
    cout << myFloatNum << "\n";
    cout << myLetter << "\n";
    cout << myText << "\n";
    cout << myBoolean << "\n"; // Prints 1 for true, 0 for false
    return 0;
}
```

---

## Basic Data Types & Sizes

C++ offers a rich set of data types. Here is a comparison of their typical sizes and ranges:

| Data Type | Size (Bytes) | Description | Example |
| :--- | :--- | :--- | :--- |
| `int` | 4 bytes | Stores whole numbers from -2,147,483,648 to 2,147,483,647 | `int x = 50;` |
| `float` | 4 bytes | Stores fractional numbers. Sufficient for 6-7 decimal digits | `float y = 3.14f;` |
| `double` | 8 bytes | Stores fractional numbers. Sufficient for 15 decimal digits | `double z = 3.14159;` |
| `char` | 1 byte | Stores a single character/letter/ASCII value | `char letter = 'A';` |
| `bool` | 1 byte | Stores true or false values | `bool isCoding = true;` |
| `string` | Dynamic | Stores a sequence of characters | `string name = "John";` |

---

## Type Modifiers

Modifiers are used to alter the meaning of the base data types to fit various situations:
- `signed`: Can store both positive and negative values (default).
- `unsigned`: Can store only positive values (doubles the positive range).
- `short`: Decreases the storage size of integers (usually 2 bytes).
- `long`: Increases the storage size of integers (usually 8 bytes on 64-bit platforms).

### Examples:
```cpp
unsigned int positiveOnly = 4000000000;
long long veryLargeInteger = 9223372036854775807LL;
```

---

## Constants (const)

If you don't want others (or yourself) to override existing variable values, use the `const` keyword. This will declare the variable as "constant", which means unchangeable and read-only:

```cpp
#include <iostream>
using namespace std;

int main() {
    const int minutesPerHour = 60;
    const double PI = 3.14159;

    // minutesPerHour = 59; // Error! expression must be a modifiable lvalue

    cout << minutesPerHour << "\n";
    cout << PI << "\n";
    return 0;
}
```

---

## Type Casting

Type casting is converting a variable from one data type to another.

### Implicit Conversion (Automatic)
Done automatically by the compiler:
```cpp
double myDouble = 9; // Converts int 9 to double 9.0 automatically
```

### Explicit Conversion (Manual)
Done manually by the programmer using casting operators:
```cpp
#include <iostream>
using namespace std;

int main() {
    double myDouble = 9.87;
    
    // C-Style cast
    int myInt1 = (int)myDouble; 
    
    // C++ Style static_cast (Recommended)
    int myInt2 = static_cast<int>(myDouble); 

    cout << myInt1 << "\n"; // Outputs: 9
    cout << myInt2 << "\n"; // Outputs: 9
    return 0;
}
```
