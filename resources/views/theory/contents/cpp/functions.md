# C++ Functions & Recursion

A function is a block of code which only runs when it is called. You can pass data, known as parameters, into a function. Functions are used to perform certain actions, and they are important for reusing code.

---

## Declaring & Defining Functions

A C++ function consists of two parts:
- **Declaration**: The function's name, return type, and parameters (if any).
- **Definition**: The body of the function (the code to be executed).

```cpp
#include <iostream>
using namespace std;

// Function declaration (prototype)
void myFunction();

int main() {
    myFunction(); // Call the function
    return 0;
}

// Function definition
void myFunction() {
    cout << "I just got executed!\n";
}
```

---

## Function Parameters & Arguments

Information can be passed to functions as a parameter. Parameters act as variables inside the function.

### Default Parameter Value
You can use a default parameter value, by using the equals sign (`=`):

```cpp
#include <iostream>
using namespace std;

void printCountry(string country = "India") {
    cout << country << "\n";
}

int main() {
    printCountry("Sweden");
    printCountry(); // Uses default value "India"
    return 0;
}
```

### Return Values
To return a value, use the `return` keyword inside the function:

```cpp
int add(int x, int y) {
    return x + y;
}
```

---

## Parameter Passing Mechanisms

There are three ways to pass arguments to a function in C++:

### 1. Pass by Value
The function creates a copy of the actual argument. Changes inside the function do not affect the original variable.

```cpp
void updateValue(int x) {
    x = 100;
}
```

### 2. Pass by Reference
The function accesses the original variable directly using the reference operator (`&`). Changes inside the function **will** modify the original variable.

```cpp
#include <iostream>
using namespace std;

// Pass by reference
void swapNums(int &x, int &y) {
    int temp = x;
    x = y;
    y = temp;
}

int main() {
    int firstNum = 10;
    int secondNum = 20;
    swapNums(firstNum, secondNum);

    cout << firstNum << " " << secondNum << "\n"; // Outputs: 20 10
    return 0;
}
```

### 3. Pass by Pointer
Passes the memory address of the variable. Allows modification and pointer operations.

```cpp
void updateByPointer(int* ptr) {
    if (ptr != nullptr) {
        *ptr = 100; // Dereference and update
    }
}
```

---

## Function Overloading

Multiple functions can have the same name as long as the number and/or type of parameters are different:

```cpp
int plusFuncInt(int x, int y) {
    return x + y;
}

double plusFuncDouble(double x, double y) {
    return x + y;
}
```
In C++, you can overload the name `plusFunc` to accept both types:
```cpp
int plusFunc(int x, int y);
double plusFunc(double x, double y);
```

---

## Recursion

Recursion is the technique of making a function call itself. This technique provides a way to break complicated problems down into simple, easy-to-solve problems.

### Example: Calculating Factorial
Every recursive function must have a **base case** (to stop calling itself) and a **recursive case** (which calls itself with smaller inputs).

```cpp
#include <iostream>
using namespace std;

int factorial(int n) {
    // Base case
    if (n <= 1) {
        return 1;
    }
    // Recursive case
    return n * factorial(n - 1);
}

int main() {
    cout << factorial(5) << "\n"; // Outputs: 120
    return 0;
}
```
> [!WARNING]
> If a recursive function does not reach its base case, or if the recursion depth is too deep, it will cause a **Stack Overflow** error due to exceeding stack memory limits.
