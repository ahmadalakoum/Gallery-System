import axios from 'axios';

const API_URL= 'http://localhost/Gallery-System/server';

export const login = async (userData)=>{
    try{
        const response = await axios.post(`${API_URL}/login`,userData);
        return response.data;
    }catch(error){
        console.log(error);
        return;
    }
}

export const signup = async (userData)=>{
    try{
        const response = await axios.post(`${API_URL}/register`,userData);
        return response.data;
    }catch(error){
        console.log(error);
        return;
    }
}

export const getPhotos = async ()=>{
    try{
        const userID = localStorage.getItem("userID");
        const response = await axios.get(`${API_URL}/photos`,{
            headers:{
                "Authorization": `Bearer ${userID}`
            },
        });
        return response.data;
    }catch(error){
        console.log(error);
        return ;
    }
}

export const deletePhoto = async (id)=>{
    try{
        const userID = localStorage.getItem("userID");
        const response = await axios.get(`${API_URL}/delete?id=${id}`,{
            headers:{
                "Authorization": `Bearer ${userID}`
            },
        });
        return response.data;
    }catch(error){
        console.log(error);
        return ;
    }
}

export const getPhoto= async (id)=>{
    try{
        const userID = localStorage.getItem("userID");
        const response = await axios.get(`${API_URL}/photo?id=${id}`,{
            headers:{
                "Authorization": `Bearer ${userID}`
            },
        });
        return response.data;
    }catch(error){
        console.log(error);
        return ;
    }
}

export const searchPhotos= async (query)=>{
    try{
        const userID = localStorage.getItem("userID");
        const response = await axios.get(`${API_URL}/search?search=${query}`,{
            headers:{
                "Authorization": `Bearer ${userID}`
            },
        });
        return response.data;
    }catch(error){
        console.log(error);
        return ;
    }
}

export const addPhoto = async(imageData)=>{
    try{
        const userID = localStorage.getItem("userID");
        const response = await axios.post(`${API_URL}/upload`,imageData,{
            headers:{
                "Authorization": `Bearer ${userID}`
            },
        });
        return response.data;
    }catch(error){
        console.log(error);
        return;
    }
}