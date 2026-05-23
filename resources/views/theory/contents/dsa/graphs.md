# DSA Graphs & DFS/BFS

A Graph is a non-linear data structure consisting of a finite set of **Vertices** (or Nodes) and a set of **Edges** connecting them. Graphs are used to model networks like social networks, maps, and internet routing.

```
    ( 0 ) ------- ( 1 )
      |             /
      |            /
      |           /
    ( 2 ) ------- ( 3 )
```

---

## Graph Terminologies

- **Directed Graph (Digraph)**: Edges have direction (e.g. $A \rightarrow B$).
- **Undirected Graph**: Edges are bidirectional (e.g. $A - B$).
- **Weighted Graph**: Edges have numerical values associated with them (costs/distances).
- **Cyclic Graph**: Contains a path that starts and ends at the same vertex.

---

## Graph Representations in Memory

There are two primary ways to represent a graph in memory:

### 1. Adjacency Matrix
A 2D array of size $V \times V$ where $V$ is the number of vertices. If `adj[i][j] = 1`, there is an edge from $i$ to $j$.
- **Space Complexity**: $O(V^2)$
- **Best for**: Dense graphs (many edges), or quick edge lookup $O(1)$.

### 2. Adjacency List
An array of lists. The index of the array represents a vertex, and each element in the list represents its neighbors.
- **Space Complexity**: $O(V + E)$ where $E$ is the number of edges.
- **Best for**: Sparse graphs (few edges). Preferred in competitive programming.

---

## Graph Traversals

To traverse a graph, you must keep track of a `visited` array to prevent infinite loops caused by cycles.

### 1. Breadth-First Search (BFS)
BFS explores the graph level-by-level, visiting all neighbors of a node before moving to their neighbors. Uses a **Queue** internally.
- **Time Complexity**: $O(V + E)$
- **Applications**: Finding the shortest path in an unweighted graph.

```java
import java.util.*;

public void bfs(int start, ArrayList<ArrayList<Integer>> adj, int V) {
    boolean[] visited = new boolean[V];
    Queue<Integer> q = new LinkedList<>();

    visited[start] = true;
    q.add(start);

    while (!q.isEmpty()) {
        int curr = q.poll();
        System.out.print(curr + " ");

        for (int neighbor : adj.get(curr)) {
            if (!visited[neighbor]) {
                visited[neighbor] = true;
                q.add(neighbor);
            }
        }
    }
}
```

### 2. Depth-First Search (DFS)
DFS explores the graph by going as deep as possible along each branch before backtracking. Uses a **Stack** (implicitly via recursion).
- **Time Complexity**: $O(V + E)$
- **Applications**: Cycle detection, topological sorting, pathfinding.

```java
public void dfs(int curr, ArrayList<ArrayList<Integer>> adj, boolean[] visited) {
    visited[curr] = true;
    System.out.print(curr + " ");

    for (int neighbor : adj.get(curr)) {
        if (!visited[neighbor]) {
            dfs(neighbor, adj, visited); // Recursive call
        }
    }
}
```
