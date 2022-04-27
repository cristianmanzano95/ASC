import { Notify } from "quasar";

Notify.setDefaults({
  position: "bottom",
  progress: true,
  timeout: 2500,
  textColor: "white",
  actions: [{ icon: "close", color: "white" }]
});

Notify.registerType("error", {
  icon: "error",
  progress: true,
  color: "red",
  textColor: "white"
});

Notify.registerType("success", {
  icon: "check_circle",
  progress: true,
  color: "green",
  textColor: "white"
});
Notify.registerType("warning", {
  icon: "announcement",
  progress: true,
  color: "orange",
  textColor: "white"
});
