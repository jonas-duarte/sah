const http = {
  url: "/server.php",
  async get(path) {
    return this.fetch(path, { method: "GET" });
  },
  async post(path) {
    return this.fetch(path, { method: "POST" });
  },
  async fetch(path, params) {
    const { status, data } = await fetch(
      `${this.url}${path}`,
      params
    ).then((response) => response.json());

    if (status !== 200) {
      alert(data);
      throw data;
    }

    return data;
  },
};
