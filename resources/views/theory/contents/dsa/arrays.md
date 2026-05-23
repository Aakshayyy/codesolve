# DSA Arrays

An array is a linear data structure that stores elements of the same data type in contiguous memory locations. It is the most basic and widely used data structure.

```
Index:    0    1    2    3    4
Value:  [10] [20] [30] [40] [50]
Memory: 1000 1004 1008 1012 1016   (Assuming 4-byte integers)
```

---

## Core Operations & Time Complexities

Because array elements are stored contiguously, we can compute the exact memory address of any element using its index:
$$\text{Address} = \text{Base Address} + \text{Index} \times \text{Size of element}$$

| Operation | Time Complexity | Description |
| :--- | :--- | :--- |
| **Access** | $O(1)$ | Direct lookup via index calculation. |
| **Search (Linear)** | $O(N)$ | Scan elements from left to right until found. |
| **Search (Binary)** | $O(\log N)$ | Fast search on a **sorted** array by dividing query range in half. |
| **Insertion (Start)** | $O(N)$ | Must shift all elements to the right to clear index 0. |
| **Insertion (End)** | $O(1)$ | Simply assign value at index `size` (if capacity exists). |
| **Deletion (Start)** | $O(N)$ | Must shift all elements to the left to close the gap. |
| **Deletion (End)** | $O(1)$ | Simply decrement the trackable size. |

---

## Static vs. Dynamic Arrays

1. **Static Arrays**: Fixed size defined at declaration. Size cannot change during execution (e.g. standard arrays in C++ `int arr[5]`, Java `int[] arr = new int[5]`).
2. **Dynamic Arrays**: Grow in capacity automatically when elements are appended (e.g. C++ `std::vector`, Java `ArrayList`, JavaScript arrays).

### How Dynamic Arrays Grow:
When a dynamic array is full and a new element is appended:
1. It allocates a new memory block, usually **double** the current capacity.
2. It copies the existing elements to the new memory block.
3. It deletes the old memory block.
- Although copying takes $O(N)$ time, dynamic resizing happens rarely. The **amortized** time complexity for inserting at the end remains $O(1)$.

---

## 2D Arrays (Matrices)

A 2D array is an array of arrays, representing a grid with rows and columns.

### Memory Representation
Computer memory is 1D (linear). 2D arrays are mapped to linear memory in one of two ways:
- **Row-Major Order**: Elements are stored row-by-row (default in C++ and Java).
- **Column-Major Order**: Elements are stored column-by-column.

```java
// Java Row-Major example
int[][] matrix = {
    {1, 2, 3},
    {4, 5, 6}
};

// Accessing elements (Row 1, Col 2)
int val = matrix[1][2]; // 6
```
