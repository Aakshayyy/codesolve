# C++ Control Flow

Control flow statements allow you to control the execution path of your C++ program based on conditions or run code repeatedly using loops.

---

## Conditional Statements

C++ supports the standard mathematical logical conditions:
- Less than: `a < b`
- Less than or equal to: `a <= b`
- Greater than: `a > b`
- Greater than or equal to: `a >= b`
- Equal to: `a == b`
- Not Equal to: `a != b`

### If / Else If / Else

```cpp
#include <iostream>
using namespace std;

int main() {
    int time = 22;
    if (time < 10) {
        cout << "Good morning.";
    } else if (time < 20) {
        cout << "Good day.";
    } else {
        cout << "Good evening.";
    }
    // Outputs: "Good evening."
    return 0;
}
```

### Ternary Operator (Short Hand If...Else)
```cpp
string result = (time < 18) ? "Good day." : "Good evening.";
```

### Switch Statement
Use the `switch` statement to select one of many code blocks to be executed.

```cpp
#include <iostream>
using namespace std;

int main() {
    int day = 4;
    switch (day) {
        case 6:
            cout << "Today is Saturday";
            break;
        case 7:
            cout << "Today is Sunday";
            break;
        default:
            cout << "Looking forward to the Weekend";
    }
    // Outputs: "Looking forward to the Weekend"
    return 0;
}
```

---

## C++ Loops

Loops can execute a block of code as long as a specified condition is reached.

### 1. While Loop
The `while` loop loops through a block of code as long as a specified condition is `true`:

```cpp
int i = 0;
while (i < 5) {
    cout << i << " ";
    i++;
}
// Outputs: 0 1 2 3 4
```

### 2. Do/While Loop
The `do/while` loop is a variant of the while loop. This loop will execute the code block **once**, before checking if the condition is true:

```cpp
int i = 0;
do {
    cout << i << " ";
    i++;
} while (i < 5);
// Outputs: 0 1 2 3 4
```

### 3. For Loop
When you know exactly how many times you want to loop through a block of code, use the `for` loop:

```cpp
for (int i = 0; i < 5; i++) {
    cout << i << " ";
}
// Outputs: 0 1 2 3 4
```

### 4. Range-based For Loop (C++11)
Used exclusively to loop through elements in an array or container:

```cpp
#include <iostream>
#include <vector>
using namespace std;

int main() {
    vector<int> numbers = {10, 20, 30, 40};
    for (int x : numbers) {
        cout << x << " ";
    }
    // Outputs: 10 20 30 40
    return 0;
}
```

---

## Break & Continue

- **`break`**: Used to jump out of a loop or switch statement completely.
- **`continue`**: Breaks one iteration in the loop (if a specified condition occurs), and continues with the next iteration.

```cpp
#include <iostream>
using namespace std;

int main() {
    // Example of continue
    for (int i = 0; i < 6; i++) {
        if (i == 3) {
            continue; // Skip printing 3
        }
        cout << i << " ";
    }
    // Outputs: 0 1 2 4 5
    return 0;
}
```
