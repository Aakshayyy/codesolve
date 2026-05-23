# Java Collections Framework

The Java Collections Framework provides an architecture to store and manipulate a group of objects. It includes interfaces, classes, and algorithms to perform operations like searching, sorting, insertion, and deletion out-of-the-box.

```
                  Collection (Interface)
        /                    |               \
  List (Interface)    Set (Interface)    Queue (Interface)
     /      \                |                 |
ArrayList  LinkedList     HashSet            Deque
                                               |
                                           ArrayDeque
```
*Note: Map is also part of the framework but does not inherit from the Collection interface directly.*

---

## 1. List (ArrayList & LinkedList)

A List is an ordered collection that can contain duplicate elements.

### ArrayList
Backed by a dynamic array. Best for retrieving elements by index.
- **Time Complexity**: Get: `O(1)`, Add/Remove: `O(N)`.

```java
import java.util.ArrayList;

ArrayList<String> list = new ArrayList<>();
list.add("Apple");
list.add("Banana");
String fruit = list.get(0); // "Apple"
```

### LinkedList
Backed by a doubly linked list. Best for frequent insertions/deletions.
- **Time Complexity**: Get: `O(N)`, Add/Remove: `O(1)`.

---

## 2. Set (HashSet & TreeSet)

A Set is a collection that cannot contain duplicate elements.

### HashSet
Uses a hash table internally. Does not guarantee any iteration order.
- **Time Complexity**: Add/Remove/Contains: `O(1)`.

```java
import java.util.HashSet;

HashSet<Integer> set = new HashSet<>();
set.add(10);
set.add(20);
set.add(10); // Duplicate, will not be added

System.out.println(set.contains(10)); // true
```

### TreeSet
Backed by a Red-Black tree. Elements are sorted in natural ascending order.
- **Time Complexity**: Add/Remove/Contains: `O(log N)`.

---

## 3. Map (HashMap & TreeMap)

A Map maps keys to values. It cannot contain duplicate keys.

### HashMap
Uses a hash table. Iteration order is not guaranteed.
- **Time Complexity**: Put/Get/Contains: `O(1)`.

```java
import java.util.HashMap;

HashMap<String, Integer> map = new HashMap<>();
map.put("Alice", 25);
map.put("Bob", 30);

int age = map.get("Alice"); // 25
System.out.println(map.containsKey("Charlie")); // false
```

### TreeMap
Keys are sorted in natural sorting order.
- **Time Complexity**: Put/Get/Contains: `O(log N)`.

---

## 4. Stack & Queue

### Stack
LIFO (Last-In-First-Out) container:

```java
import java.util.Stack;

Stack<Integer> stack = new Stack<>();
stack.push(10);
stack.push(20);
int val = stack.pop(); // 20
int top = stack.peek(); // 10
```

### Queue & Deque
FIFO (First-In-First-Out) container. We typically use `LinkedList` or `ArrayDeque` to instantiate a queue:

```java
import java.util.Queue;
import java.util.LinkedList;

Queue<String> queue = new LinkedList<>();
queue.offer("First");
queue.offer("Second");

String item = queue.poll(); // "First"
```
