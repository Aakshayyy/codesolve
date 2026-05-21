# Arrays & Vectors

An array is the simplest data structure, storing elements in contiguous memory locations. This layout enables random access of elements in constant time using index offset calculations.

## Complexity Analysis

* **Access**: $O(1)$ (using index offset)
* **Search**: $O(N)$ (linear search if unsorted), $O(\log N)$ (binary search if sorted)
* **Insertion / Deletion at End**: $O(1)$ amortized for dynamic arrays
* **Insertion / Deletion at Middle/Start**: $O(N)$ (requires shifting elements)

---

## 1. Dynamic Arrays
In C++, `std::vector` is a dynamic array that automatically resizes when it runs out of space.
When capacity is exceeded, it typical allocates a new buffer that is **double the size**, copies the elements, and deallocates the old buffer.

```cpp
#include <vector>
#include <iostream>
using namespace std;

int main() {
    vector<int> vec;
    vec.push_back(10); // Insert at end
    vec.push_back(20);
    
    // Access
    cout << "First Element: " << vec[0] << "\n"; // 10
    
    // Deletion
    vec.pop_back(); // Removes 20
    return 0;
}
```

## 2. Multi-Dimensional Arrays
Used to represent grids, matrices, or high-dimensional coordinate spaces:

```cpp
// 2D grid of size R x C initialized to 0
vector<vector<int>> grid(r, vector<int>(c, 0));
```
