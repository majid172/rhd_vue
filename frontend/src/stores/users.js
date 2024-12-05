import { defineStore } from 'pinia'
import axios from "axios";
export const useUsersStore = defineStore('users',{
  state:()=>({
    lists: []

  }),
  actions:{
    async fetchUsers(){
      try{
        const {data} = await axios.get('http://127.0.0.1:8000/api/realtime');
        this.lists = data;

      } catch (error){
        console.error('Error fetching users',error);
      }
    }
  }
})
