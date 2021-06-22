<template>
  <div>
    <heading class="mb-6">{{ title }}</heading>

    <label class="text-lg" for="select">Select a disk to explore:</label>
    <select class="mb-6 text-lg p-2" v-model="selectedDisk" id="select">
      <option class="" v-for="disk in disks" :key="disk" :value="disk">
        {{ disk }}
      </option>
    </select>

    <card v-if="selectedDisk" class="mb-6">
      <table class="table w-full">
        <thead>
          <tr>
            <th class="w-3/4" colspan="1" scope="col">Files</th>
            <th class="w-1/4" colspan="1">
              {{ files.length ? 'Download' : '' }}
            </th>
          </tr>
        </thead>
        <tbody v-if="fetching">
          <tr>
            <td colspan="2">
              <loader></loader>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr v-if="path.length">
            <td colspan="2">
              <button @click="closeDirectory()">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  height="24"
                >
                  <path
                    class="heroicon-ui"
                    d="M13 5.41V21a1 1 0 0 1-2 0V5.41l-5.3 5.3a1 1 0 1 1-1.4-1.42l7-7a1 1 0 0 1 1.4 0l7 7a1 1 0 1 1-1.4 1.42L13 5.4z"
                  />
                </svg>
              </button>
            </td>
          </tr>
          <tr v-for="directory in directories" :key="directory">
            <td colspan="2">
              <div class="flex flex-row items-center">
                <svg
                  class="mr-2"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  height="24"
                >
                  <path
                    class="heroicon-ui"
                    d="M20 6a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h7.41l2 2H20zM4 6v12h16V8h-7.41l-2-2H4z"
                  />
                </svg>
                <button @click="openDirectory(directory)">
                  {{ directory }}
                </button>
              </div>
            </td>
          </tr>
          <tr v-for="file in files" :key="file">
            <td>{{ file }}</td>
            <td class="flex justify-center items-center">
              <a
                :href="
                  '/nova-vendor/file-explorer/files/download?disk=' +
                  selectedDisk +
                  '&path=' +
                  path.join('/') +
                  '/' +
                  file
                "
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  height="24"
                >
                  <path
                    class="heroicon-ui"
                    d="M11 14.59V3a1 1 0 0 1 2 0v11.59l3.3-3.3a1 1 0 0 1 1.4 1.42l-5 5a1 1 0 0 1-1.4 0l-5-5a1 1 0 0 1 1.4-1.42l3.3 3.3zM3 17a1 1 0 0 1 2 0v3h14v-3a1 1 0 0 1 2 0v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3z"
                  /></svg
              ></a>
            </td>
          </tr>
        </tbody>
      </table>
    </card>
  </div>
</template>

<script>
export default {
  metaInfo() {
    return {
      title: 'FileExplorer',
    };
  },

  data() {
    return {
      title: '',
      disks: [],
      fetching: false,
      selectedDisk: null,
      files: {},
      directories: {},
      path: [],
    };
  },

  watch: {
    path: function () {
      this.getFiles();
    },

    selectedDisk: function () {
      this.path = [];
      this.getFiles();
    },
  },

  mounted() {
    this.getConfig();
  },

  methods: {
    getFiles() {
      let path = this.path.join('/');
      console.log(path, this.selectedDisk);
      this.fetching = true;
      Nova.request()
        .get(
          '/nova-vendor/file-explorer/files?disk=' +
            this.selectedDisk +
            '&path=' +
            path,
        )
        .then((response) => {
          this.files = response.data.files;
          this.directories = response.data.directories;
          this.fetching = false;
        });
    },

    getConfig() {
      Nova.request()
        .get('/nova-vendor/file-explorer/files/disks')
        .then((response) => {
          this.disks = response.data.disks;
          this.selectedDisk = response.data.default;
          this.title = response.data.title;
        });
    },

    openDirectory(directory) {
      this.path.push(directory);
    },

    closeDirectory() {
      this.path.pop();
    },
  },
};
</script>

<style>
/* Scoped Styles */
</style>
