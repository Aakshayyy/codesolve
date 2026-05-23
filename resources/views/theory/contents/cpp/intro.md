# C++ Introduction

C++ is a cross-platform language that can be used to create high-performance applications. It was developed by **Bjarne Stroustrup** at Bell Labs in 1979 as an extension to the C language. C++ gives programmers a high level of control over system resources and memory.

---

## Why Use C++?

C++ is one of the world's most popular programming languages and is the gold standard for **competitive programming** and **software engineering** because:
- **Speed & Efficiency**: It compiles directly to machine code, making it incredibly fast.
- **Low-level access**: You have direct control over hardware, memory management, and pointers.
- **Standard Template Library (STL)**: A massive collection of pre-built data structures (vector, set, map) and algorithms (sort, search) that saves development time.
- **Object-Oriented**: C++ supports OOP, which makes code reusable and modular.

---

## C++ Syntax & Structure

Here is a standard C++ program explaining the core structural components:

```cpp
#include <iostream>
using namespace std;

int main() {
    cout << "Hello World!";
    return 0;
}
```

### Code Explanation:
- **Line 1**: `#include <iostream>` is a **header file library** that lets us work with input and output objects, such as `cout` (pronounced "see-out").
- **Line 2**: `using namespace std` means we can use names for objects and variables from the standard library.
- **Line 4**: `int main()` is the entry point of every C++ program. Any code inside its curly brackets `{}` will be executed.
- **Line 5**: `cout` is an object used together with the *insertion operator* (`<<`) to output/print text. 
- **Line 6**: `return 0` ends the main function and returns a status code of 0 to the operating system, indicating success.

---

## W3Schools Style: "Try It Yourself" Examples

### 1. Basic Output & New Lines
To insert a new line, you can use the `\n` character or the `endl` manipulator:

```cpp
#include <iostream>
using namespace std;

int main() {
    cout << "Hello World!\n";
    cout << "I am learning C++" << endl;
    cout << "It is awesome!";
    return 0;
}
```

### 2. Fast I/O for Competitive Programming
When dealing with large inputs in coding contests, you should disable synchronization between C and C++ standard streams to optimize speed:

```cpp
#include <iostream>
using namespace std;

int main() {
    // Optimize standard input/output streams
    ios_base::sync_with_stdio(false);
    cin.tie(NULL);

    cout << "Fast I/O is configured!" << "\n";
    return 0;
}
```

---

## C++ Comments

Comments are used to explain C++ code and make it more readable. They are ignored by the compiler.

### Single-line Comments
Single-line comments start with two forward slashes (`//`):
```cpp
// This is a single-line comment
cout << "Hello World!";
```

### Multi-line Comments
Multi-line comments start with `/*` and end with `*/`:
```cpp
/* The code below will print the words Hello World!
to the screen, and it is amazing */
cout << "Hello World!";
```
