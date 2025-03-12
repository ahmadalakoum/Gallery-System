import axios from 'axios';

const API_URL= 'http://localhost/Gallery-System/server';

export const login = async (userData)=>{
    try{
        const response = await axios.post(`${API_URL}/login`,userData);
        return response.data;
    }catch(error){
        console.log(error);
    }
}

export const signup = async (userData)=>{
    try{
        const response = await axios.post(`${API_URL}/register`,userData);
        return response.data;
    }catch(error){
        console.log(error);
    }
}
