# Sorting & Searching

Sorting and Searching are the building blocks of algorithmic optimization. Many complex array and grid problems are simplified by sorting the input first.

## 1. Searching Algorithms
* **Linear Search**: Checks each element sequentially. Time: $O(N)$.
* **Binary Search**: Searches a **sorted** array by repeatedly dividing the search interval in half. Time: $O(\log N)$.

### Binary Search Template
```cpp
int binarySearch(vector<int>& arr, int target) {
    int low = 0, high = arr.size() - 1;
    
    while (low <= high) {
        int mid = low + (high - low) / 2; // Prevents integer overflow
        
        if (arr[mid] == target) return mid;
        else if (arr[mid] < target) low = mid + 1;
        else high = mid - 1;
    }
    return -1; // Target not found
}
```

---

## 2. Sorting Algorithms

| Algorithm | Average Time | Space Complexity | Stable? |
| :--- | :--- | :--- | :--- |
| **Bubble / Insertion** | $O(N^2)$ | $O(1)$ | Yes |
| **Merge Sort** | $O(N \log N)$ | $O(N)$ (auxiliary array) | Yes |
| **Quick Sort** | $O(N \log N)$ | $O(\log N)$ (call stack) | No |
| **Heap Sort** | $O(N \log N)$ | $O(1)$ | No |

### Merge Sort vs. Quick Sort
* **Merge Sort**: Divides the array in two halves, sorts them recursively, and merges the sorted halves. It requires extra memory but is stable.
* **Quick Sort**: Selects a **pivot** element, partitions the array such that elements smaller than the pivot go to the left and larger ones to the right, then sorts recursively. In-place but unstable.
