# Time & Space Complexity

Time and space complexity analyze how execution time and memory consumption scale relative to the input size ($N$).

## Big-O Notation
Big-O notation describes the upper bound (worst-case scenario) of an algorithm's resource usage.

| Complexity | Name | Typical Algorithm | Max $N$ for 1s limit |
| :--- | :--- | :--- | :--- |
| $O(1)$ | Constant Time | Index access, arithmetic | Any value |
| $O(\log N)$ | Logarithmic Time | Binary Search, Heap insert | $10^{18}$ |
| $O(N)$ | Linear Time | Linear Search, Array traversal | $10^8$ |
| $O(N \log N)$ | Linearithmic Time | Merge Sort, Quick Sort | $10^6$ |
| $O(N^2)$ | Quadratic Time | Bubble Sort, Nested loops | $5000$ |
| $O(2^N)$ | Exponential Time | Subsets generation, recursion | $20 - 25$ |
| $O(N!)$ | Factorial Time | Permutations generation | $10 - 12$ |

---

## 1. Time Complexity Optimization
If the competitive programming time limit is **1.0 second**, the CPU can execute roughly $10^8$ basic operations.
* If $N \le 10^5$, an $O(N^2)$ algorithm will trigger a **Time Limit Exceeded (TLE)** error. You must target an $O(N \log N)$ or $O(N)$ approach.
* If $N \le 10^8$, only $O(N)$ or $O(\log N)$ will pass.

## 2. Space Complexity
Space complexity accounts for the auxiliary memory consumed by your algorithm (excluding input variables):
* Call stack frames in recursion count towards space complexity.
* Declaring large buffers or arrays (e.g., `int arr[100000][100000]`) consumes gigabytes of memory and triggers a **Memory Limit Exceeded (MLE)** error.
