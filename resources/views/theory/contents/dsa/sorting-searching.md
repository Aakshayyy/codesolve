# DSA Sorting & Searching

Sorting and searching are fundamental operations in computer science. Selecting the correct algorithm can significantly optimize memory usage and performance.

---

## 1. Searching Algorithms

### Linear Search
Scans every element in the list sequentially until the target value is found.
- **Time Complexity**: $O(N)$
- **Requirement**: Works on both sorted and unsorted collections.

### Binary Search
Divides the search interval in half repeatedly. If the value of the search key is less than the item in the middle of the interval, narrow the interval to the lower half. Otherwise, narrow it to the upper half.
- **Time Complexity**: $O(\log N)$
- **Requirement**: **Must be performed on a sorted collection.**

```java
public int binarySearch(int[] arr, int target) {
    int left = 0, right = arr.length - 1;
    while (left <= right) {
        int mid = left + (right - left) / 2; // Prevents overflow
        
        if (arr[mid] == target) return mid;
        if (arr[mid] < target) left = mid + 1;
        else right = mid - 1;
    }
    return -1; // Not found
}
```

---

## 2. Sorting Algorithms

Here is a comparison of common sorting algorithms, their time complexities, space complexities, and whether they are **stable** (preserve relative order of duplicate elements):

| Algorithm | Best Case | Average Case | Worst Case | Space Complexity | Stable | Description |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **Bubble Sort** | $O(N)$ | $O(N^2)$ | $O(N^2)$ | $O(1)$ | Yes | Swap adjacent elements if they are in the wrong order. |
| **Selection Sort** | $O(N^2)$ | $O(N^2)$ | $O(N^2)$ | $O(1)$ | No | Find minimum element and place at the beginning. |
| **Insertion Sort** | $O(N)$ | $O(N^2)$ | $O(N^2)$ | $O(1)$ | Yes | Insert elements into their sorted positions one-by-one. |
| **Merge Sort** | $O(N \log N)$ | $O(N \log N)$ | $O(N \log N)$ | $O(N)$ | Yes | Divide array in half, sort recursively, and merge them. |
| **Quick Sort** | $O(N \log N)$ | $O(N \log N)$ | $O(N^2)$ | $O(\log N)$ | No | Partition array using a pivot element and sort partitions. |

---

## Merge Sort (Divide & Conquer)
Merge Sort is a stable, out-of-place sorting algorithm based on the Divide and Conquer paradigm. It divides the input array into two halves, calls itself for the two halves, and then merges the two sorted halves:

```java
public void mergeSort(int[] arr, int l, int r) {
    if (l < r) {
        int m = l + (r - l) / 2;
        
        mergeSort(arr, l, m);     // Sort left half
        mergeSort(arr, m + 1, r); // Sort right half
        
        merge(arr, l, m, r);       // Merge sorted halves
    }
}
```

---

## Quick Sort (Partitioning)
Quick Sort is a fast, in-place sorting algorithm. It picks an element as a pivot and partitions the given array around the picked pivot:

```java
public void quickSort(int[] arr, int low, int high) {
    if (low < high) {
        int pi = partition(arr, low, high); // Partition index
        
        quickSort(arr, low, pi - 1);  // Sort before partition
        quickSort(arr, pi + 1, high); // Sort after partition
    }
}
```
