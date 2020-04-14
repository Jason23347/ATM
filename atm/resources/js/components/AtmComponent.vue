<template>
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">ATM 操作系统</div>

      <div class="card-body">
        <div class="screen">{{ text }}</div>
      </div>
      <div class="btn-list">
        <div class="col-3 float-left">
          <button
            class="col-12 btn btn-success"
            v-text="btn.info.success"
            @click="btn.handler.successHandler"
          ></button>
        </div>
        <div class="col-3 float-left">
          <button
            class="col-12 btn btn-info"
            v-text="btn.info.info"
            @click="btn.handler.infoHandler"
          ></button>
        </div>
        <div class="col-3 float-left">
          <button
            class="col-12 btn btn-warning"
            v-text="btn.info.warning"
            @click="btn.handler.warningHandler"
          ></button>
        </div>
        <div class="col-3 float-left">
          <button
            class="col-12 btn btn-danger"
            v-text="btn.info.danger"
            @click="btn.handler.dangerHandler"
          ></button>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss">
.card {
  .screen {
    min-height: 300px;
    font-size: 20px;
    padding: 10px 20px;
  }
  .btn-list {
    padding: 10px;
  }
}
</style>

<script>
export default {
  data() {
    return {
      text: "loading...",
      btn: {
        info: {
          success: "存取款",
          info: "查询",
          warning: "转帐",
          danger: "退出"
        },
        handler: {
          successHandler: this.operationPage,
          infoHandler: this.queryPage,
          warningHandler: this.transferPage,
          dangerHandler: this.logout
        }
      },
      loading: {}
    };
  },
  created() {
    let self = this;
    this.loading = {
      show() {
        self.text = "loading...";
      },
      hide() {
        setTimeout(() => {
          self.text = "Empty";
          self.loading = false;
        }, 400);
      }
    };
  },
  mounted() {
    console.log("ATM Component mounted.");
    this.homePage();
  },
  methods: {
    homePage() {
      this.loading.show();
      this.btn = {
        info: {
          success: "存取款",
          info: "查询",
          warning: "转帐",
          danger: "退出"
        },
        handler: {
          successHandler: this.operationPage,
          infoHandler: this.queryPage,
          warningHandler: this.transferPage,
          dangerHandler: this.logout
        }
      };
      this.loading.hide();
    },
    operationPage() {
      this.btn = {
        info: {
          success: "存款",
          info: "取款",
          warning: "查询",
          danger: "返回"
        },
        handler: {
          successHandler: this.depositHandler,
          infoHandler: this.withdrawHandler,
          warningHandler: this.queryPage,
          dangerHandler: this.homePage
        }
      };
    },
    queryPage() {
      this.btn = {
        info: {
          success: "-",
          info: "查询余额",
          warning: "-",
          danger: "返回"
        },
        handler: {
          successHandler: () => {},
          infoHandler: this.queryHandler,
          warningHandler: () => {},
          dangerHandler: this.homePage
        }
      };
    },
    transferPage() {
      this.btn = {
        info: {
          success: "-",
          info: "查询",
          warning: "转帐",
          danger: "返回"
        },
        handler: {
          successHandler: () => {},
          infoHandler: this.queryPage,
          warningHandler: this.transferHandler,
          dangerHandler: this.homePage
        }
      };
    },
    logout() {
      // FIXME propt for confirm
      axios.post("/logout").then(res => {
        window.location.reload();
      });
    },
    depositHandler() {
      // TODO handle deposit
      axios
        .get("")
        .then(res => {})
        .catch(err => {});
    },
    withdrawHandler() {
      // TODO handler withdraw
      axios
        .get("")
        .then(res => {})
        .catch(err => {});
    },
    transferHandler() {
      // TODO handle transfer
      axios
        .get("")
        .then(res => {})
        .catch(err => {});
    },
    queryHandler() {
      // TODO handle query
      axios
        .get("")
        .then(res => {})
        .catch(err => {});
    }
  }
};
</script>
