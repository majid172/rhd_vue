<script setup>
import { ref, computed, onMounted } from "vue";
import { useUsersStore } from "@/stores/users.js";

const userStore = useUsersStore();
const currentPage = ref(1); // Current page starts at 1
const itemsPerPage = 20; // Items per page

// Compute paginated data
const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return userStore.lists.slice(start, end);
});

// Compute total pages
const totalPages = computed(() => Math.ceil(userStore.lists.length / itemsPerPage));

// Navigate to a specific page
const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
  }
};

// Fetch users on component mount
onMounted(() => {
  userStore.fetchUsers();
});
</script>

<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
      <h5 class="card-header">User List</h5>
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
          <tr>
            <th>User Name</th>
            <th>Bridge</th>
            <th>Roles</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
          </thead>
          <tbody class="table-border-bottom-0">
          <tr v-for="(list, index) in paginatedData" :key="index">
            <td> <span>{{ list.name }}</span></td>
            <td v-if="JSON.parse(list.bridge_id).includes('3')">MEGHNA AND MEGHNA-GOMOTI BRIDGE</td>
            <td v-else>Other Bridge</td>
            <td>{{ list.roles }}</td>
            <td>
              <span class="badge bg-label-success me-1" v-if="list.status == 1">Active</span>
              <span class="badge bg-label-danger me-1" v-else>Inactive</span>
            </td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                </div>
              </div>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="demo-inline-spacing">
        <nav aria-label="Page navigation" class="mt-3">
          <ul class="pagination pagination-sm justify-content-center">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link" href="javascript:void(0);" @click="changePage(currentPage - 1)">
                Previous
              </a>
            </li>
            <li
              v-for="page in totalPages"
              :key="page"
              class="page-item"
              :class="{ active: currentPage === page }"
            >
              <a class="page-link" href="javascript:void(0);" @click="changePage(page)">
                {{ page }}
              </a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a class="page-link" href="javascript:void(0);" @click="changePage(currentPage + 1)">
                Next
              </a>
            </li>
          </ul>
        </nav>
      </div>

    </div>
  </div>
</template>
