# Java Collections Framework

The Collections Framework is a unified architecture representing and manipulating data collections. It reduces programming effort by providing high-performance implementations of data structures.

## 1. List Interface
An ordered collection of elements (duplicates allowed).
* **`ArrayList`**: Re-sizable dynamic array ($O(1)$ random access).
* **`LinkedList`**: Doubly linked list list structure.

```java
import java.util.ArrayList;
import java.util.List;

List<String> list = new ArrayList<>();
list.add("Apple");
list.add("Banana");
String fruit = list.get(0); // "Apple"
```

## 2. Set Interface
A collection that contains NO duplicate elements.
* **`HashSet`**: Backed by a Hash Table ($O(1)$ operations, unsorted).
* **`TreeSet`**: Backed by a Red-Black Tree ($O(\log N)$ operations, sorted).

```java
import java.util.HashSet;
import java.util.Set;

Set<Integer> set = new HashSet<>();
set.add(10);
set.add(10); // Ignored
boolean exists = set.contains(10); // true
```

## 3. Map Interface
Maps unique keys to values. Does not extend the Collection interface.
* **`HashMap`**: $O(1)$ key-value retrieval.
* **`TreeMap`**: Key-value retrieval sorted by keys ($O(\log N)$).

```java
import java.util.HashMap;
import java.util.Map;

Map<String, Integer> map = new HashMap<>();
map.put("Alice", 90);
int score = map.getOrDefault("Bob", 0); // returns 0
```
