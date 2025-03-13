import React, { useState } from 'react';
import { addPhoto } from '../../services/api';
import "./AddForm.css";

const AddForm = () => {
    const [title, setTitle] = useState('');
    const [description, setDescription] = useState('');
    const [tags, setTags] = useState('');
    const [image, setImage] = useState(null);

    // Handle input changes
    const handleInputChange = (e) => {
        const { name, value } = e.target;
        if (name === 'title') setTitle(value);
        if (name === 'description') setDescription(value);
        if (name === 'tags') setTags(value);
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
        const data = await addPhoto({title,description,image,tags});
        console.log(data);
        if(data.status==="success"){
            window.location.href='/';
            return;
        }
        else{
            console.log(data.message);
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
                value={title}
                onChange={handleInputChange}
            />
            <input
                type="text"
                name="description"
                placeholder="Description"
                value={description}
                onChange={handleInputChange}
            />
            <input
                type="text"
                name="tags"
                placeholder="Tags"
                value={tags}
                onChange={handleInputChange}
            />
            <input
                type="file"
                onChange={handleFileChange}
            />
            <button type="submit">Add Photo</button>
        </form>
    </div>
    );
};

export default AddForm;
