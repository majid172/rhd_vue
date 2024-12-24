import {defineStore} from "pinia";
import axios from "axios";
import router from "@/router";
export const useYearlySummaryStore = defineStore("yearlySummary",{
  state:()=> ({
    yearlyReports: [],
    inputField:{
      selectedBridgeId: null,
      selectedPlazaId: null,
      year: null,
    }
  }),
  actions:{
    validateInputs(){
      const {selectedBridgeId,selectedPlazaId,year} = this.inputField;
      if(!selectedBridgeId) return "Please select a bridge";
      if(!selectedPlazaId) return "Please select a plaza";
      if(!year) return "Please select year";
      return true;
    },

    async showMonthlyReport(){
      const { data } = await axios.post('http://127.0.0.1:8000/api/summary/yearly/show',this.inputField);
      this.yearlyReports = data;
      router.push({
          name: "yearlyShow"
      })
    }
  }
});
