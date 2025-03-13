import React, { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import { getPhoto,updatePhoto } from "../../services/api";
import { useNavigate } from "react-router-dom";
import "./AddForm.css";
const UpdateForm = () => {
  const navigate=useNavigate();
    const { id }=useParams(); 
  const [photo, setPhoto] = useState({
    title: "",
    description: "",
    tags: "",
    image: "",
  });
       const [error,setError]=useState('');

  const [selectedImage, setSelectedImage] = useState(null);

  useEffect(() => {
    const fetchPhoto = async () => {
      try {
        const data = await getPhoto(id);
        console.log(id);
        if (data.status === "success") {
          setPhoto({
            title: data.photo.title,
            description: data.photo.description,
            tags: data.photo.tags,
            image: data.photo.image,
          });
        } else {
          setError(data.message);
        }
      } catch (error) {
        console.error("Error fetching photo:", error);
      }
    };

    fetchPhoto();
  }, [id]);

  // Handle input change
  const handleChange = (e) => {
    setPhoto({ ...photo, [e.target.name]: e.target.value });
  };

  // Handle image selection
  const handleImageChange = (e) => {
    const image = e.target.files[0];
    if (image) {
        const reader = new FileReader();

        reader.onloadend = () => {
            const base64Image = reader.result.split(',')[1];
            setSelectedImage(base64Image);  
        };
        
        reader.readAsDataURL(image); 
    }
};

  // Handle form submission
  const handleSubmit = async (e) => {
    e.preventDefault();

    const response = await updatePhoto(id,{...photo,image:selectedImage});
    console.log(response);
    if(response.status ==='success'){
        navigate('/');
    }else{
        setError(response.message);
    }

   
  };

  return (
    <div className='add-form-container'>
      <form onSubmit={handleSubmit}>
        <h2>Update Photo</h2>
        <input
          type="text"
          name="title"
          placeholder="Title"
          value={photo.title}
          onChange={handleChange}
        />
        <input
        type="text"
          name="description"
          placeholder="Description"
          value={photo.description}
          onChange={handleChange}
        />
        <input
          type="text"
          name="tags"
          placeholder="Tags (comma-separated)"
          value={photo.tags}
          onChange={handleChange}
        />

        <div>
            <p>Current Image:</p>
            <img src={`data:image/png;base64,${photo.image}`} alt="Photo" width="200px" />
          </div>

        

        <input type="file" name="image" onChange={handleImageChange} />
        <button type="submit">Update Photo</button>
      </form>
      {error && <div className="error-message">{error}</div>}

    </div>
  );
};

export default UpdateForm;
