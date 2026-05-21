# Pointers & References in C++

Pointers and references allow you to manipulate memory addresses directly. This is a core feature of C++ that enables high-performance data structures.

## 1. Pointers
A pointer is a variable that stores the memory address of another variable.
* Use `&` (Address-of operator) to get the address.
* Use `*` (Dereference operator) to access the value at an address.

```cpp
#include <iostream>
using namespace std;

int main() {
    int val = 10;
    int* ptr = &val; // ptr stores address of val

    cout << "Address: " << ptr << "\n";
    cout << "Value: " << *ptr << "\n"; // Dereference ptr to get 10
    
    *ptr = 20; // Change value directly in memory
    cout << "New Value: " << val << "\n"; // Output: 20
    return 0;
}
```

## 2. References
A reference is an alias for an existing variable. Once initialized, it cannot be changed to reference another variable.

```cpp
int main() {
    int x = 5;
    int& ref = x; // ref is an alias of x

    ref = 10; // changes x to 10
    cout << x << "\n"; // Output: 10
}
```

## Passing Parameters to Functions
* **Pass by Value**: Copies the argument. Modifying the parameter inside the function doesn't affect the caller.
* **Pass by Reference / Pointer**: Modifies the original argument directly. Recommended for passing large structures like `std::vector` to avoid copying overhead.

```cpp
// Fast and memory-efficient via reference
void update(vector<int>& vec) {
    vec.push_back(100);
}
```
