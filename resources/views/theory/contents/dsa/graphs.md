# Graphs & DFS/BFS

A Graph is a non-linear data structure consisting of a finite set of vertices (or nodes) and a set of edges connecting them. Graphs are used to represent networks (social networks, roads, maps).

## Graph Representations
1. **Adjacency Matrix**: A 2D array of size $V \times V$ where cell `matrix[i][j] = 1` indicates an edge exists from $i$ to $j$.
   * Space: $O(V^2)$
   * Checking edge existence: $O(1)$
2. **Adjacency List**: An array of lists of size $V$. The list at index $i$ stores all adjacent neighbors of vertex $i$.
   * Space: $O(V + E)$ (highly efficient for sparse graphs)
   * Finding neighbors: $O(1)$ (direct lookup)

---

## 1. Depth-First Search (DFS)
DFS explores as deep as possible along each branch before backtracking. It is typically implemented recursively (using the call stack).

```cpp
#include <vector>
#include <iostream>
using namespace std;

void dfs(int node, vector<vector<int>>& adj, vector<bool>& visited) {
    visited[node] = true;
    cout << node << " ";
    
    for (int neighbor : adj[node]) {
        if (!visited[neighbor]) {
            dfs(neighbor, adj, visited);
        }
    }
}
```
* **Complexity**: $O(V + E)$

---

## 2. Breadth-First Search (BFS)
BFS explores neighbors layer-by-layer. It is implemented iteratively using a Queue.

```cpp
#include <queue>
#include <vector>
using namespace std;

void bfs(int start, vector<vector<int>>& adj, int V) {
    vector<bool> visited(V, false);
    queue<int> q;
    
    visited[start] = true;
    q.push(start);
    
    while (!q.empty()) {
        int node = q.front();
        q.pop();
        
        for (int neighbor : adj[node]) {
            if (!visited[neighbor]) {
                visited[neighbor] = true;
                q.push(neighbor);
            }
        }
    }
}
```
* **Complexity**: $O(V + E)$
* **Feature**: BFS guarantees finding the **shortest path** in an unweighted graph.
