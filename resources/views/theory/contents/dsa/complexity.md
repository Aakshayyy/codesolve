# DSA Time & Space Complexity

Analysing the execution speed (time complexity) and memory consumption (space complexity) of an algorithm is critical for writing efficient, production-grade code. We use **Asymptotic Notation** to express complexity.

---

## 1. Big O Notation (O)

Big O notation represents the **upper bound** (worst-case scenario) of an algorithm's runtime or space usage. It describes the growth rate of execution steps or memory allocation as the input size $N$ grows to infinity.

### Core Complexity Classes

Here are the most common time complexity classes, sorted from most efficient to least efficient:

| Notation | Name | Description | Example Algorithm |
| :--- | :--- | :--- | :--- |
| $O(1)$ | Constant | Operations do not depend on input size. | Accessing an array element by index |
| $O(\log N)$ | Logarithmic | Input size is divided in half at each step. | Binary Search |
| $O(N)$ | Linear | Operations grow proportionally to input size. | Finding maximum in an unsorted array |
| $O(N \log N)$ | Linearithmic | An $O(N)$ loop containing an $O(\log N)$ operation. | Merge Sort, Quick Sort (average) |
| $O(N^2)$ | Quadratic | Nested loops over the input elements. | Bubble Sort, Selection Sort |
| $O(2^N)$ | Exponential | Runtimes double with each additional input. | Recursive Fibonacci (naive) |
| $O(N!)$ | Factorial | Growth grows with permutation calculations. | Travelling Salesman problem (brute-force) |

---

## Time Complexity Calculations

### Example 1: Constant Time $O(1)$
```java
int a = 10;
int b = 20;
int sum = a + b; // Always takes 3 steps, independent of any N.
```

### Example 2: Linear Time $O(N)$
```java
int sum = 0;
for (int i = 0; i < N; i++) {
    sum += i; // Runs N times.
}
```

### Example 3: Quadratic Time $O(N^2)$
```java
for (int i = 0; i < N; i++) {
    for (int j = 0; j < N; j++) {
        System.out.println(i + "," + j); // Runs N * N times.
    }
}
```

---

## Space Complexity

Space complexity measures the total amount of **temporary memory** (RAM) an algorithm allocates relative to input size $N$, excluding the space taken by the inputs themselves (auxiliary space).

### Example: Auxiliary Space $O(N)$
This method allocates a new array of size $N$, meaning space complexity grows linearly with the input size:

```java
public int[] copyArray(int[] original) {
    int[] copy = new int[original.length]; // Allocates O(N) memory
    for (int i = 0; i < original.length; i++) {
        copy[i] = original[i];
    }
    return copy;
}
```

### Example: Auxiliary Space $O(1)$
This method sorts the array in-place, meaning no new arrays or data structures are allocated. The memory used is constant:

```java
public void reverseInPlace(int[] arr) {
    int left = 0, right = arr.length - 1;
    while (left < right) {
        int temp = arr[left]; // Uses 1 temporary int
        arr[left] = arr[right];
        arr[right] = temp;
        left++;
        right--;
    }
}
```
