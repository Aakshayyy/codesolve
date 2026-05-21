# Linked Lists

A Linked List is a linear data structure where elements are not stored in contiguous memory locations. Instead, each element (called a **Node**) contains a data payload and a pointer/reference referencing the next node in the sequence.

```
Singly Linked List:
[ Data | Next ] ---> [ Data | Next ] ---> [ Data | NULL ]
```

## Singly vs. Doubly Linked Lists
* **Singly Linked List**: Each node contains a single reference pointer referencing the *next* node.
* **Doubly Linked List**: Each node contains two reference pointers referencing both the *next* and the *previous* node, allowing bi-directional traversal at the cost of extra memory.

---

## Complexity Analysis

| Operation | Array / Vector | Singly Linked List |
| :--- | :--- | :--- |
| Random Access | $O(1)$ | $O(N)$ (requires traversal) |
| Insert/Delete at Head | $O(N)$ (shifting) | $O(1)$ |
| Insert/Delete at Middle | $O(N)$ (shifting) | $O(1)$ (once position is found) |

---

## Custom Node Definition (C++)
```cpp
struct ListNode {
    int val;
    ListNode* next;
    
    // Constructor
    ListNode(int x) : val(x), next(nullptr) {}
};
```

## Common Algorithms
* **Reversing a Linked List**: Swap pointers iteratively using a `prev`, `curr`, and `next` pointer sequence.
* **Floyd's Cycle-Finding Algorithm (Tortoise & Hare)**: Use a slow pointer (moves 1 step) and a fast pointer (moves 2 steps) to detect if a loop/cycle exists.
