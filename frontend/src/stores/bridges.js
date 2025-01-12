import {defineStore} from "pinia";
import axios from "axios";
export const useBridgeStore = defineStore('bridge',{
  state:()=>({
      bridges:[]
}),
  actions:{
    async fetchBridge(){
      const {data} = await axios.get('/summary/daily/report');
      this.bridges = data;
      console.log(data)
    },

    async showPlaza()
    {
      console.log('plaza name');
    }
  }
})
