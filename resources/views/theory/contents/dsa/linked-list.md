# DSA Linked Lists

A Linked List is a linear data structure where elements are not stored in contiguous memory locations. Instead, elements are stored in individual objects called **Nodes**, and each node points to the next node in the sequence.

```
Head                                        Tail
+------+------+     +------+------+     +------+------+
|  10  | o----+---->|  20  | o----+---->|  30  | NULL |
+------+------+     +------+------+     +------+------+
```

---

## Linked List vs. Array

| Feature | Array | Linked List |
| :--- | :--- | :--- |
| **Memory Allocation** | Contiguous (Stack or Heap) | Non-contiguous (Dynamic Heap allocation) |
| **Size** | Fixed size (Static) or costly copy (Dynamic) | Dynamic size (easily grows/shrinks) |
| **Access Time** | $O(1)$ (Direct access) | $O(N)$ (Must traverse sequentially) |
| **Insert/Delete** | $O(N)$ (Due to element shifting) | $O(1)$ (If node pointer is known) |

---

## Types of Linked Lists

### 1. Singly Linked List
Each node contains a data field and a reference (`next`) to the next node in the list.

### 2. Doubly Linked List
Each node contains a data field, a reference to the next node (`next`), and a reference to the previous node (`prev`). This allows traversal in both forward and backward directions.

```
       +------+------+------+     +------+------+------+
NULL <-| prev |  10  | next |<--->| prev |  20  | next |-> NULL
       +------+------+------+     +------+------+------+
```

### 3. Circular Linked List
The last node of the list points back to the first node (head) instead of pointing to `NULL`.

---

## Core Operations & Time Complexities

| Operation | Singly Linked List | Doubly Linked List | Description |
| :--- | :--- | :--- | :--- |
| **Access / Search** | $O(N)$ | $O(N)$ | Must start at Head and traverse node-by-node. |
| **Insert (At Head)** | $O(1)$ | $O(1)$ | Update head pointer. |
| **Insert (At Tail)** | $O(1)$ (with tail pointer) | $O(1)$ | Update tail next pointer. |
| **Delete (At Head)** | $O(1)$ | $O(1)$ | Move head pointer to head->next. |
| **Delete (At Tail)** | $O(N)$ (must find prev node) | $O(1)$ (via tail->prev) | Update tail pointer. |

---

## Singly Linked List Node Implementation

Here is how you define and build a Singly Linked List in Java:

```java
class Node {
    int data;
    Node next;

    public Node(int val) {
        this.data = val;
        this.next = null;
    }
}

public class Main {
    public static void main(String[] args) {
        Node head = new Node(10);
        head.next = new Node(20);
        head.next.next = new Node(30);

        // Traversal
        Node curr = head;
        while (curr != null) {
            System.out.print(curr.data + " -> ");
            curr = curr.next;
        }
        System.out.println("null");
        // Outputs: 10 -> 20 -> 30 -> null
    }
}
```
