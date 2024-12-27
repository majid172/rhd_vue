import {defineStore} from "pinia";
import { ref } from "vue";
import axios from "axios";
export const useEtcBankwiseSummaryStore = defineStore('etcBankwiseSummary',{
  state:()=>({
    reports : [],
    inputField: {
      selectedBridgeId: null,
      plaza_id: null,
      bank: null,
      inputDate: null,
      shift: null,
      inputStartTime: null,
      inputEndTime: null,
    }
  }),
  actions:{
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
      console.log(
        this.inputField
      )
    }
  }
});
