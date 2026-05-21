# Stacks & Queues

Stacks and Queues are linear data structures with constrained protocols governing how elements are inserted and retrieved.

## 1. Stack (LIFO: Last-In, First-Out)
In a stack, the element added last is the first to be removed.
* **`push`**: Adds an element to the top.
* **`pop`**: Removes the element from the top.
* **`peek` / `top`**: Inspects the element at the top.

```
+---------+
|    3    |  <- Top (added last, popped first)
+---------+
|    2    |
+---------+
|    1    |
+---------+
```

### Typical Use Case: Matching Parentheses
```cpp
#include <stack>
#include <string>
using namespace std;

bool isValidParentheses(string s) {
    stack<char> st;
    for (char c : s) {
        if (c == '(') st.push(')');
        else {
            if (st.empty() || st.top() != c) return false;
            st.pop();
        }
    }
    return st.empty();
}
```

---

## 2. Queue (FIFO: First-In, First-Out)
In a queue, the element added first is the first to be removed (similar to standing in a real-world checkout line).
* **`enqueue` / `push`**: Adds an element to the back/rear.
* **`dequeue` / `pop`**: Removes an element from the front.

```
Front                               Back
 [ 1 ] <--- [ 2 ] <--- [ 3 ] <--- [ 4 ]
 (popped)                        (pushed)
```

> [!TIP]
> Queues are the core tracking structure in **Breadth-First Search (BFS)** algorithms on trees and graphs.
