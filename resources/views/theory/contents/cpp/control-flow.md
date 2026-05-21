# Control Flow in C++

Control flow structures allow program execution to branch, execute loops, or jump to select parts of the code depending on conditions.

## 1. Conditionals (`if`, `else if`, `else`)
Evaluates logical conditions using relational operators (`==`, `!=`, `<`, `>`, `<=`, `>=`).

```cpp
#include <iostream>
using namespace std;

int main() {
    int score = 85;

    if (score >= 90) {
        cout << "Grade: A\n";
    } else if (score >= 80) {
        cout << "Grade: B\n";
    } else {
        cout << "Grade: C\n";
    }
    return 0;
}
```

## 2. Loops (`for`, `while`, `do-while`)
Used to repeat blocks of instructions until conditions change.

### The For Loop
Ideal for iterating when the number of cycles is known beforehand:
```cpp
for (int i = 0; i < 5; i++) {
    cout << i << " ";
}
// Output: 0 1 2 3 4
```

### The While Loop
Runs while a boolean condition evaluates to true:
```cpp
int count = 5;
while (count > 0) {
    cout << count << " ";
    count--;
}
// Output: 5 4 3 2 1
```

> [!TIP]
> Use `break` to exit loops prematurely, and `continue` to skip the remainder of the current iteration and jump to the next step.
