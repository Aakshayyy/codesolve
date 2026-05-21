# Functions & Recursion in C++

A function is a reusable block of statements that performs a dedicated computation. Functions prevent code duplication and segment logic into readable units.

## Declaring and Calling Functions
A function must specify its return type, name, and parameter types:

```cpp
#include <iostream>
using namespace std;

// Function prototype
int add(int a, int b) {
    return a + b;
}

int main() {
    int sum = add(10, 20);
    cout << "Sum: " << sum << "\n"; // Output: 30
    return 0;
}
```

## Recursion
Recursion is when a function calls itself directly or indirectly. Every recursive function must contain a **base case** to terminate execution, preventing infinite loops and Stack Overflow errors.

Here is the recursive implementation of the Fibonacci sequence:

```cpp
#include <iostream>
using namespace std;

int fibonacci(int n) {
    // Base Case
    if (n <= 1) {
        return n;
    }
    // Recursive Case
    return fibonacci(n - 1) + fibonacci(n - 2);
}

int main() {
    int result = fibonacci(6);
    cout << "Fibonacci of 6 is: " << result << "\n"; // Output: 8
    return 0;
}
```
