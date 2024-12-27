import {defineStore} from "pinia";
import {ref} from "vue";
import axios from "axios";
import router from "@/router/index.js";

export const useEtcSummaryStore = defineStore('etcSummary',{
  state:() => ({
    reports: [],
    inputField:{
      selectedBridgeId: null,
      plaza_id : null,
      shift: null,
      inputDate:null,
      inputStartTime: null,
      inputEndTime: null
    }
  }),
  actions: {
    validateInputs() {
      const {selectedBridgeId,plaza_id,inputDate,inputStartTime,inputEndTime } = this.inputField;
      if(!selectedBridgeId) return "Please select bridge";
      else if(!plaza_id) return "Please select plaza";
      else if(!inputDate) return "Please select date";
      else if(!inputStartTime) return "Please select start time";
      else if(!inputEndTime) return "Please select end time";

      return true;
    },

    shift(){
      const shiftSelect = this.inputField.shift;
      switch (shiftSelect) {
        case "all_shift":
          this.inputField.inputStartTime = "00:00:00";
          this.inputField.inputEndTime = "23:59:59";
          break;

        case "first_shift":
          this.inputField.inputStartTime = "00:00:00";
          this.inputField.inputEndTime = "07:59:59";
          break;

        case "second_shift":
          this.inputField.inputStartTime = "08:00:00";
          this.inputField.inputEndTime = "15:59:59";
          break;

        case "third_shift":
          this.inputField.inputStartTime = "16:00:00";
          this.inputField.inputEndTime = "23:59:59";
          break;

        default:
          this.inputField.inputStartTime = null;
          this.inputField.inputEndTime = null;
          console.warn("Invalid shift selected");
          break;
      }

    },
    async showReport(){
      console.log(this.inputField)
      const { data } = await axios.post("/etc/summary/show", this.inputField);
      this.reports = data;
      await router.push({
        name: "etcSummaryShow",
        // query: { ...this.inputField },
      });
      this.reset();
    },
    reset()
    {
      this.inputField = {
        selectedBridgeId: null,
        plaza_id: null,
        shift: null,
        inputDate: null,
        inputStartTime: null,
        inputEndTime: null
      };
    }
  }
});
