import {defineStore} from "pinia";
import axios from "axios";
export const useBridgeStore = defineStore('bridge',{
  state:()=>({
      bridges:[]
}),
  actions:{
    async fetchBridge(){
      const {data} = await axios.get('http://127.0.0.1:8000/api/summary/daily/report');
      this.bridges = data;

    }
  }
})
