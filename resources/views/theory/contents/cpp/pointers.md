# C++ Pointers & References

Pointers and references are key features in C++ that allow developers to access and manipulate memory directly, giving C++ its legendary performance and speed.

---

## Memory Addresses

To understand pointers, you must understand memory addresses. When a variable is created in C++, it is assigned a specific memory address.
The address operator (`&`) is used to get the memory address of a variable:

```cpp
#include <iostream>
using namespace std;

int main() {
    string food = "Pizza";
    cout << &food << "\n"; // Outputs something like: 0x7ffe7908b9b0
    return 0;
}
```

---

## Creating Pointers

A pointer is a variable that **stores the memory address** of another variable as its value.
A pointer variable is declared using the asterisk (`*`):

```cpp
#include <iostream>
using namespace std;

int main() {
    string food = "Pizza"; // A food variable of type string
    string* ptr = &food;   // A pointer variable, named ptr, that stores the address of food

    cout << food << "\n";  // Outputs "Pizza"
    cout << &food << "\n"; // Outputs the memory address of food
    cout << ptr << "\n";   // Outputs the memory address stored in ptr
    return 0;
}
```

---

## Dereferencing

To get the actual value stored at the address a pointer is pointing to, use the dereference operator (`*`):

```cpp
#include <iostream>
using namespace std;

int main() {
    string food = "Pizza";
    string* ptr = &food;

    // Output the value of food ("Pizza")
    cout << *ptr << "\n"; // Outputs: "Pizza"

    // Modify the value of food through the pointer
    *ptr = "Burger";
    cout << food << "\n"; // Outputs: "Burger"
    return 0;
}
```

---

## Pointer Arithmetic

You can perform arithmetic operations on pointers (typically additions and subtractions of integers) to navigate through contiguous memory blocks like arrays:

```cpp
#include <iostream>
using namespace std;

int main() {
    int arr[3] = {10, 20, 30};
    int* ptr = arr; // Points to first element arr[0]

    cout << *ptr << "\n";       // Outputs: 10
    cout << *(ptr + 1) << "\n"; // Outputs: 20
    cout << *(ptr + 2) << "\n"; // Outputs: 30
    return 0;
}
```

---

## Dynamic Memory Allocation

C++ allows you to allocate memory dynamically during runtime. This is done on the **Heap** (while standard variables are stored on the **Stack**).
- **`new`**: Allocates memory dynamically.
- **`delete`**: Frees dynamically allocated memory (important to prevent **Memory Leaks**).

```cpp
#include <iostream>
using namespace std;

int main() {
    // Allocate integer on heap
    int* p = new int(42);
    cout << *p << "\n";

    delete p; // Free memory
    p = nullptr; // Reset pointer to avoid dangling pointer

    // Allocate array on heap
    int* arr = new int[5];
    arr[0] = 10;
    delete[] arr; // Free array memory
    return 0;
}
```

---

## References vs Pointers

A reference is an alias (another name) for an existing variable.

| Feature | Pointers | References |
| :--- | :--- | :--- |
| **Declaration** | `int* ptr = &x;` | `int& ref = x;` |
| **Initialization** | Can be initialized as `nullptr` or later | Must be initialized when declared |
| **Reassignment** | Can point to different variables later | Cannot be rebound to another variable |
| **Syntax** | Needs `*` for dereferencing | Used directly without dereferencing |
| **Arithmetic** | Supports pointer arithmetic | Does not support arithmetic |
