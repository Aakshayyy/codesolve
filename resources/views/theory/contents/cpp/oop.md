# Object-Oriented Programming (OOP) in C++

C++ supports Object-Oriented Programming (OOP), which models software design around data, or objects, rather than functions and logic.

## Four Pillars of OOP
1. **Encapsulation**: Bundling data (variables) and methods (functions) inside class boundaries, hiding internal implementation details using access specifiers (`public`, `private`, `protected`).
2. **Abstraction**: Hiding complex implementation details and showing only essential features of objects.
3. **Inheritance**: Creating child classes from parent classes to reuse existing properties and functions.
4. **Polymorphism**: The ability for functions or classes to behave differently depending on context (e.g., function overloading, virtual functions override).

---

## Basic Class Template
Here is how classes are structured:

```cpp
#include <iostream>
#include <string>
using namespace std;

class Solution {
private:
    int id; // Accessible only inside this class

public:
    string name; // Accessible anywhere

    // Constructor
    Solution(int i, string n) {
        id = i;
        name = n;
    }

    // Method
    void display() {
        cout << "ID: " << id << ", Name: " << name << "\n";
    }
};

int main() {
    Solution sol(1, "Unique Solution");
    sol.display(); // Output: ID: 1, Name: Unique Solution
    return 0;
}
```
