import React from 'react';
import {BrowserRouter, Route , Routes} from "react-router-dom";
import Home from "./pages/Home";
import Login from './pages/Login';
import Signup from './pages/Signup';
import AddPhoto from './pages/AddPhoto';
import Photo from './components/Gallery/Photo';
import "./App.css";
const App = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Home/>}/>
        <Route path="/login" element={<Login/>}/>
        <Route path="/add" element={<AddPhoto/>}/>
        <Route path="/signup" element={<Signup/>}/>
        <Route path="/photo/:id" element={<Photo/>}/>


      </Routes>
    </BrowserRouter>
  )
}

export default App