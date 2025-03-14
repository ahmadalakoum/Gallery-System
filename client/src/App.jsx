import React from 'react';
import {BrowserRouter, Route , Routes} from "react-router-dom";
import Home from "./pages/Home";
import Login from './pages/Login';
import Signup from './pages/Signup';
import AddPhoto from './pages/AddPhoto';
import Photo from './components/Gallery/Photo';
import "./App.css";
import UpdatePhoto from './pages/UpdatePhoto';
import PrivateRoute from './services/PrivateRoute';
const App = () => {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/login" element={<Login/>}/>
        <Route path="/signup" element={<Signup/>}/>
        <Route element={<PrivateRoute/>}>
          <Route path="/" element={<Home/>}/>
          <Route path="/add" element={<AddPhoto/>}/>
          <Route path="/photo/:id" element={<Photo/>}/>
          <Route path="/update/:id" element={<UpdatePhoto/>}/>
        </Route>
        


      </Routes>
    </BrowserRouter>
  )
}

export default App