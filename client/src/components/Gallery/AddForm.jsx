import React, { useState } from 'react';
import { addPhoto } from '../../services/api';
import "./AddForm.css";
import { useNavigate } from 'react-router-dom';

const AddForm = () => {
    const navigate = useNavigate();
    // const [title, setTitle] = useState('');
    // const [description, setDescription] = useState('');
    // const [tags, setTags] = useState('');
    const [image, setImage] = useState(null);
    const [error,setError]=useState('');
    const [formData,setFormData]=useState({
        title:"",
        description:'',
        tags:''
    })

    // Handle input changes
    const handleInputChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]:e.target.value
        })
    };

    // Handle file input change
    const handleFileChange = (e) => {
        const image = e.target.files[0];
        if (image) {
            const reader = new FileReader();

            reader.onloadend = () => {
                const base64Image = reader.result.split(',')[1];
                setImage(base64Image);  
            };

            reader.readAsDataURL(image); 
        }
    };

    // Handle form submission
    const handleSubmit =async (e) => {
        e.preventDefault();
        const dataToSend= {...formData,image}
        const data = await addPhoto(dataToSend);
        console.log(data);
        if(data.status==="success"){
            navigate('/');
            return;
        }
        else{
            setError(data.message);
        }

    };

    return (
        <div className="add-form-container">
        <form onSubmit={handleSubmit}>
            <h2>Add Photo</h2>
            <input
                type="text"
                name="title"
                placeholder="Title"
                value={formData.title}
                onChange={handleInputChange}
            />
            <input
                type="text"
                name="description"
                placeholder="Description"
                value={formData.description}
                onChange={handleInputChange}
            />
            <input
                type="text"
                name="tags"
                placeholder="Tags"
                value={formData.tags}
                onChange={handleInputChange}
            />
            <input
                type="file"
                onChange={handleFileChange}
            />
            <button type="submit">Add Photo</button>
        </form>
        {error && <div className="error-message">{error}</div>}
    </div>
    );
};

export default AddForm;
