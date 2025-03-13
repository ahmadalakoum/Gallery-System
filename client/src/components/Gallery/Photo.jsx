import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { getPhoto } from '../../services/api';
import NavBar from '../NavBar';
import "./Photo.css";
const Photo = () => {
    const { id } = useParams(); 
    const [photo, setPhoto] = useState(null);
    const [error, setError] = useState('');
    useEffect(() => {
        const fetchPhoto = async () => {
          const data = await getPhoto(id);
          console.log(data);
          if (data.status === "success") {
            setPhoto(data.photo);
          } else {
            setError(data.message);
          }
        };
    
        fetchPhoto();
      }, [id]);

      if (error) {
        return <p className="error-message">{error}</p>;
      }
    
      if (!photo) {
        return <p>Loading photo...</p>;
      }
  return (
    <div>
      <NavBar />
      <div className="photo-detail">
        <h2>{photo.title}</h2>
        <img src={`data:image/png;base64,${photo.image}`} alt={photo.title} />
        <p>{photo.description}</p>
        <p>{photo.tags}</p>
      </div>
    </div>
  )
}

export default Photo