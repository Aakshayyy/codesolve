# DSA Stacks & Queues

Stacks and Queues are linear data structures that restrict how elements are added and removed, enforcing specific behaviors.

---

## 1. Stack (LIFO)

A Stack operates on a **Last-In, First-Out (LIFO)** policy. The last element added to the stack is the first one to be removed. Think of a stack of plates.

```
       +---+
       | 3 |  <- Top (Last element added)
       +---+
       | 2 |
       +---+
       | 1 |  <- Bottom
       +---+
```

### Core Stack Operations & Complexities

All operations on a stack take **$O(1)$ constant time**:
- **`push(x)`**: Add element `x` to the top of the stack.
- **`pop()`**: Remove and return the top element from the stack.
- **`peek()`**: Return the top element without removing it.
- **`isEmpty()`**: Check if the stack contains any elements.

### Stack Implementation (Using Arrays)
```java
class Stack {
    private int[] arr = new int[100];
    private int top = -1;

    public void push(int val) {
        arr[++top] = val;
    }

    public int pop() {
        return arr[top--];
    }

    public int peek() {
        return arr[top];
    }
}
```

---

## 2. Queue (FIFO)

A Queue operates on a **First-In, First-Out (FIFO)** policy. The first element added is the first one to be removed. Think of a line of people waiting.

```
     Enqueue (Rear)                               Dequeue (Front)
     ==============> [ 30 ]  [ 20 ]  [ 10 ]  ====================>
```

### Core Queue Operations & Complexities

All operations on a queue take **$O(1)$ constant time**:
- **`enqueue(x)`** (or `offer`): Add element `x` to the rear/tail of the queue.
- **`dequeue()`** (or `poll`): Remove and return the element at the front/head of the queue.
- **`peek()`**: Return the front element without removing it.

### Circular Queue (Array-based)
If a queue is implemented using a normal array, dequeuing elements leaves empty spaces at the front that cannot be reused. A **Circular Queue** wraps index pointers back to 0 using modulo arithmetic:

```
index = (index + 1) % capacity
```

---

## Common Use Cases in Algorithms

### Stack Applications:
- **Function Call Stack / Recursion**: Keeping track of active subroutines.
- **Undo/Redo Operations** in software.
- **Expression Parsing**: Evaluating infix/postfix/prefix expressions (e.g. matching parentheses).

### Queue Applications:
- **Breadth-First Search (BFS)** in Trees and Graphs.
- **Task Scheduling**: CPU scheduling, print spooling.
- **Message Queues**: Buffering asynchronous communication.
