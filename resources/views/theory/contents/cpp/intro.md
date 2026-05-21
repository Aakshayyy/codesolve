# Introduction to C++

C++ is a powerful, high-performance, general-purpose programming language developed by **Bjarne Stroustrup** at Bell Labs in 1979 as an extension of the C language. It is widely used in competitive programming, game development, operating systems, and high-frequency trading.

## Why C++ for Competitive Programming?
C++ is the preferred language of competitive coders due to:
* **Speed**: C++ compiles directly to machine code, making it extremely fast.
* **Standard Template Library (STL)**: Offers rich container classes (Vectors, Sets, Maps, Queues) and built-in algorithms (Sorting, Binary Search).
* **Low-level Control**: Provides pointers and manual memory management for custom optimizations.

---

## Basic Structure of a C++ Program
Here is the standard "Hello World" template in C++:

```cpp
#include <iostream> // Preprocessor directive for input/output stream

// Execution starts at main()
int main() {
    // Standard character output
    std::cout << "Hello, CodeSolve!" << std::endl;
    return 0; // Indicating execution completed successfully
}
```

## Standard Input & Output
In competitive programming, you can optimize input/output speed by adding standard optimizations in the entry point:

```cpp
#include <iostream>
using namespace std;

int main() {
    // IO Optimization
    ios_base::sync_with_stdio(false);
    cin.tie(NULL);

    int n;
    cin >> n; // Read input
    cout << "Input received: " << n << "\n"; // Fast output
    return 0;
}
```
