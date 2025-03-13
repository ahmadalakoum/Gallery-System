import React ,{useState,useEffect}from 'react'
import NavBar from "../components/NavBar";
import { getPhotos,deletePhoto,searchPhotos } from '../services/api';
import "./Home.css";
import { Link } from 'react-router-dom';
const Home = () => {
  const [photos, setPhotos] = useState([]);
  const [error,setError]=useState('');

  useEffect(() => {
    const fetchPhotos = async () => {
      const data = await getPhotos();
      if (data.status==="success") {
        setPhotos(data.photos);
      }else{
        setError(data.message);
      }
    };

    fetchPhotos();
  }, []);

  const handleSearch = async (query) => {
    if (query.trim() === "") {
      const data = await getPhotos(); // Get all photos if query is empty
      setPhotos(data.photos);
      setError('');
    } else {
      const data = await searchPhotos(query);
      if (data.status === "success") {
        setPhotos(data.photos);
      } else {
        setPhotos([]);
        setError(data.message);
      }
    }
  };


  // Handle photo deletion
  const handleDelete = async (photoId) => {
    const data = await deletePhoto(photoId);
    console.log(data);
    if (data.status === "success") {
      setPhotos(photos.filter(photo => photo.id !== photoId));
    } else{
      setError(data.message);
    }
  };
  return (
    <div>
      <NavBar onSearch={handleSearch} />
      <div className='photo-gallery'>
        {photos.length > 0 ? (
          photos.map((photo) => (
            <div key={photo.id} className="photo-card">
              <img src={`data:image/png;base64,${photo.image}`} alt={photo.title} />
              <h3>{photo.title}</h3>
              <p>{photo.description}</p>
              <p>{photo.tags}</p>
              <div className='actions'>
              <Link to={`/photo/${photo.id}`}>
                <button>View</button>
              </Link>
              <Link to={`/update/${photo.id}`}>
                <button>Update</button>
              </Link>
              <button onClick={() => handleDelete(photo.id)}>Delete</button>
              </div>
            </div>
          ))
        ) : (
          <div className="error-message">{error}</div>
        )}
      </div>
  


    </div>
    
  )
}

export default Home